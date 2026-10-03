@props(['title' => 'Student Portal'])

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <style>
        body { font-family: sans-serif; max-width: 840px; margin: 2rem auto; }
        nav { margin-bottom: 1rem; }
        label { display: block; margin-top: .75rem; }
        input, select, textarea, button { margin-top: .25rem; }
        .error { color: #c00; margin: .25rem 0; }
        .error-summary { background: #fdecea; border: 1px solid #c00; padding: .5rem 1rem; margin-bottom: 1rem; }
        .success { color: #080; }
        img { max-width: 200px; display: block; margin: 1rem 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: .5rem; }
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('courses.index') }}">Courses</a> |
        <a href="{{ route('courses.create') }}">New</a>
    </nav>

    @if (session('status'))
        <p class="success">{{ session('status') }}</p>
    @endif

    {{ $slot }}
</body>
</html>
