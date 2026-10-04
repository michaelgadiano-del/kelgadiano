@props(['title' => 'Michael Gadiano'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('records.css') }}">
</head>
<body>
    @include('partials.nav')

    <main class="site-main">
        @if (!request()->routeIs('employees.index') && (session('status') ?? session('success')))
            <p class="success page-notice">{{ session('status') ?? session('success') }}</p>
        @endif

        {{ $slot }}

        @isset($aside)
            {{ $aside }}
        @endisset
    </main>

    @include('partials.footer')
</body>
</html>