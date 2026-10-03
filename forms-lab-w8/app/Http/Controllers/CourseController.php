<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        return view('courses.index', [
            'courses' => Course::with('instructor')->get(),
        ]);
    }

    public function create(): View
    {
        return view('courses.create', [
            'course' => new Course,
            'instructors' => Instructor::orderBy('name')->get(),
        ]);
    }

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('courses', 'public');
        }

        unset($data['image']);

        $course = Course::create($data);

        return redirect()->route('courses.show', $course)->with('status', 'Course created.');
    }

    public function show(Course $course): View
    {
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course): View
    {
        return view('courses.edit', [
            'course' => $course,
            'instructors' => Instructor::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        $data = $request->validated();
        $previousImagePath = $course->image_path;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('courses', 'public');
        }

        unset($data['image']);

        $course->update($data);

        if ($previousImagePath && isset($data['image_path'])) {
            Storage::disk('public')->delete($previousImagePath);
        }

        return redirect()->route('courses.show', $course)->with('status', 'Course updated.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $imagePath = $course->image_path;

        $course->delete();

        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()->route('courses.index')->with('status', 'Course deleted.');
    }
}
