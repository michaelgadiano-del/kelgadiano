@if ($errors->any())
    <ul style="color: red;">
        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
    </ul>
@endif
<label>Code <input name="code" value="{{ old('code', $course->code ?? '') }}" required></label><br>
<label>Title <input name="title" value="{{ old('title', $course->title ?? '') }}" required></label><br>
<label>Units <input type="number" name="units" min="1" max="6" value="{{ old('units', $course->units ?? 3) }}" required></label><br>
