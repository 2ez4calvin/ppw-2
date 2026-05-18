@extends('layouts.app')
@section('titulo', 'IMDp')

@section('conteudo')
<div class="d-flex justify-content-between align-items-center mb-4 column-gap-3">
    <div class="card">
        <img src="{{ asset('imagens/placeholder.png') }}" class="w-100 object-fit-cover" style="height: 160px;" alt="...">
        <div class="p-3">
            <p class="mb-1">Ator</p>
            <h5 class="mb-2">Cubchoo</h5>
            <p class="mb-3">Many of this species can be found along the
                shorelines of cold regions. If a Cubchoo lacks dangling snot,
                there’s a chance it is sick..</p>
            <a href="#" class="btn-accent">
                Ver mais
                <i class="ti ti-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="card">
        <img src="{{ asset('imagens/placeholder.png') }}" class="w-100 object-fit-cover" style="height: 160px;" alt="...">
        <div class="p-3">
            <p class="mb-1">Ator</p>
            <h5 class="mb-2">Cubchoo</h5>
            <p class="mb-3">Many of this species can be found along the
                shorelines of cold regions. If a Cubchoo lacks dangling snot,
                there’s a chance it is sick..</p>
            <a href="#" class="btn-accent">
                Ver mais
                <i class="ti ti-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="card">
        <img src="{{ asset('imagens/placeholder.png') }}" class="w-100 object-fit-cover" style="height: 160px;" alt="...">
        <div class="p-3">
            <p class="mb-1">Ator</p>
            <h5 class="mb-2">Cubchoo</h5>
            <p class="mb-3">Many of this species can be found along the
                shorelines of cold regions. If a Cubchoo lacks dangling snot,
                there’s a chance it is sick..</p>
            <a href="#" class="btn-accent">
                Ver mais
                <i class="ti ti-arrow-right"></i>
            </a>
        </div>
    </div>

</div>
@endsection