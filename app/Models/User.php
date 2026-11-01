<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_LECTURER = 'lecturer';
    public const ROLE_STUDENT = 'student';

    protected $fillable = ['name', 'email', 'password', 'role', 'phone', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function lecturer(): HasOne
    {
        return $this->hasOne(Lecturer::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class, 'author_id');
    }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function isAdmin(): bool { return $this->role === self::ROLE_ADMIN; }
    public function isLecturer(): bool { return $this->role === self::ROLE_LECTURER; }
    public function isStudent(): bool { return $this->role === self::ROLE_STUDENT; }
}
