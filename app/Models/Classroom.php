<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Không đặt tên "Class" vì trùng từ khoá PHP
class Classroom extends Model
{
    protected $table = 'classes';

    protected $fillable = ['major_id', 'name', 'cohort'];

    public function major(): BelongsTo { return $this->belongsTo(Major::class); }
    public function students(): HasMany { return $this->hasMany(Student::class, 'class_id'); }
}
