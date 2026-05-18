@extends('layouts.app')
@section('conteudo')
    <h1 class="h2 mb-4">Filmes</h1>
    <div class="row g-3">
        @forelse ($filmes as $filme)
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $filme->nome }}</h5>
                        <p class="text-muted">{{ $filme->data_lancamento }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p>Nenhum filme encontrado.</p>
        @endforelse
    </div>
    {{-- Renderiza os botões de paginação --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $filmes->links() }}
    </div>
    {{-- Informações sobre a página atual --}}
    <p class="text-muted text-center">
        Exibindo {{ $filmes->firstItem() }}–{{ $filmes->lastItem() }}
        de {{ $filmes->total() }} filmes
    </p>
@endsection