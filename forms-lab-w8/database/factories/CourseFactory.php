<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        return [
            'instructor_id' => Instructor::factory(),
            'code' => strtoupper(fake()->unique()->bothify('??????#')),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'units' => fake()->numberBetween(1, 6),
            'is_active' => true,
            'image_path' => null,
        ];
    }
}
