@props(['title' => 'Michael Gadiano'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 2rem auto; }
        label { display: block; margin-top: .75rem; }
        .error { color: #c00; margin: .25rem 0; }
        .error-summary { background: #fdecea; border: 1px solid #c00; padding: .5rem 1rem; }
        .success { color: #080; }
    </style>
</head>
<body>
    @include('partials.nav')

    <main>
        @if (session('status') ?? session('success'))
            <p class="success">{{ session('status') ?? session('success') }}</p>
        @endif

        {{ $slot }}

        @isset($aside)
            {{ $aside }}
        @endisset
    </main>

    @include('partials.footer')
</body>
</html>