@extends('layouts.app')eic

<h1>{{ $movie->nome }}</h1>
<div>
    <p>Duração: {{ $movie->duracao }} minutos</p>
    <p>Data de lançamento: {{ $movie->data_lancamento }}</p>
</div>


@foreach ($reviews as $av)
    <div class="card mb-2">
        <div class="card-body">
            <div class="d-flex justifycontent-between">
                <strong>{{ $av->user->name }}</strong>
                <span class="badge bgprimary"> {{ $av->nota }}/5 </span>
            </div>
            <p class="mb-o">{{ $av->nota }}</p>
            <p class="mb-0">{{ $av->descricao }}</p>
            <small class="text-muted">{{ $av->created_at->diffForHumans() }}</small>
        </div>
    </div>
@endforeach
