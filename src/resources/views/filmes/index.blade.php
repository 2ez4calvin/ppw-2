@extends('layouts.app')

@section('conteudo')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Filmes</h2>
            <a href="{{ route('filmes.create') }}" class="btn btn-accent">+ Novo Filme</a>
        </div>

        @if(session('sucesso'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('sucesso') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('erro'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('erro') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive tabela">
            <table class="table mb-0 align-middle" style="background-color: var(--bg-surface);">
                <thead style="background-color: var(--bg-elevated);">
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Título</th>
                        <th>Lançamento</th>
                        <th>Duração</th>
                        <th>Estúdio</th>
                        <th style="width: 150px;" class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movies as $movie)
                        <tr>
                            <td class="fw-medium text-muted">#{{ $movie->id }}</td>
                            <td class="fw-bold">{{ $movie->nome }}</td>
                            <td>{{ \Carbon\Carbon::parse($movie->data_lancamento)->format('d/m/Y') }}</td>
                            <td>{{ $movie->duracao }} min</td>
                            <td>{{ $movie->studio->nome ?? 'Não informado' }}</td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('filmes.show', $movie->id) }}" class="btn btn-info btn-sm">
                                        Ver Detalhes
                                    </a>
                                    <a href="{{ route('filmes.edit', $movie->id) }}" class="btn btn-accent btn-sm">
                                        Editar
                                    </a>
                                    <form action="{{ route('filmes.destroy', $movie->id) }}" method="POST"
                                          onsubmit="return confirm('Remover o filme \'{{ $movie->nome }}\'?')">
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
                            <td colspan="6" class="text-center text-muted py-4">Nenhum filme cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $movies->links() }}
        </div>
    </div>
@endsection