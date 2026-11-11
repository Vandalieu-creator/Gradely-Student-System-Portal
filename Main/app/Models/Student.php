<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'lrn',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'address',
        'class_id',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    // A student belongs to one class.
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    // A student can have many attendance records.
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    // A student can have many grade records.
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    // A student can have multiple assessment scores.
    public function assessmentScores(): HasMany
    {
        return $this->hasMany(StudentAssessmentScore::class, 'student_id');
    }

    /**
     * A student can have multiple messages.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'student_id');
    }
}
