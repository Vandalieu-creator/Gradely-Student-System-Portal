<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherMessage extends Model
{
    protected $fillable = [
    'student_id',
    'student_user_id',
    'teacher_id',
    'sender',
    'message',
    'is_read',
    ];

    public function studentUser()
    {
        return $this->belongsTo(User::class, 'student_user_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}