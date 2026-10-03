<x-auth-layout
    title="Log in"
    eyebrow="Account access"
    heading="Welcome back"
    description="Sign in using your username and password."
    alternate-label="Create account"
    alternate-route="register"
    alternate-prompt="New to the system?"
>
    <form class="auth-form" method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div class="field">
            <label for="username">Username</label>
            <input id="username" name="username" value="{{ old('username') }}" placeholder="Enter your username" required autofocus autocomplete="username">
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
        </div>

        <label class="remember-row"><input type="checkbox" name="remember" value="1"> Remember me</label>
        <button class="submit-button" type="submit">Sign in</button>
    </form>
</x-auth-layout>