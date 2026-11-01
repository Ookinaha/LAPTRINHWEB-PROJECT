<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semester extends Model
{
    protected $fillable = ['name', 'school_year', 'start_date', 'end_date', 'is_current'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    public function courseSections(): HasMany { return $this->hasMany(CourseSection::class); }

    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }
}
