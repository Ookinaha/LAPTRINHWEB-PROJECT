<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $fillable = ['author_id', 'course_section_id', 'title', 'content'];

    public function author(): BelongsTo { return $this->belongsTo(User::class, 'author_id'); }
    public function courseSection(): BelongsTo { return $this->belongsTo(CourseSection::class); }
}
