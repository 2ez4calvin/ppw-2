@extends('layouts.app')
@section('titulo', 'Página não encontrada')
@section('conteudo')
    <div class="text-center py-5">
        <h1 class="display-1">404</h1>
        <p class="lead">A página que você procura não existe.</p>
        <a href="/" class="btn btn-primary">Voltar ao início</a>
        <p>{{$exception->getMessage()}}</p>
    </div>
@endsection