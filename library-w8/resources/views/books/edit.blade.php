<x-layout title="Edit book">
    <h1>Edit {{ $book->title }}</h1>
    <form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('books._form')
        <button type="submit">Update book</button>
    </form>
</x-layout>