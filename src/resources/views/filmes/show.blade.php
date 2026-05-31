@extends('layouts.app')

@section('conteudo')
<div class="container py-4" style="max-width: 650px;">
    <div class="mb-4">
        <a href="{{ route('filmes.index') }}" class="text-muted text-decoration-none small">Voltar</a>
        <h2 class="fw-bold mt-2 mb-0">Detalhes do Filme</h2>
    </div>

    <div class="p-4 caixa">
        <div class="mb-3">
            <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">Título</span>
            <p class="mb-0 mt-1 fw-bold fs-4">{{ $movie->nome }}</p>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <span class="text-muted small text-uppercase">Lançamento</span>
                <p class="mb-0 fw-medium">{{ \Carbon\Carbon::parse($movie->data_lancamento)->format('d/m/Y') }}</p>
            </div>
            <div class="col-6">
                <span class="text-muted small text-uppercase">Duração</span>
                <p class="mb-0 fw-medium">{{ $movie->duracao }} minutos</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <span class="text-muted small text-uppercase">Classificação</span>
                <p class="mb-0 fw-medium">{{ $movie->classificacao ?? 'Livre' }}</p>
            </div>
            <div class="col-6">
                <span class="text-muted small text-uppercase">Estúdio</span>
                <p class="mb-0 fw-medium text-primary">{{ $movie->studio->nome ?? 'Não associado' }}</p>
            </div>
        </div>

        <div class="mb-3">
            <span class="text-muted small text-uppercase">Gêneros</span>
            <div class="mt-1">
                @foreach($movie->genres as $genre)
                    <span class="badge bg-secondary me-1">{{ $genre->nome }}</span>
                @endforeach
            </div>
        </div>

        <div class="mb-3">
            <span class="text-muted small text-uppercase">Sinopse</span>
            <p class="mb-0 mt-1 text-secondary text-justify" style="white-space: pre-line;">{{ $movie->sinopse ?? 'Nenhuma sinopse disponível.' }}</p>
        </div>

        <hr style="border-color: var(--bg-elevated);">

        <h5 class="fw-bold mb-3">Equipe Técnica e Elenco</h5>

        <div class="mb-2">
            <strong class="small text-muted text-uppercase d-block">Direção:</strong>
            <p class="mb-1">{{ $movie->directors->pluck('person.nome')->join(', ') ?: 'Nenhum cadastrado' }}</p>
        </div>

        <div class="mb-2">
            <strong class="small text-muted text-uppercase d-block">Roteiro (Writers):</strong>
            <p class="mb-1">{{ $movie->writers()->exists() ? $movie->writers->pluck('person.nome')->join(', ') : 'Nenhum cadastrado' }}</p>
        </div>

        <div class="mb-2">
            <strong class="small text-muted text-uppercase d-block">Produção:</strong>
            <p class="mb-1">{{ $movie->producers()->exists() ? $movie->producers->pluck('person.nome')->join(', ') : 'Nenhum cadastrado' }}</p>
        </div>

        <div class="mb-3">
            <strong class="small text-muted text-uppercase d-block">Elenco (Atores):</strong>
            <p class="mb-1">{{ $movie->actors()->exists() ? $movie->actors->pluck('person.nome')->join(', ') : 'Nenhum ator vinculado' }}</p>
        </div>

        <hr style="border-color: var(--bg-elevated);">

        <div class="mb-4">
            <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">Galeria de Imagens</span>
            <div class="d-flex flex-wrap gap-2 mt-2">
                @forelse($movie->images as $img)
                    <div style="width: 120px; height: 120px;">
                        <img src="{{ asset('storage/' . $img->caminho) }}" alt="{{ $img->nome }}"
                            class="img-thumbnail w-100 h-100 object-fit-cover" title="{{ $img->nome }}">
                    </div>
                @empty
                    <p class="text-muted small mb-0 mt-1">Nenhuma imagem cadastrada para este filme.</p>
                @endforelse
            </div>
        </div>

        <div class="d-flex gap-2 justify-content-end mt-4">
            <a href="{{ route('filmes.edit', $movie->id) }}" class="btn btn-info">Editar</a>
            <form action="{{ route('filmes.destroy', $movie->id) }}" method="POST"
                onsubmit="return confirm('Tem certeza que deseja remover o filme \'{!! addslashes($movie->nome) !!}\' e todos os seus arquivos físicos?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-remover">Remover...</button>
            </form>
        </div>
    </div>
</div>
@endsection