<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'teacher_id',
        'class_name',
        'grade_level',
        'section',
        'school_year',
        'room',
    ];

    // A class belongs to one teacher.
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    // A class can have many students.
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    // A class can have many attendance records.
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }

    // A class can have many grade records.
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class, 'class_id');
    }
}
