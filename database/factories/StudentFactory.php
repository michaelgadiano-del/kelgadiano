<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_number' => fake()->unique()->numerify('2026-#####'),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('09#########'),
            'birth_date' => fake()->dateTimeBetween('-24 years', '-17 years'),
            'year_level' => fake()->numberBetween(1, 4),
            'department_id' => Department::inRandomOrder()->first()->id,
        ];
    }
}
