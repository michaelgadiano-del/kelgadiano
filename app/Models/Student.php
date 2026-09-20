<?php

namespace App\Models;

use Database\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    /** @use HasFactory<StudentFactory> */
    use HasFactory;

    protected $fillable = [
        'student_number', 'first_name', 'last_name', 'email', 'phone',
        'birth_date', 'year_level', 'department_id',
    ];

    protected function casts(): array
    {
        return ['birth_date' => 'date'];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)->withPivot('grade')->withTimestamps();
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
