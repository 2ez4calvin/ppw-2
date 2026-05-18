@extends('layouts.app')
@section('titulo', 'Esqueci minha senha')

@section('conteudo')
    <div class="container-breeze">
        <div class="container-md ms-auto form-login justify-content-center align-items-center border rounded p-4 col-4">
            <h2 class="text-center mb-2">Recuperar Senha</h2>

            <p class="text-sm mb-4">
                {{ __('Esqueceu sua senha? Sem problema. Informe seu e-mail e enviaremos um link para redefinição de senha.') }}
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- E-mail -->
                <div>
                    <x-input-label for="email" :value="__('E-mail')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('login') }}">
                        {{ __('Voltar ao login') }}
                    </a>

                    <x-primary-button class="ms-3 btn btn-accent">
                        {{ __('Enviar link de redefinição') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection