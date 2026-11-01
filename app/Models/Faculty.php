<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    protected $fillable = ['code', 'name'];

    public function majors(): HasMany { return $this->hasMany(Major::class); }
    public function lecturers(): HasMany { return $this->hasMany(Lecturer::class); }
    public function subjects(): HasMany { return $this->hasMany(Subject::class); }
}
