@if ($errors->any())
    <div class="error-summary" role="alert">
        <strong>Please fix the {{ $errors->count() }} error(s) below.</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<x-forms.input name="code" label="Code" :value="$course->code ?? ''" />
<x-forms.input name="title" label="Title" :value="$course->title ?? ''" />

<label for="description">Description</label>
<textarea id="description" name="description" rows="3">{{ old('description', $course->description ?? '') }}</textarea>
@error('description')
    <p class="error">{{ $message }}</p>
@enderror

<x-forms.input name="units" label="Units" type="number" :value="$course->units ?? 3" min="1" max="6" />
<x-forms.select name="instructor_id" label="Instructor" :options="$instructors->pluck('name', 'id')" :selected="$course->instructor_id ?? null" />

<input type="hidden" name="is_active" value="0">
<label>
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $course->is_active ?? true))>
    Active
</label>

@if ($course->image_path)
    <img src="{{ asset('storage/' . $course->image_path) }}" alt="Current image" width="120">
@endif

<x-forms.input name="image" label="Image" type="file" accept="image/*" />
