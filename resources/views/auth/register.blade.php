<x-auth-layout
    title="Register"
    eyebrow="New account"
    heading="Create your account"
    description="Set up your credentials to access the employee records system."
    alternate-label="Sign in"
    alternate-route="login"
    alternate-prompt="Already registered?"
>
    <form class="auth-form" method="POST" action="{{ route('register.submit') }}">
        @csrf
        <div class="field-grid">
            <div class="field">
                <label for="name">Full name</label>
                <input id="name" name="name" value="{{ old('name') }}" placeholder="Your full name" required autocomplete="name">
            </div>

            <div class="field">
                <label for="username">Username</label>
                <input id="username" name="username" value="{{ old('username') }}" placeholder="Choose a username" required autocomplete="username">
            </div>

            <div class="field field--wide">
                <label for="email">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autocomplete="email">
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="At least 8 characters" required autocomplete="new-password">
            </div>

            <div class="field">
                <label for="password_confirmation">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Repeat password" required autocomplete="new-password">
            </div>
        </div>

        <button class="submit-button" type="submit">Create account</button>
    </form>
</x-auth-layout>