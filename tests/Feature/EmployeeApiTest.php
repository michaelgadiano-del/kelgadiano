<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class EmployeeApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_endpoints_require_a_sanctum_token(): void
    {
        $this->getJson('/api/v1/employees')->assertUnauthorized();
        $this->postJson('/api/v1/employees', [])->assertUnauthorized();
    }

    public function test_browser_api_playground_is_available_and_lists_departments(): void
    {
        $department = $this->createDepartment();

        $this->actingAs(User::factory()->create())
            ->get('/api-playground')
            ->assertOk()
            ->assertSee('Employee API Playground')
            ->assertSee($department->name)
            ->assertSee('Connect to API')
            ->assertSee('href="'.route('api.playground').'"', false)
            ->assertSee('>API Playground</a>', false);
    }

    public function test_token_can_be_issued_and_employee_list_is_paginated_and_shaped(): void
    {
        $department = $this->createDepartment();
        Employee::factory()->count(12)->create(['department_id' => $department->id]);
        $token = $this->issueToken();

        $this->withToken($token)
            ->getJson('/api/v1/employees')
            ->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('meta.per_page', 10)
            ->assertJsonPath('data.0.department.name', $department->name)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'employee_number',
                    'first_name',
                    'last_name',
                    'full_name',
                    'email',
                    'department' => ['id', 'name', 'code'],
                ]],
                'links',
                'meta',
            ])
            ->assertJsonMissingPath('data.0.password');
    }

    public function test_employee_crud_returns_rest_status_codes_and_update_ignores_its_own_unique_values(): void
    {
        $department = $this->createDepartment();
        $token = $this->issueToken();
        $employeeData = $this->employeeData($department);

        $created = $this->withToken($token)
            ->postJson('/api/v1/employees', $employeeData)
            ->assertCreated()
            ->assertJsonPath('data.employee_number', 'EMP-API-001')
            ->assertJsonPath('data.department.code', $department->code);

        $employeeId = $created->json('data.id');

        $this->withToken($token)
            ->getJson("/api/v1/employees/{$employeeId}")
            ->assertOk()
            ->assertJsonPath('data.email', 'api.employee@example.test');

        $this->withToken($token)
            ->putJson("/api/v1/employees/{$employeeId}", $this->employeeData($department, [
                'position' => 'Senior Developer',
            ]))
            ->assertOk()
            ->assertJsonPath('data.employee_number', 'EMP-API-001')
            ->assertJsonPath('data.email', 'api.employee@example.test')
            ->assertJsonPath('data.position', 'Senior Developer');

        $this->withToken($token)
            ->deleteJson("/api/v1/employees/{$employeeId}")
            ->assertNoContent();

        $this->assertDatabaseMissing('employees', ['id' => $employeeId]);
        $this->withToken($token)->getJson("/api/v1/employees/{$employeeId}")->assertNotFound();
    }

    public function test_invalid_employee_data_returns_json_422_errors(): void
    {
        $department = $this->createDepartment();
        $token = $this->issueToken();
        $employee = Employee::factory()->create([
            'department_id' => $department->id,
            'email' => 'existing@example.test',
        ]);

        $this->withToken($token)
            ->postJson('/api/v1/employees', $this->employeeData($department, [
                'employee_number' => $employee->employee_number,
                'email' => $employee->email,
            ]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['employee_number', 'email']);
    }

    public function test_token_can_be_revoked_and_invalid_credentials_are_rejected(): void
    {
        $user = User::factory()->create();

        $this->postJson('/api/v1/tokens', [
            'email' => $user->email,
            'password' => 'incorrect-password',
            'device_name' => 'postman',
        ])->assertUnauthorized();

        $token = $this->issueToken($user);

        $this->withToken($token)
            ->deleteJson('/api/v1/tokens/current')
            ->assertNoContent();

        $this->assertDatabaseCount('personal_access_tokens', 0);
        Auth::forgetGuards();
        $this->withToken($token)->getJson('/api/v1/employees')->assertUnauthorized();
    }

    private function issueToken(?User $user = null): string
    {
        $user ??= User::factory()->create();

        return $this->postJson('/api/v1/tokens', [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'phpunit',
        ])->assertCreated()->json('token');
    }

    private function createDepartment(): Department
    {
        return Department::create([
            'name' => 'Computer Studies',
            'code' => 'CCS',
        ]);
    }

    private function employeeData(Department $department, array $overrides = []): array
    {
        return array_merge([
            'employee_number' => 'EMP-API-001',
            'first_name' => 'Alex',
            'last_name' => 'Rivera',
            'email' => 'api.employee@example.test',
            'phone' => '09171234567',
            'position' => 'Developer',
            'hire_date' => '2024-01-15',
            'salary' => 42000.50,
            'status' => 'Active',
            'department_id' => $department->id,
        ], $overrides);
    }
}
