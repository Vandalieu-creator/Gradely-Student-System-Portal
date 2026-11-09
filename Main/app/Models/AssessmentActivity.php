<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentActivity extends Model
{
    protected $fillable = [
        'class_id',
        'teacher_id',
        'subject',
        'quarter',
        'school_year',
        'category',
        'activity_name',
        'max_score',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'max_score' => 'decimal:2',
            'sort_order' => 'integer',
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

    public function scores(): HasMany
    {
        return $this->hasMany(
            StudentAssessmentScore::class,
            'assessment_activity_id'
        );
    }
}
