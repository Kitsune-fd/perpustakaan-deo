<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function shelf(): BelongsTo
    {
        return $this->belongsTo(Shelf::class);
    }

    public function stockAvailable(): Attribute
    {
        return Attribute::make(
            get: function () {
                $loanedCount = $this->loans()->where('status', Status::LOANED)->count();
                return max(0, $this->stock_total - $loanedCount);
            }
        );
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function scopeFilterable($query, $filters)
    {
        if (isset($filters['search']) && $filters['search'] !== '') {
            $query->where('title', 'like', '%' . $filters['search'] . '%')
                ->orWhere('author', 'like', '%' . $filters['search'] . '%');
        }

        if (isset($filters['category_id']) && $filters['category_id'] !== '') {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['shelf_id']) && $filters['shelf_id'] !== '') {
            $query->where('shelf_id', $filters['shelf_id']);
        }

        if(isset($filters['available']) && $filters['available'] !== '') {
            if ($filters['available'] == '1') {
                $query->whereRaw('stock_total > (SELECT COUNT(*) FROM loans WHERE loans.book_id = books.id AND loans.status = ?)', [Status::LOANED]);
            } else {
                $query->whereRaw('stock_total <= (SELECT COUNT(*) FROM loans WHERE loans.book_id = books.id AND loans.status = ?)', [Status::LOANED]);
            }
        }

        return $query;
    }
}
