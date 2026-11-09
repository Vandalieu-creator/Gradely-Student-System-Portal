<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAssessmentScore extends Model
{
    protected $fillable = [
        'assessment_activity_id',
        'student_id',
        'score',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
        ];
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(
            AssessmentActivity::class,
            'assessment_activity_id'
        );
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
