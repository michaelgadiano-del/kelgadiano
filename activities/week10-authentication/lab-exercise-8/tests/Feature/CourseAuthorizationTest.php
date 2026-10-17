<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_browse_active_courses_but_not_inactive_courses(): void
    {
        $owner = $this->userWithRole('instructor');
        $active = Course::factory()->for($owner, 'owner')->create();
        $inactive = Course::factory()->inactive()->for($owner, 'owner')->create();

        $this->get(route('courses.index'))->assertOk();
        $this->get(route('courses.show', $active))->assertOk();
        $this->get(route('courses.show', $inactive))->assertForbidden();
    }

    public function test_guest_is_redirected_from_course_creation(): void
    {
        $this->get(route('courses.create'))->assertRedirect(route('login'));
        $this->post(route('courses.store'))->assertRedirect(route('login'));
    }

    public function test_student_cannot_create_or_edit_courses(): void
    {
        $student = $this->userWithRole('student');
        $course = Course::factory()->create();

        $this->actingAs($student)
            ->get(route('courses.create'))
            ->assertForbidden();

        $this->get(route('courses.edit', $course))->assertForbidden();
        $this->get(route('admin.index'))->assertForbidden();
    }

    public function test_instructor_can_create_course_only_in_their_own_name(): void
    {
        $instructor = $this->userWithRole('instructor');
        $other = $this->userWithRole('instructor');

        $this->actingAs($instructor)
            ->post(route('courses.store'), [
                'code' => 'WEB101',
                'title' => 'Web Development',
                'units' => 3,
                'is_active' => 1,
                'user_id' => $other->id,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('courses', [
            'code' => 'WEB101',
            'user_id' => $instructor->id,
        ]);
    }

    public function test_instructor_can_update_only_their_own_course(): void
    {
        $owner = $this->userWithRole('instructor');
        $other = $this->userWithRole('instructor');
        $ownedCourse = Course::factory()->for($owner, 'owner')->create();
        $othersCourse = Course::factory()->for($other, 'owner')->create();

        $this->actingAs($owner)
            ->put(route('courses.update', $ownedCourse), [
                'code' => $ownedCourse->code,
                'title' => 'Updated course',
                'units' => 4,
                'is_active' => 1,
            ])
            ->assertRedirect(route('courses.show', $ownedCourse));

        $this->put(route('courses.update', $othersCourse), [
            'code' => $othersCourse->code,
            'title' => 'Not allowed',
            'units' => 3,
            'is_active' => 1,
        ])->assertForbidden();
    }

    public function test_course_owner_cannot_delete_course_with_enrolled_students(): void
    {
        $owner = $this->userWithRole('instructor');
        $student = $this->userWithRole('student');
        $course = Course::factory()->for($owner, 'owner')->create();
        $course->students()->attach($student);

        $this->actingAs($owner)
            ->delete(route('courses.destroy', $course))
            ->assertForbidden();
    }

    public function test_admin_can_manage_courses_and_open_admin_area(): void
    {
        $admin = $this->userWithRole('admin');
        $course = Course::factory()->create();

        $this->actingAs($admin)
            ->get(route('admin.index'))
            ->assertOk();

        $this->get(route('courses.edit', $course))->assertOk();
        $this->put(route('courses.update', $course), [
            'code' => $course->code,
            'title' => 'Admin updated',
            'units' => 3,
            'is_active' => 1,
        ])->assertRedirect(route('courses.show', $course));
        $this->delete(route('courses.destroy', $course))->assertRedirect(route('courses.index'));
    }

    public function test_admin_can_change_instructor_display_name_but_not_student_name(): void
    {
        $admin = $this->userWithRole('admin');
        $instructor = $this->userWithRole('instructor');
        $student = $this->userWithRole('student');

        $this->actingAs($admin)
            ->from(route('admin.index'))
            ->patch(route('admin.users.name', $instructor), ['name' => 'Professor Example'])
            ->assertRedirect(route('admin.index'));

        $this->assertDatabaseHas('users', [
            'id' => $instructor->id,
            'name' => 'Professor Example',
            'role' => 'instructor',
        ]);

        $this->patch(route('admin.users.name', $student), ['name' => 'Not allowed'])
            ->assertForbidden();
    }

    private function userWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->forceFill(['role' => $role])->save();

        return $user;
    }
}
