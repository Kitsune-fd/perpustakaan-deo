<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EducationHistory extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    protected $keyType = 'string';      // Key type is a string
    public $incrementing = false;       // Disable auto-incrementing
    protected $primaryKey = 'id';

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
