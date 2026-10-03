@props([
    'title',
    'eyebrow',
    'heading',
    'description',
    'alternateLabel',
    'alternateRoute',
    'alternatePrompt',
])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#183d35">
    <title>{{ $title }} | Employee Information System</title>
    <style>
        :root {
            color-scheme: light;
            font-family: "Aptos", "Segoe UI", sans-serif;
            color: #1c302b;
            background: #e9efeb;
            font-synthesis: none;
            text-rendering: optimizeLegibility;
        }

        * { box-sizing: border-box; }

        body {
            min-width: 320px;
            min-height: 100vh;
            margin: 0;
            padding: 32px 20px;
            display: grid;
            place-items: center;
            background-color: #e9efeb;
            background-image: linear-gradient(rgba(24, 61, 53, 0.035) 1px, transparent 1px), linear-gradient(90deg, rgba(24, 61, 53, 0.035) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        a { color: #176b59; }

        .auth-shell {
            width: min(100%, 1000px);
            overflow: hidden;
            border: 1px solid #d4dfd8;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 24px 70px rgba(28, 48, 43, 0.13);
            animation: arrive 420ms ease-out both;
        }

        .auth-topbar {
            min-height: 78px;
            padding: 0 34px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            border-bottom: 1px solid #e7ece8;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: inherit;
            text-decoration: none;
        }

        .brand-mark {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 6px;
            background: #183d35;
            color: #f3c76a;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0;
        }

        .brand-copy { display: grid; gap: 2px; }
        .brand-copy strong { font-size: 13px; font-weight: 750; }
        .brand-copy small { color: #788780; font-size: 11px; }

        .top-link {
            color: #176b59;
            font-size: 13px;
            font-weight: 700;
            text-decoration-thickness: 1px;
            text-underline-offset: 4px;
        }

        .auth-grid { display: grid; grid-template-columns: 0.82fr 1.18fr; }

        .auth-rail {
            min-height: 540px;
            padding: 32px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #f4f5ed;
            background-color: #183d35;
            background-image: linear-gradient(rgba(255, 255, 255, 0.045) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, 0.045) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .rail-label, .rail-foot, .form-eyebrow {
            margin: 0;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .rail-label { color: #b9c9bf; }
        .rail-rule { width: 44px; height: 3px; margin-top: 14px; background: #e3b653; }
        .rail-index { margin: 0 0 14px; color: #e3b653; font-size: 12px; font-weight: 800; }
        .rail-index span { color: #91a79d; font-weight: 500; }

        .rail-title {
            max-width: 300px;
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(34px, 4vw, 48px);
            font-weight: 400;
            line-height: 1.08;
        }

        .rail-stamp {
            width: 118px;
            height: 118px;
            margin-top: 42px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(244, 245, 237, 0.4);
            border-radius: 50%;
            color: #e3b653;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 38px;
        }

        .rail-foot { color: #b9c9bf; }

        .auth-panel {
            padding: 48px clamp(28px, 6vw, 64px) 38px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-eyebrow { color: #176b59; }
        .form-heading {
            margin: 10px 0 8px;
            color: #183d35;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 34px;
            font-weight: 400;
            line-height: 1.12;
        }

        .form-description { margin: 0 0 28px; color: #718078; font-size: 14px; line-height: 1.55; }
        .auth-form { display: grid; gap: 16px; }
        .field-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .field { min-width: 0; display: grid; gap: 7px; }
        .field--wide { grid-column: 1 / -1; }

        .field label { color: #344740; font-size: 12px; font-weight: 700; }

        .field input {
            width: 100%;
            min-height: 45px;
            padding: 0 12px;
            border: 1px solid #cbd7d0;
            border-radius: 4px;
            outline: none;
            background: #fbfcfb;
            color: #1c302b;
            font: inherit;
            font-size: 14px;
            transition: border-color 140ms ease, box-shadow 140ms ease;
        }

        .field input:focus { border-color: #176b59; box-shadow: 0 0 0 3px rgba(23, 107, 89, 0.13); }
        .field input::placeholder { color: #9ba7a1; }

        .remember-row { display: flex; align-items: center; gap: 9px; color: #596961; font-size: 12px; }
        .remember-row input { width: 15px; height: 15px; accent-color: #176b59; }

        .submit-button {
            min-height: 46px;
            margin-top: 3px;
            border: 0;
            border-radius: 4px;
            background: #176b59;
            color: #fff;
            cursor: pointer;
            font: inherit;
            font-size: 13px;
            font-weight: 800;
            transition: background 140ms ease, transform 140ms ease;
        }

        .submit-button:hover { transform: translateY(-1px); background: #105342; }
        .submit-button:focus-visible, .top-link:focus-visible { outline: 3px solid #e3b653; outline-offset: 3px; }

        .form-errors {
            margin: 0 0 18px;
            padding: 11px 14px;
            border-left: 3px solid #ad483d;
            background: #fff2ef;
            color: #8a3029;
            font-size: 12px;
        }

        .form-errors ul { margin: 0; padding-left: 17px; }
        .auth-alternate { margin: 23px 0 0; color: #718078; font-size: 12px; text-align: center; }
        .auth-alternate a { font-weight: 800; text-underline-offset: 3px; }

        @keyframes arrive {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 700px) {
            body { padding: 14px; }
            .auth-topbar { min-height: 68px; padding: 0 18px; }
            .auth-grid { grid-template-columns: 1fr; }
            .auth-rail { min-height: auto; padding: 20px 22px; gap: 20px; }
            .rail-title { max-width: 380px; font-size: 30px; }
            .rail-stamp { display: none; }
            .auth-panel { padding: 30px 22px; }
            .form-heading { font-size: 30px; }
        }

        @media (max-width: 420px) {
            .field-grid { grid-template-columns: 1fr; }
            .field--wide { grid-column: auto; }
            .brand-copy small { max-width: 150px; }
            .top-link { font-size: 12px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.001ms !important; transition-duration: 0.001ms !important; }
        }
    </style>
</head>
<body>
    <main class="auth-shell">
        <header class="auth-topbar">
            <a class="brand" href="{{ route('home') }}">
                <span class="brand-mark" aria-hidden="true">EI</span>
                <span class="brand-copy">
                    <strong>Employee Information System</strong>
                    <small>Personnel records portal</small>
                </span>
            </a>
            <a class="top-link" href="{{ route($alternateRoute) }}">{{ $alternateLabel }}</a>
        </header>

        <div class="auth-grid">
            <aside class="auth-rail" aria-label="Employee Information System">
                <div>
                    <p class="rail-label">Personnel / Access</p>
                    <div class="rail-rule"></div>
                </div>
                <div>
                    <p class="rail-index">01 <span>/ ACCOUNT</span></p>
                    <p class="rail-title">Employee Information System</p>
                    <div class="rail-stamp" aria-hidden="true">EI</div>
                </div>
                <p class="rail-foot">Secure workspace / 2026</p>
            </aside>

            <section class="auth-panel" aria-labelledby="auth-heading">
                <p class="form-eyebrow">{{ $eyebrow }}</p>
                <h1 class="form-heading" id="auth-heading">{{ $heading }}</h1>
                <p class="form-description">{{ $description }}</p>

                @if ($errors->any())
                    <div class="form-errors" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}

                <p class="auth-alternate">{{ $alternatePrompt }} <a href="{{ route($alternateRoute) }}">{{ $alternateLabel }}</a></p>
            </section>
        </div>
    </main>
</body>
</html>