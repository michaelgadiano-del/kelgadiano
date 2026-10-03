<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'employee_number' => fake()->unique()->numerify('EMP-####'),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'position' => fake()->randomElement([
                'Administrative Assistant', 'Accountant', 'HR Officer',
                'IT Specialist', 'Marketing Officer', 'Office Manager',
            ]),
            'hire_date' => fake()->dateTimeBetween('-8 years', '-1 month'),
            'salary' => fake()->randomFloat(2, 18000, 65000),
            'status' => fake()->randomElement(['Active', 'Active', 'Active', 'On Leave']),
            'department_id' => Department::inRandomOrder()->value('id'),
        ];
    }
}
