<x-layout title="Add a book">
    <h1>Add a book</h1>
    <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
        @csrf
        @include('books._form')
        <button type="submit">Save book</button>
    </form>
</x-layout>