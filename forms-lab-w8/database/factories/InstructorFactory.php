<?php

namespace Database\Factories;

use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instructor>
 */
class InstructorFactory extends Factory
{
    protected $model = Instructor::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
