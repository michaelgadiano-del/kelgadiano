<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class EmployeeAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_routes_require_authentication(): void
    {
        $response = $this->get('/employees');

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_open_employee_routes(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/employees');

        $response->assertOk();
    }

    public function test_users_can_register_with_a_username_and_access_employees(): void
    {
        $response = $this->post('/register', [
            'name' => 'Demo User',
            'username' => 'demo_user',
            'email' => 'demo@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('employees.index'));
        $this->assertAuthenticated();
        $this->get(route('employees.create'))->assertOk();
    }

    public function test_users_can_log_in_with_username(): void
    {
        User::factory()->create(['username' => 'demo_user']);

        $response = $this->post('/login', [
            'username' => 'demo_user',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('employees.index'));
        $this->assertAuthenticated();
    }
}
