<?php

namespace Tests\Feature;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CourseWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_courses_index(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('courses.index'));
    }

    public function test_invalid_submission_preserves_old_input_and_shows_an_error_summary(): void
    {
        $response = $this->followingRedirects()->from(route('courses.create'))->post(route('courses.store'), [
            'code' => '',
            'title' => 'Kept title',
            'units' => 3,
            'is_active' => 0,
        ]);

        $response->assertOk()
            ->assertSee('Please fix the')
            ->assertSee('The code field is required.')
            ->assertSee('Kept title')
            ->assertDontSee('checked', false);
    }

    public function test_invalid_code_and_units_show_validation_messages(): void
    {
        $response = $this->followingRedirects()->from(route('courses.create'))->post(route('courses.store'), $this->validCourseData([
            'code' => 'WEB33',
            'units' => 7,
        ]));

        $response->assertOk()
            ->assertSee('3–7 capital letters followed by one digit')
            ->assertSee('Units must be between 1 and 6.');
    }

    public function test_duplicate_course_code_uses_a_custom_message(): void
    {
        Course::factory()->create(['code' => 'WEBDEV3']);

        $response = $this->followingRedirects()->from(route('courses.create'))->post(route('courses.store'), $this->validCourseData());

        $response->assertOk()
            ->assertSee('That course code is already taken.');
    }

    public function test_store_normalizes_data_and_saves_an_uploaded_image_with_a_random_name(): void
    {
        Storage::fake('public');

        $response = $this->post(route('courses.store'), $this->validCourseData([
            'code' => ' webdev3 ',
            'image' => $this->fakeImage('original.png'),
        ]));

        $course = Course::where('code', 'WEBDEV3')->firstOrFail();

        $response->assertRedirect(route('courses.show', $course))
            ->assertSessionHas('status', 'Course created.');

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'code' => 'WEBDEV3',
            'units' => 3,
        ]);
        $this->assertNotSame('original.jpg', basename($course->image_path));
        Storage::disk('public')->assertExists($course->image_path);

        $this->get(route('courses.show', $course))->assertSee('storage/'.$course->image_path);
    }

    public function test_update_ignores_its_own_code_and_replaces_the_old_image_after_saving(): void
    {
        Storage::fake('public');
        $previousImagePath = 'courses/previous.jpg';
        Storage::disk('public')->put($previousImagePath, 'previous image');
        $course = Course::factory()->create([
            'code' => 'WEBDEV3',
            'image_path' => $previousImagePath,
        ]);

        $response = $this->put(route('courses.update', $course), $this->validCourseData([
            'title' => 'Updated title',
            'image' => $this->fakeImage('replacement.png'),
            'is_active' => 0,
        ]));

        $course->refresh();

        $response->assertRedirect(route('courses.show', $course))
            ->assertSessionHas('status', 'Course updated.');
        $this->assertSame('WEBDEV3', $course->code);
        $this->assertSame('Updated title', $course->title);
        $this->assertFalse($course->is_active);
        $this->assertNotSame($previousImagePath, $course->image_path);
        Storage::disk('public')->assertMissing($previousImagePath);
        Storage::disk('public')->assertExists($course->image_path);
    }

    public function test_failed_update_preserves_the_old_image_and_unchecked_state(): void
    {
        Storage::fake('public');
        $imagePath = 'courses/current.jpg';
        Storage::disk('public')->put($imagePath, 'current image');
        $course = Course::factory()->create([
            'code' => 'WEBDEV3',
            'image_path' => $imagePath,
        ]);

        $response = $this->followingRedirects()->from(route('courses.edit', $course))->put(route('courses.update', $course), $this->validCourseData([
            'title' => '',
            'is_active' => 0,
            'image' => UploadedFile::fake()->create('not-an-image.pdf', 100, 'application/pdf'),
        ]));

        $response->assertOk()
            ->assertSee('The title field is required.')
            ->assertSee('The image field must be an image.')
            ->assertDontSee('checked', false);
        Storage::disk('public')->assertExists($imagePath);
    }

    public function test_destroy_deletes_the_course_and_its_image(): void
    {
        Storage::fake('public');
        $imagePath = 'courses/to-delete.jpg';
        Storage::disk('public')->put($imagePath, 'course image');
        $course = Course::factory()->create(['image_path' => $imagePath]);

        $this->get(route('courses.show', $course))
            ->assertSee('name="_token"', false)
            ->assertSee('name="_method"', false)
            ->assertSee('value="DELETE"', false)
            ->assertSee("confirm('Delete this course?", false);

        $response = $this->delete(route('courses.destroy', $course));

        $response->assertRedirect(route('courses.index'))
            ->assertSessionHas('status', 'Course deleted.');
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
        Storage::disk('public')->assertMissing($imagePath);
    }

    private function validCourseData(array $overrides = []): array
    {
        return array_merge([
            'code' => 'WEBDEV3',
            'title' => 'Web Development',
            'description' => 'A course about web development.',
            'units' => 3,
            'is_active' => 1,
        ], $overrides);
    }

    private function fakeImage(string $name): UploadedFile
    {
        $contents = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADUlEQVR4nGP4z8AAAAMBAQDJ/pLvAAAAAElFTkSuQmCC');

        return UploadedFile::fake()->createWithContent($name, $contents ?: '');
    }
}
