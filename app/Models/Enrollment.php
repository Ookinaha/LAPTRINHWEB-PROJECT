<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Enrollment extends Pivot
{
    protected $table = 'enrollments';

    public $incrementing = true;

    protected $fillable = ['student_id', 'course_section_id'];

    public function student(): BelongsTo { return $this->belongsTo(Student::class); }
    public function courseSection(): BelongsTo { return $this->belongsTo(CourseSection::class); }
    public function grade(): HasOne { return $this->hasOne(Grade::class, 'enrollment_id'); }
public function attendances(): HasMany { return $this->hasMany(Attendance::class, 'enrollment_id'); }
}
