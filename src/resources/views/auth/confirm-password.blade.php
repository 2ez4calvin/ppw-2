@extends('layouts.app')
@section('titulo', 'Confirmar Senha')

@section('conteudo')
    <div class="container-md ms-auto form-login justify-content-center align-items-center border rounded p-4 col-4">
        <h2 class="text-center mb-2">Confirmar Senha</h2>

        <p class="text-sm mb-4">
            {{ __('Esta é uma área segura do sistema. Por favor, confirme sua senha antes de continuar.') }}
        </p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Senha -->
            <div>
                <x-input-label for="password" :value="__('Senha')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-3 btn btn-accent">
                    {{ __('Confirmar') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection