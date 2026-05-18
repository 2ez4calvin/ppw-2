@extends('layouts.app')
@section('titulo', 'Verificar E-mail')

@section('conteudo')
    <div class="container-breeze">
        <div class="container-md ms-auto form-login justify-content-center align-items-center border rounded p-4 col-4">
            <h2 class="text-center mb-2">Verificar E-mail</h2>

            <p class="text-sm mb-4">
                {{ __('Obrigado por se cadastrar! Antes de começar, verifique seu e-mail clicando no link que enviamos para você. Caso não tenha recebido, podemos reenviar outro.') }}
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-sm text-green-600">
                    {{ __('Um novo link de verificação foi enviado para o e-mail informado no cadastro.') }}
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">
                        {{ __('Sair') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-primary-button class="ms-3 btn btn-accent">
                        {{ __('Reenviar e-mail de verificação') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
@endsection