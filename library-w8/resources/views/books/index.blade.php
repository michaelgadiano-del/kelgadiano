<x-layout title="Catalogue">
    <h1>Library Catalogue</h1>
    <p>Browse books and check their current circulation status.</p>

    @if ($books->isEmpty())
        <p>No books in the catalogue yet.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>ISBN-13</th>
                    <th>Availability</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td><a href="{{ route('books.show', $book) }}">{{ $book->title }}</a></td>
                        <td>{{ $book->author->name }}</td>
                        <td>{{ $book->isbn }}</td>
                        <td>{{ $book->active_loans_count === 0 ? 'Available' : 'On loan' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-layout>