<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lecturer extends Model
{
    protected $fillable = ['user_id', 'lecturer_code', 'faculty_id', 'degree'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function faculty(): BelongsTo { return $this->belongsTo(Faculty::class); }
    public function courseSections(): HasMany { return $this->hasMany(CourseSection::class); }
}
