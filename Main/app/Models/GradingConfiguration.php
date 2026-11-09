<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradingConfiguration extends Model
{
    protected $fillable = [
        'class_id',
        'teacher_id',
        'subject',
        'quarter',
        'school_year',
        'grading_framework',
        'written_work_weight',
        'performance_task_weight',
        'quarterly_assessment_weight',
    ];

    protected function casts(): array
    {
        return [
            'written_work_weight' => 'decimal:2',
            'performance_task_weight' => 'decimal:2',
            'quarterly_assessment_weight' => 'decimal:2',
        ];
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
