<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $makeUser = static function (array $attributes): User {
            $role = $attributes['role'];
            unset($attributes['role']);

            $user = User::factory()->create($attributes);
            $user->forceFill(['role' => $role])->save();

            return $user;
        };

        $makeUser([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $ana = $makeUser([
            'name' => 'Ana Instructor',
            'email' => 'ana@example.com',
            'role' => 'instructor',
        ]);

        $ben = $makeUser([
            'name' => 'Ben Instructor',
            'email' => 'ben@example.com',
            'role' => 'instructor',
        ]);

        $carla = $makeUser([
            'name' => 'Carla Student',
            'email' => 'carla@example.com',
            'role' => 'student',
        ]);

        $anaCourses = Course::factory(2)->for($ana, 'owner')->create();
        Course::factory()->inactive()->for($ana, 'owner')->create();
        Course::factory(3)->for($ben, 'owner')->create();

        $anaCourses->first()->students()->attach($carla);
    }
}
