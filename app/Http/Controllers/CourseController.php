<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('courses.index', ['courses' => Course::withCount('students')->orderBy('code')->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('courses.create', ['course' => new Course]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Course::create($this->validated($request));

        return redirect()->route('courses.index')->with('success', 'Course added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course): View
    {
        $course->load('students');

        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course): View
    {
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        $course->update($this->validated($request, $course));

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    private function validated(Request $request, ?Course $course = null): array
    {
        $ignore = $course ? ','.$course->id : '';

        return $request->validate([
            'code' => ['required', 'string', 'max:12', 'unique:courses,code'.$ignore],
            'title' => ['required', 'string', 'max:120'],
            'units' => ['required', 'integer', 'between:1,6'],
        ]);
    }
}
