<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Courses</h2>
            @can('create', App\Models\Course::class)
                <a href="{{ route('courses.create') }}" class="text-indigo-600">+ New course</a>
            @endcan
        </div>
    </x-slot>
    <div class="mx-auto max-w-5xl px-4 py-8">
        @if (session('status'))
            <p class="mb-4 rounded bg-green-100 px-4 py-2">{{ session('status') }}</p>
        @endif
        <div class="divide-y rounded bg-white shadow">
            @forelse ($courses as $course)
                @can('view', $course)
                    <a href="{{ route('courses.show', $course) }}" class="block px-4 py-3 hover:bg-gray-50">
                        <b>{{ $course->code }}</b> - {{ $course->title }}
                        <span class="text-sm text-gray-500">({{ $course->owner->name }})</span>
                        @unless ($course->is_active)
                            <span class="text-xs text-red-600">inactive</span>
                        @endunless
                    </a>
                @endcan
            @empty
                <p class="px-4 py-3 text-gray-500">No courses yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
