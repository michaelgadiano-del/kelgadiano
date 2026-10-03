<x-layout title="Register a member">
    <h1>Register a member</h1>
    @if ($errors->any())
        <div class="error-summary" role="alert">
            <strong>Please fix the {{ $errors->count() }} error(s) below.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('members.store') }}">
        @csrf
        <x-forms.input name="name" label="Name" :value="old('name')" autocomplete="name" />
        <x-forms.input name="email" label="Email" type="email" :value="old('email')" autocomplete="email" />
        <x-forms.input name="date_of_birth" label="Date of birth" type="date" :value="old('date_of_birth')" />
        <x-forms.input name="password" label="Password" type="password" autocomplete="new-password" />
        <x-forms.input name="password_confirmation" label="Confirm password" type="password" autocomplete="new-password" />
        <button type="submit">Register member</button>
    </form>
</x-layout>