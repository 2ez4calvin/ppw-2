@extends('layouts.app')
@section('titulo', 'Login')

@section('conteudo')
    <div class="container-breeze">
    <div class="container-md ms-auto form-login justify-content-center align-items-center border rounded p-4 col-4">
        <h2 class="text-center mb-2">Login</h3>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <x-input-label for="email" :value="__('E-mail')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Senha')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" class="input-checkbox " type="checkbox" name="remember">
                    <span class="ms-2 text-sm">{{ __('Lembrar-me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        {{ __('Esqueceu sua senha?') }}
                    </a>
                @endif

                <x-primary-button class="ms-3 btn btn-accent">
                    {{ __('Login') }}
                </x-primary-button>
            </div>
        </form>
    </div>
    </div>
@endsection