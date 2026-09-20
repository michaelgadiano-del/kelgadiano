<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DepartmentSeeder::class);

        $courses = Course::factory(8)->create();

        Student::factory(30)->create()->each(function (Student $student) use ($courses): void {
            foreach ($courses->random(3) as $course) {
                $student->courses()->attach($course, [
                    'grade' => fake()->randomElement([1.00, 1.25, 1.50, 1.75, 2.00, 2.50, 3.00, null]),
                ]);
            }
        });
    }
}
