<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Student extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'email_verified_at',
        'registration',
        'course_id'
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['course'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function disciplines()
    {
        return $this->belongsToMany(
            Discipline::class,
            'disciplines_students',
            'student_id',
            'discipline_id'
        )
        ->withPivot(['status', 'final_grade'])
        ->withTimestamps();
    }

    public function supportContacts()
    {
        return $this->hasMany(Support::class, 'student_id', 'id');
    }

    public function addFeedback(string $message): void
    {
        $this->supportContacts()->create([
            'message' => $message
        ]);
    }
}
