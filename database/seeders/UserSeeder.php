<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Faculty;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Tất cả tài khoản mẫu dùng mật khẩu: password
 *  - admin@example.com
 *  - gv1@example.com ... gv3@example.com
 *  - sv1@example.com ... sv12@example.com
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Quản trị viên',
            'password' => 'password',
            'role' => User::ROLE_ADMIN,
        ]);

        $cntt = Faculty::where('code', 'CNTT')->first();
        $degrees = ['ThS', 'TS', 'ThS'];
        $lecturerNames = ['Trần Văn An', 'Lê Thị Bình', 'Phạm Quốc Cường'];

        foreach ($lecturerNames as $i => $name) {
            $n = $i + 1;
            $user = User::firstOrCreate(['email' => "gv{$n}@example.com"], [
                'name' => $name,
                'password' => 'password',
                'role' => User::ROLE_LECTURER,
            ]);

            Lecturer::firstOrCreate(['user_id' => $user->id], [
                'lecturer_code' => sprintf('GV%03d', $n),
                'faculty_id' => $cntt->id,
                'degree' => $degrees[$i],
            ]);
        }

        $classes = Classroom::orderBy('id')->get();
        $studentNames = [
            'Nguyễn Đình Huy', 'Nguyễn Minh Anh', 'Trần Quang Bảo', 'Lê Hoài Châu',
            'Phạm Gia Hân', 'Hoàng Đức Khang', 'Vũ Thu Lan', 'Đặng Minh Nhật',
            'Bùi Thanh Phương', 'Ngô Anh Quân', 'Đỗ Khánh Linh', 'Dương Tuấn Kiệt',
        ];

        foreach ($studentNames as $i => $name) {
            $n = $i + 1;
            $user = User::firstOrCreate(['email' => "sv{$n}@example.com"], [
                'name' => $name,
                'password' => 'password',
                'role' => User::ROLE_STUDENT,
            ]);

            Student::firstOrCreate(['user_id' => $user->id], [
                'student_code' => sprintf('SV%05d', $n),
                'class_id' => $classes[$i % $classes->count()]->id,
                'dob' => now()->subYears(20)->subDays($n * 17)->toDateString(),
            ]);
        }
    }
}
