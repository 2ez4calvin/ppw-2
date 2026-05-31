@extends('layouts.app')

@section('conteudo')

    <div class="container py-4" style="max-width: 520px;">

        <div class="mb-4">
            <a href="{{ route('reviews.index') }}" class="text-muted text-decoration-none small">
                Voltar
            </a>
            <h2 class="fw-bold mt-2 mb-0">Detalhes do Comentário</h2>
        </div>

        <div class="p-4" style="background-color: var(--bg-surface); border-radius: var(--radius); box-shadow: var(--shadow-card); border: 1px solid var(--bg-elevated);">

            <div class="mb-3">
                <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">ID</span>
                <p class="mb-0 mt-1 fw-medium">{{ $review->id }}</p>
            </div>

            <hr style="border-color: var(--bg-elevated);">

            <div class="mb-3">
                <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">Filme</span>
                <p class="mb-0 mt-1 fw-bold fs-5">{{ $review->movie->nome }}</p>
            </div>

            <div class="mb-3">
                <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">Usuário</span>
                <p class="mb-0 mt-1 fw-bold fs-5">{{ $review->user->name }}</p>
            </div>

            <div class="mb-3">
                <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">Nota</span>
                <p class="mb-0 mt-1 fw-bold fs-5">{{ $review->nota }}/5</p>
            </div>

            <div class="mb-3">
                <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">Comentário</span>
                <p class="mb-0 mt-1 fw-medium">{{ $review->descricao }}</p>
            </div>

            <div class="d-flex gap-2 justify-content-end mt-4">
                <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-info">Editar</a>
                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                      onsubmit="return confirm('Remover o comentário \'{{ $review->comentario }}\'?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-remover">Remover</button>
                </form>
            </div>

        </div>

    </div>

@endsection