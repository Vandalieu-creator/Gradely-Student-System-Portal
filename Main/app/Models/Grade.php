<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'class_id',
        'teacher_id',
        'subject',
        'quarter',
        'school_year',
        'written_work',
        'performance_task',
        'quarterly_assessment',
        'initial_grade',
        'quarterly_grade',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'written_work' => 'decimal:2',
            'performance_task' => 'decimal:2',
            'quarterly_assessment' => 'decimal:2',
            'initial_grade' => 'decimal:2',
            'quarterly_grade' => 'decimal:2',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
