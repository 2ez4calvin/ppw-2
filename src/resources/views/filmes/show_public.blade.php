@extends('layouts.app')

@section('conteudo')

    <section class="mt-5" id="secao-avaliacoes">
        <h3>Avaliações</h3>
        {{-- Container onde o JS injeta os cards de avaliação --}}
        <div id="avaliacoes-container" data-filme-id="{{ $movie->id }}">
            <p class="text-muted">Carregando avaliações...</p>
        </div>
        {{-- Navegação AJAX --}}
        <div class="d-flex align-items-center gap-3 mt-3">
            <button id="btn-anterior" class="btn btn-outline-secondary" disabled>
                ← Anterior
            </button>
            <span id="info-pagina" class="text-muted"></span>
            <button id="btn-proxima" class="btn btn-outline-secondary">
                Próxima →
            </button>
        </div>
    </section>
    {{-- Script inline com o ID do filme para o JS usar --}}
    {{-- O @push('scripts') com o fetch fica abaixo ou num arquivo separado --}}


@endsection