@props(['title' => 'Library Circulation Desk'])

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} · Library Circulation Desk</title>
    <style>
        :root { color-scheme: light; font-family: Georgia, 'Times New Roman', serif; color: #202c28; background: #f4f3ed; }
        body { max-width: 1000px; margin: 0 auto; padding: 1.5rem; }
        nav { display: flex; gap: 1rem; align-items: center; border-bottom: 1px solid #b9c3bd; padding-bottom: 1rem; }
        nav a, a { color: #17634f; }
        main { padding: 1rem 0; }
        label { display: block; margin: .8rem 0 .2rem; font-weight: 700; }
        input, select, button { font: inherit; padding: .55rem; }
        input, select { max-width: 100%; }
        button { cursor: pointer; background: #17634f; color: white; border: 0; }
        button:disabled { opacity: .55; cursor: not-allowed; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { text-align: left; padding: .65rem; border-bottom: 1px solid #c8d0cb; }
        .notice { padding: .7rem; background: #e2eee6; border-left: 4px solid #17634f; }
        .error-summary { padding: .7rem; background: #f8e7e2; border-left: 4px solid #aa3d2b; }
        .error { color: #9b2f21; margin: .2rem 0; }
        .book-cover { display: block; max-width: 220px; max-height: 300px; object-fit: contain; margin: 1rem 0; }
        .actions { display: flex; flex-wrap: wrap; gap: .8rem; margin: 1rem 0; }
    </style>
</head>
<body>
    <nav aria-label="Main navigation">
        <a href="{{ route('books.index') }}">Catalogue</a>
        <a href="{{ route('books.create') }}">Add book</a>
        <a href="{{ route('members.create') }}">Register member</a>
    </nav>
    <main>
        @if (session('status'))
            <p class="notice" role="status">{{ session('status') }}</p>
        @endif
        {{ $slot }}
    </main>
</body>
</html>