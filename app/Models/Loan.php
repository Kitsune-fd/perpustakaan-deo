<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'status' => Status::class,
        'loaned_date' => 'date',
        'returned_date' => 'date',
        'due_date' => 'date',
        'last_reminder_sent_at' => 'datetime',
        'fine_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function scopeIsActive($query)
    {
        return $query->whereIn('status', [Status::LOANED, Status::RESERVED]);
    }

    public function scopeIsLate($query)
    {
        return $query->where('due_date', '<', now())->where('status', Status::LOANED);
    }

    public function scopeIsHistory($query)
    {
        return  $query->whereIn('status', [Status::RETURNED, Status::CANCELED, Status::OVERDUE]);
    }
}
