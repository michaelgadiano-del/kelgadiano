<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User'],
        );

        $instructors = Instructor::query()->orderBy('id')->get();

        if ($instructors->isEmpty()) {
            $instructors = Instructor::factory()->count(4)->create();
        }

        $courseData = [
            ['code' => 'COMSCI1', 'title' => 'Introduction to Computing', 'description' => 'Foundational concepts in computer systems, computing history, and digital technology.', 'units' => 3],
            ['code' => 'PROGRA1', 'title' => 'Programming Fundamentals', 'description' => 'Problem solving, algorithms, and foundational programming concepts.', 'units' => 4],
            ['code' => 'WEBDEV3', 'title' => 'Web Development', 'description' => 'Building accessible, responsive websites with modern web technologies.', 'units' => 3],
            ['code' => 'DATBAS2', 'title' => 'Database Management Systems', 'description' => 'Relational data modeling, SQL, normalization, and database design.', 'units' => 3],
            ['code' => 'DATAST2', 'title' => 'Data Structures and Algorithms', 'description' => 'Core data structures, algorithm design, and computational complexity.', 'units' => 3],
            ['code' => 'COMNET3', 'title' => 'Computer Networks', 'description' => 'Network architecture, protocols, addressing, and data communication.', 'units' => 3],
            ['code' => 'SOFTEN2', 'title' => 'Software Engineering', 'description' => 'Software requirements, design, testing, teamwork, and maintenance.', 'units' => 3],
            ['code' => 'CYBER1', 'title' => 'Cybersecurity Fundamentals', 'description' => 'Security principles, common threats, and practical protection strategies.', 'units' => 3],
        ];

        $existingCourses = Course::query()->orderBy('id')->get();

        foreach ($courseData as $index => $attributes) {
            $course = $existingCourses->get($index) ?? new Course();
            $course->instructor_id ??= $instructors->get($index % $instructors->count())->id;
            $course->fill($attributes + ['is_active' => true]);
            $course->save();
        }
    }
}
