@extends('layouts.app')
@section('titulo', 'Ação não autorizada!')
@section('conteudo')
    <div class="text-center py-5">
        <h1 class="display-1">403</h1>
        <p class="lead">Ação não autorizada!</p>
        <a href="/" class="btn btn-accent btn-primary">Voltar ao início</a>
        <p>{{$exception->getMessage()}}</p>
    </div>
@endsection