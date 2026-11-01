<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Faculty;
use App\Models\Major;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    public function run(): void
    {
        $cntt = Faculty::firstOrCreate(['code' => 'CNTT'], ['name' => 'Công nghệ thông tin']);
        $kt = Faculty::firstOrCreate(['code' => 'KT'], ['name' => 'Kinh tế']);

        $majors = [
            ['faculty' => $cntt, 'code' => 'KTPM', 'name' => 'Kỹ thuật phần mềm'],
            ['faculty' => $cntt, 'code' => 'HTTT', 'name' => 'Hệ thống thông tin'],
            ['faculty' => $kt, 'code' => 'QTKD', 'name' => 'Quản trị kinh doanh'],
        ];

        foreach ($majors as $m) {
            $major = Major::firstOrCreate(
                ['code' => $m['code']],
                ['faculty_id' => $m['faculty']->id, 'name' => $m['name']]
            );

            foreach (['K22' => '22', 'K23' => '23'] as $cohort => $suffix) {
                Classroom::firstOrCreate(
                    ['name' => $m['code'] . $suffix . '01'],
                    ['major_id' => $major->id, 'cohort' => $cohort]
                );
            }
        }
    }
}
