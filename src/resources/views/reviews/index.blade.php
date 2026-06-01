@extends('layouts.app')

@section('conteudo')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Avaliações (Reviews)</h2>
            <a href="{{ route('reviews.create') }}" class="btn btn-accent">+ Nova Avaliação</a>
        </div>

        @if(session('sucesso'))
            <div class="alert alert-success">{{ session('sucesso') }}</div>
        @endif

        <div class="table-responsive tabela">
            <table class="table mb-0" style="background-color: var(--bg-surface);">
                <thead style="background-color: var(--bg-elevated);">
                    <tr>
                        <th>Filme</th>
                        <th>Usuário</th>
                        <th>Nota</th>
                        <th>Comentário</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td class="fw-bold">{{ $review->movie->nome }}</td>
                            <td>{{ $review->user->name }}</td>
                            <td>
                                <span class="badge bg-warning text-dark">★ {{ $review->nota }}/5</span>
                            </td>
                            <td class="text-muted text-truncate" style="max-width: 250px;">
                                {{ $review->descricao ?? 'Sem texto' }}
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('reviews.show', $review->id) }}" class="btn btn-info btn-sm">
                                        Ver Detalhes
                                    </a>
                                    <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-accent btn-sm">
                                        Editar
                                    </a>
                                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                                        onsubmit="return confirm('Remover a avaliação \'{{ $review->descricao }}\'?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-remover btn-sm">
                                            Remover
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Nenhuma review cadastrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-4">{{ $reviews->links() }}</div>
    </div>
@endsection