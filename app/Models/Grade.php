<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    protected $fillable = ['enrollment_id', 'midterm', 'final', 'total'];

    protected $casts = [
        'midterm' => 'float',
        'final' => 'float',
        'total' => 'float',
    ];

    protected static function booted(): void
    {
        // Tự tính điểm tổng kết khi có đủ giữa kỳ + cuối kỳ (40% / 60%)
        static::saving(function (Grade $g) {
            $g->total = ($g->midterm !== null && $g->final !== null)
                ? round($g->midterm * 0.4 + $g->final * 0.6, 2)
                : null;
        });
    }

    public function enrollment(): BelongsTo { return $this->belongsTo(Enrollment::class); }

    /** Quy đổi điểm 10 -> thang 4 */
    public function gradePoint(): float
    {
        $t = $this->total ?? 0;

        return match (true) {
            $t >= 8.5 => 4.0,
            $t >= 8.0 => 3.5,
            $t >= 7.0 => 3.0,
            $t >= 6.5 => 2.5,
            $t >= 5.5 => 2.0,
            $t >= 5.0 => 1.5,
            $t >= 4.0 => 1.0,
            default => 0.0,
        };
    }

    /** Điểm chữ */
    public function letter(): string
    {
        $t = $this->total ?? 0;

        return match (true) {
            $t >= 8.5 => 'A',
            $t >= 8.0 => 'B+',
            $t >= 7.0 => 'B',
            $t >= 6.5 => 'C+',
            $t >= 5.5 => 'C',
            $t >= 5.0 => 'D+',
            $t >= 4.0 => 'D',
            default => 'F',
        };
    }
}
