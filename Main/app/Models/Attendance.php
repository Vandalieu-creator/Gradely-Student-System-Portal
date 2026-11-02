<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'class_id',
        'teacher_id',
        'attendance_date',
        'status',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'attendance_date' => 'date',
        ];
    }

    // Attendance belongs to one student.
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    // Attendance belongs to one class.
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    // Attendance belongs to one teacher.
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
