<x-layout title="Feedback">
    <h1>Feedback</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('feedback.submit') }}">
        @csrf

        <label for="message">Message</label>
        <textarea name="message" id="message" required>{{ old('message') }}</textarea>

        <button type="submit">Send Feedback</button>
    </form>

    <form method="POST" action="{{ route('feedback.delete', 1) }}">
        @csrf
        @method('DELETE')
        <button type="submit">Delete Feedback 1</button>
    </form>
</x-layout>
