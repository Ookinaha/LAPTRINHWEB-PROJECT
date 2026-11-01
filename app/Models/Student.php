<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = ['user_id', 'student_code', 'class_id', 'dob', 'address'];

    protected $casts = ['dob' => 'date'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function classroom(): BelongsTo { return $this->belongsTo(Classroom::class, 'class_id'); }
    public function enrollments(): HasMany { return $this->hasMany(Enrollment::class); }

    public function courseSections(): BelongsToMany
    {
        return $this->belongsToMany(CourseSection::class, 'enrollments')
            ->using(Enrollment::class)
            ->withPivot('id')
            ->withTimestamps();
    }

    /**
     * GPA hệ 4, tính theo tín chỉ. Chỉ tính các môn đã có điểm tổng kết.
     */
    public function gpa(): ?float
    {
        $rows = $this->enrollments()
            ->with(['grade', 'courseSection.subject'])
            ->get()
            ->filter(fn ($e) => $e->grade && $e->grade->total !== null);

        $credits = $rows->sum(fn ($e) => $e->courseSection->subject->credits);
        if ($credits === 0) {
            return null;
        }

        $points = $rows->sum(fn ($e) => $e->grade->gradePoint() * $e->courseSection->subject->credits);

        return round($points / $credits, 2);
    }
}
