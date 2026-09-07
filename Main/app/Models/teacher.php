<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'first_name',
        'last_name',
        'middle_name',
        'contact_number',
        'address',
    ];

    /**
     * A teacher belongs to one user account.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}