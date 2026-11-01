<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            FacultySeeder::class,      // khoa, ngành, lớp
            AcademicSeeder::class,     // môn học, học kỳ
            UserSeeder::class,         // admin, giảng viên, sinh viên
            CourseSectionSeeder::class // lớp học phần, đăng ký, điểm, điểm danh, thông báo
        ]);
    }
}
