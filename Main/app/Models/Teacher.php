<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Authenticatable
{
    use Notifiable;

    protected $table = 'teachers';

    protected $fillable = [
        'user_id',
        'employee_id',
        'first_name',
        'last_name',
        'middle_name',
        'contact_number',
        'address',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // A teacher can manage multiple classes.
    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class, 'teacher_id');
    }

    // A teacher can record multiple attendance entries.
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'teacher_id');
    }

    // A teacher can record multiple grades.
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class, 'teacher_id');
    }

    // A teacher can have multiple grading configurations.
    public function gradingConfigurations(): HasMany
    {
        return $this->hasMany(GradingConfiguration::class, 'teacher_id');
    }

    // A teacher can create multiple assessment activities.
    public function assessmentActivities(): HasMany
    {
        return $this->hasMany(AssessmentActivity::class, 'teacher_id');
    }

    /**
     * A teacher can have multiple messages.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'teacher_id');
    }
}
