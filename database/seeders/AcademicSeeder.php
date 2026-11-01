<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\Semester;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class AcademicSeeder extends Seeder
{
    public function run(): void
    {
        $cntt = Faculty::where('code', 'CNTT')->first();

        $subjects = [
            ['IT101', 'Lập trình căn bản', 3],
            ['IT102', 'Cấu trúc dữ liệu và giải thuật', 3],
            ['IT201', 'Cơ sở dữ liệu', 3],
            ['IT202', 'Lập trình web', 3],
            ['IT301', 'Hệ thống thanh toán điện tử', 2],
            ['GE101', 'Lịch sử Đảng Cộng sản Việt Nam', 2],
        ];

        foreach ($subjects as [$code, $name, $credits]) {
            Subject::firstOrCreate(
                ['code' => $code],
                ['name' => $name, 'credits' => $credits, 'faculty_id' => str_starts_with($code, 'IT') ? $cntt->id : null]
            );
        }

        Semester::firstOrCreate(
            ['name' => 'Học kỳ 1', 'school_year' => '2025-2026'],
            ['start_date' => '2025-09-01', 'end_date' => '2026-01-15', 'is_current' => false]
        );
        Semester::firstOrCreate(
            ['name' => 'Học kỳ 1', 'school_year' => '2026-2027'],
            ['start_date' => '2026-09-01', 'end_date' => '2027-01-15', 'is_current' => true]
        );
    }
}
