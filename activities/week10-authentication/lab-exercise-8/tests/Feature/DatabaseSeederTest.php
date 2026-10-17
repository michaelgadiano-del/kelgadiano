<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_demo_roles_and_owned_courses(): void
    {
        $this->seed();

        $this->assertDatabaseHas('users', ['email' => 'admin@example.com', 'role' => 'admin']);
        $this->assertDatabaseHas('users', ['email' => 'ana@example.com', 'role' => 'instructor']);
        $this->assertDatabaseHas('users', ['email' => 'ben@example.com', 'role' => 'instructor']);
        $this->assertDatabaseHas('users', ['email' => 'carla@example.com', 'role' => 'student']);
        $this->assertSame(6, Course::count());
        $this->assertSame(1, Course::where('is_active', false)->count());
        $this->assertSame(1, Course::whereHas('students')->count());
        $this->assertTrue(User::where('email', 'ana@example.com')->firstOrFail()->courses()->exists());

        $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ])->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticatedAs(User::where('email', 'admin@example.com')->firstOrFail());
    }
}
