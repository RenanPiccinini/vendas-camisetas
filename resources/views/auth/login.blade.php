<x-guest-layout>
    <x-auth-session-status class="auth-status" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="auth-field">
            <label for="email">E-mail</label>
            <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="voce@exemplo.com">
            <x-input-error :messages="$errors->get('email')" class="auth-error" />
        </div>

        <div class="auth-field">
            <label for="password">Senha</label>
            <input id="password" class="auth-input" type="password" name="password" required autocomplete="current-password" placeholder="Digite sua senha">
            <x-input-error :messages="$errors->get('password')" class="auth-error" />
        </div>

        <div class="auth-options">
            <label class="auth-check" for="remember_me">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Lembrar de mim</span>
            </label>
            @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">Esqueci minha senha</a>
            @endif
        </div>

        <button class="auth-submit" type="submit">Entrar <span aria-hidden="true">↗</span></button>
    </form>
</x-guest-layout>
