# Cấu trúc database (giai đoạn 2)

Quy ước: tên bảng số nhiều snake_case, khoá ngoại dạng `xxx_id`. Mật khẩu mọi tài khoản mẫu: `password`.

```
users: id, name, email, password, role(admin|lecturer|student), phone, is_active
faculties: id, code, name
majors: id, faculty_id→faculties, code, name
classes: id, major_id→majors, name, cohort            (Model: Classroom)
lecturers: id, user_id→users, lecturer_code, faculty_id→faculties, degree
students: id, user_id→users, student_code, class_id→classes, dob, address
subjects: id, faculty_id→faculties(null), code, name, credits
semesters: id, name, school_year, start_date, end_date, is_current
course_sections: id, code, subject_id, semester_id, lecturer_id(null), day_of_week(2-8), start_period, end_period, room, max_students, is_open
enrollments: id, student_id, course_section_id            (unique cặp student + section)
grades: id, enrollment_id(unique), midterm, final, total  (total tự tính = 40% GK + 60% CK)
attendances: id, enrollment_id, date, status(present|absent|late|excused), note
announcements: id, author_id→users, course_section_id(null = thông báo chung), title, content
```

## Quan hệ Eloquent chính
- User hasOne Student / Lecturer; hasMany Announcement (author_id)
- Faculty hasMany Major, Lecturer, Subject; Major hasMany Classroom; Classroom hasMany Student
- CourseSection belongsTo Subject, Semester, Lecturer; hasMany Enrollment, Announcement
- Student belongsToMany CourseSection (qua enrollments); CourseSection belongsToMany Student
- Enrollment hasOne Grade; hasMany Attendance
- `Student::gpa()` tính GPA hệ 4 theo tín chỉ; `Grade::gradePoint()` / `Grade::letter()`

## Tài khoản mẫu
admin@example.com | gv1..gv3@example.com | sv1..sv12@example.com

## Lệnh chạy
php artisan migrate:fresh --seed
