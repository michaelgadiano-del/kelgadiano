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

<x-forms.input name="isbn" label="ISBN-13" :value="$book->isbn" inputmode="numeric" />
<x-forms.input name="title" label="Title" :value="$book->title" />
<x-forms.select name="author_id" label="Author" :options="$authors->pluck('name', 'id')" :selected="$book->author_id" />
<x-forms.input name="published_year" label="Published year" type="number" :value="$book->published_year ?? now()->year" min="1450" max="{{ now()->year }}" />

<input type="hidden" name="is_reference" value="0">
<label>
    <input type="checkbox" name="is_reference" value="1" @checked(old('is_reference', $book->is_reference ?? false))>
    Reference-only book
</label>
@error('is_reference')
    <p class="error">{{ $message }}</p>
@enderror

@if ($book->cover_path)
    <img class="book-cover" src="{{ asset('storage/'.$book->cover_path) }}" alt="Current cover of {{ $book->title }}">
@endif
<x-forms.input name="cover" label="Cover image (JPG or PNG, up to 1 MB)" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png" />