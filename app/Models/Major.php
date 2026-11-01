<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Major extends Model
{
    protected $fillable = ['faculty_id', 'code', 'name'];

    public function faculty(): BelongsTo { return $this->belongsTo(Faculty::class); }
    public function classes(): HasMany { return $this->hasMany(Classroom::class); }
}
