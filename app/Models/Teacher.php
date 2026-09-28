<?php

namespace App\Models;

use App\Enums\Education;
use App\Enums\Subject;
use App\Http\Controllers\Admin\SubjectHistoryController;
use App\Models\Scopes\ActiveScope;
use Dom\Attr;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    protected $casts = [
        'birthdate' => 'date',
        'is_active' => 'boolean',
        'subject' => Subject::class,
        'last_education' => Education::class,
    ];

    protected $keyType = 'string';      // Key type is a string
    public $incrementing = false;       // Disable auto-incrementing
    protected $primaryKey = 'id';
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function scopeInActive($query)
    {
        return $query->where('is_active', false);
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    public function statusLabel(): string
    {
        return $this->is_active ? 'Aktif Mengajar' : 'Nonaktif Mengajar';
    }

    public function statusLabelShort(): Attribute
    {
        return new Attribute(
            get: fn () => $this->is_active ? 'Aktif' : 'Nonaktif',
        );
    }

    public function genderLabel(): Attribute
    {
        return new Attribute(
            get: fn () => $this->gender == 'male' ? 'Laki-laki' : 'Perempuan',
        );
    }

    public function educationHistories(): HasMany
    {
        return $this->hasMany(EducationHistory::class, 'teacher_id', 'id');
    }

    public function jobHistories(): HasMany
    {
        return $this->hasMany(JobHistory::class, 'teacher_id', 'id');
    }

    public function teachingHistories(): HasMany
    {
        return $this->hasMany(TeachingHistory::class, 'teacher_id', 'id');
    }

    public function filesCount(): Attribute
    {
        return new Attribute(
            get: fn () => $this->files()->count(),
        );
    }

    public function educationHistoriesCount(): Attribute
    {
        return new Attribute(
            get: fn () => $this->educationHistories()->count(),
        );
    }

    public function jobHistoriesCount(): Attribute
    {
        return new Attribute(
            get: fn () => $this->jobHistories()->count(),
        );
    }

    public function teachingHistoriesCount(): Attribute
    {
        return new Attribute(
            get: fn () => $this->teachingHistories()->count(),
        );
    }



}
