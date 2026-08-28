@props(['student'])

<article {{ $attributes->merge(['class' => 'student-card']) }}>
    <h2>
        <a href="{{ route('students.show', $student) }}">
            {{ $student->name ?? 'Unnamed' }}
        </a>
    </h2>

    <p>{{ $student->email }}</p>
</article>
