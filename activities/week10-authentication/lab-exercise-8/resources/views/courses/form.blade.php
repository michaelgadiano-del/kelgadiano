<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $course->exists ? 'Edit '.$course->code : 'New course' }}
        </h2>
    </x-slot>
    <div class="mx-auto max-w-3xl px-4 py-8">
        <form method="POST" class="space-y-4 rounded bg-white p-6 shadow"
              action="{{ $course->exists ? route('courses.update', $course) : route('courses.store') }}">
            @csrf
            @if ($course->exists)
                @method('PUT')
            @endif
            <div>
                <x-input-label for="code" value="Code" />
                <x-text-input id="code" name="code" class="mt-1 block w-full" :value="old('code', $course->code)" required />
                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="title" value="Title" />
                <x-text-input id="title" name="title" class="mt-1 block w-full" :value="old('title', $course->title)" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="units" value="Units" />
                <x-text-input id="units" name="units" type="number" min="1" max="6" class="mt-1 block w-32"
                              :value="old('units', $course->units)" required />
                <x-input-error :messages="$errors->get('units')" class="mt-2" />
            </div>
            <div>
                <input type="hidden" name="is_active" value="0">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300"
                           @checked(old('is_active', $course->is_active))>
                    Active (visible to everyone)
                </label>
                <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
            </div>
            <div class="flex items-center gap-4">
                <x-primary-button>Save</x-primary-button>
                <a href="{{ route('courses.index') }}" class="text-gray-600">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
