<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\CourseSection;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Lecturer;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSectionSeeder extends Seeder
{
    public function run(): void
    {
        $lecturers = Lecturer::orderBy('id')->get();
        $students = Student::orderBy('id')->get();
        $admin = User::where('role', User::ROLE_ADMIN)->first();

        $old = Semester::where('school_year', '2025-2026')->first();
        $current = Semester::current()->first();

        // [mã môn, học kỳ, thứ, tiết bắt đầu, tiết kết thúc, phòng]
        $plan = [
            ['IT101', $old, 2, 1, 3, 'A101'],
            ['IT102', $old, 3, 4, 6, 'A102'],
            ['IT201', $current, 4, 1, 3, 'B201'],
            ['IT202', $current, 5, 4, 6, 'B202'],
            ['IT301', $current, 6, 1, 2, 'C301'],
        ];

        foreach ($plan as $i => [$subjectCode, $semester, $day, $start, $end, $room]) {
            $subject = Subject::where('code', $subjectCode)->first();

            $section = CourseSection::firstOrCreate(
                ['code' => $subjectCode . '-01-' . $semester->school_year],
                [
                    'subject_id' => $subject->id,
                    'semester_id' => $semester->id,
                    'lecturer_id' => $lecturers[$i % $lecturers->count()]->id,
                    'day_of_week' => $day,
                    'start_period' => $start,
                    'end_period' => $end,
                    'room' => $room,
                    'max_students' => 40,
                    'is_open' => $semester->is_current,
                ]
            );

            // đăng ký: học kỳ cũ cho tất cả sinh viên + có điểm, học kỳ hiện tại cho 8 sinh viên đầu
            $enrolled = $semester->is_current ? $students->take(8) : $students;

            foreach ($enrolled as $s => $student) {
                $enrollment = Enrollment::firstOrCreate([
                    'student_id' => $student->id,
                    'course_section_id' => $section->id,
                ]);

                if (! $semester->is_current) {
                    Grade::firstOrCreate(['enrollment_id' => $enrollment->id], [
                        'midterm' => round(5 + (($s * 7 + $i * 3) % 50) / 10, 1),
                        'final' => round(5 + (($s * 11 + $i * 5) % 50) / 10, 1),
                    ]);
                }

                // điểm danh 3 buổi gần đây
                foreach ([0, 7, 14] as $k => $daysAgo) {
                    $statuses = ['present', 'present', 'late', 'absent'];
                    Attendance::firstOrCreate(
                        ['enrollment_id' => $enrollment->id, 'date' => now()->subDays($daysAgo)->toDateString()],
                        ['status' => $statuses[($s + $k) % 4]]
                    );
                }
            }

            Announcement::firstOrCreate(
                ['course_section_id' => $section->id, 'title' => 'Thông báo lớp ' . $subject->name],
                [
                    'author_id' => $section->lecturer->user_id,
                    'content' => 'Sinh viên chuẩn bị tài liệu và xem trước nội dung buổi học tới.',
                ]
            );
        }

        Announcement::firstOrCreate(['course_section_id' => null, 'title' => 'Chào mừng học kỳ mới'], [
            'author_id' => $admin->id,
            'content' => 'Sinh viên đăng ký học phần trước hạn chót theo kế hoạch của phòng đào tạo.',
        ]);
    }
}
