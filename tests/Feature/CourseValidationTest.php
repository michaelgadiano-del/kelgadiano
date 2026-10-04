<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_can_be_created_with_validation_and_safe_data(): void
    {
        $instructor = Instructor::factory()->create();

        $response = $this->post('/courses', [
            'code' => ' webdev3 ',
            'title' => 'Web Development 3',
            'description' => 'A practical Laravel course.',
            'units' => 3,
            'instructor_id' => $instructor->id,
            'is_active' => '1',
        ]);

        $course = Course::query()->where('code', 'WEBDEV3')->first();

        $this->assertNotNull($course);
        $response->assertRedirect(route('courses.show', $course));
        $this->assertDatabaseHas('courses', [
            'code' => 'WEBDEV3',
            'title' => 'Web Development 3',
            'description' => 'A practical Laravel course.',
            'units' => 3,
            'instructor_id' => $instructor->id,
            'is_active' => true,
        ]);
    }
}
