@extends('layouts.app')

@section('conteudo')

    <div class="container py-4" style="max-width: 520px;">

        <div class="mb-4">
            <a href="{{ route('estudios.index') }}" class="text-muted text-decoration-none small">
                Voltar
            </a>
            <h2 class="fw-bold mt-2 mb-0">Detalhes do Estúdio</h2>
        </div>

        <div class="p-4"
            style="background-color: var(--bg-surface); border-radius: var(--radius); box-shadow: var(--shadow-card); border: 1px solid var(--bg-elevated);">

            <div class="mb-3">
                <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">ID</span>
                <p class="mb-0 mt-1 fw-medium">{{ $studio->id }}</p>
            </div>

            <hr style="border-color: var(--bg-elevated);">

            <div class="mb-3">
                <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">Nome</span>
                <p class="mb-0 mt-1 fw-bold fs-5">{{ $studio->nome }}</p>
            </div>

            <div class="mb-3">
                <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">Local</span>
                <p class="mb-0 mt-1 fw-bold fs-5">{{ $studio->local }}</p>
            </div>

            {{-- Mudar a exibição das imagens para carrossel futuramente --}}

            <div class="mb-4">
                <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">Imagens do Estúdio</span>
                <div class="d-flex flex-wrap gap-2 mt-2">
                    @forelse($studio->image as $img)
                        <div class="position-relative" style="width: 100px; height: 100px;">
                            <img src="{{ asset('storage/' . $img->caminho) }}" alt="{{ $img->nome }}"
                                class="img-thumbnail w-100 h-100 object-fit-cover" title="{{ $img->nome }}">
                        </div>
                    @empty
                        <p class="text-muted small mb-0 mt-1">Nenhuma imagem cadastrada para este estúdio.</p>
                    @endforelse
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end mt-4">
                <a href="{{ route('estudios.edit', $studio->id) }}" class="btn btn-info">Editar</a>
                <form action="{{ route('estudios.destroy', $studio->id) }}" method="POST"
                    onsubmit="return confirm('Remover o estúdio \'{{ $studio->nome }}\'?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-remover">Remover</button>
                </form>
            </div>

        </div>

    </div>

@endsection