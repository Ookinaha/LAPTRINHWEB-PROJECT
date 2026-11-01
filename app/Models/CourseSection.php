<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseSection extends Model
{
    protected $fillable = [
        'code', 'subject_id', 'semester_id', 'lecturer_id',
        'day_of_week', 'start_period', 'end_period', 'room',
        'max_students', 'is_open',
    ];

    protected $casts = ['is_open' => 'boolean'];

    public function subject(): BelongsTo { return $this->belongsTo(Subject::class); }
    public function semester(): BelongsTo { return $this->belongsTo(Semester::class); }
    public function lecturer(): BelongsTo { return $this->belongsTo(Lecturer::class); }
    public function enrollments(): HasMany { return $this->hasMany(Enrollment::class); }
    public function announcements(): HasMany { return $this->hasMany(Announcement::class); }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'enrollments')
            ->using(Enrollment::class)
            ->withPivot('id')
            ->withTimestamps();
    }

    public function isFull(): bool
    {
        return $this->enrollments()->count() >= $this->max_students;
    }
}
