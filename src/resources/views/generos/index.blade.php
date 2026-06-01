@extends('layouts.app')

@section('conteudo')

    <div class="container py-4">

        @if(session('sucesso'))
            <div class="alert alert-success">{{ session('sucesso') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Gêneros</h2>
            <a href="{{ route('generos.create') }}" class="btn btn-accent">
                <span class="btn-icon">+</span> Novo Gênero
            </a>
        </div>

        <div class="table-responsive tabela">
            <table class="table mb-0" style="background-color: var(--bg-surface);">
                <thead style="background-color: var(--bg-elevated);">
                    <tr>
                        <th class="header-tabela">#</th>
                        <th class="header-tabela">Nome</th>
                        <th class="header-tabela text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($genres as $genre)
                        <tr style="border-top: 1px solid var(--bg-elevated); transition: background-color var(--transition);"
                            onmouseover="this.style.backgroundColor='var(--bg-elevated)'"
                            onmouseout="this.style.backgroundColor='transparent'">
                            <td class="text-muted">{{ $genre->id }}</td>
                            <td class="">{{ $genre->nome }}</td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('generos.show', $genre->id) }}" class="btn btn-info btn-sm">
                                        Ver Detalhes
                                    </a>
                                    <a href="{{ route('generos.edit', $genre->id) }}" class="btn btn-accent btn-sm">
                                        Editar
                                    </a>
                                    <form action="{{ route('generos.destroy', $genre->id) }}" method="POST"
                                          onsubmit="return confirm('Remover o gênero \'{{ $genre->nome }}\'?')">
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
                            <td colspan="3" style="padding: 2rem 1.25rem; text-align: center; color: var(--text-muted);">
                                Nenhum gênero cadastrado ainda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $genres->links() }}
        </div>

    </div>

@endsection