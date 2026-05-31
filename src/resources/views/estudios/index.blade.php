@extends('layouts.app')

@section('conteudo')

    <div class="container py-4">

        @if(session('sucesso'))
            <div class="alert alert-success">{{ session('sucesso') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Estúdios</h2>
            <a href="{{ route('estudios.create') }}" class="btn btn-accent">
                <span class="btn-icon">+</span> Novo Estúdio
            </a>
        </div>

        <div class="table-responsive tabela">
            <table class="table mb-0" style="background-color: var(--bg-surface);">
                <thead style="background-color: var(--bg-elevated);">
                    <tr>
                        <th class="header-tabela">#</th>
                        <th class="header-tabela">Nome</th>
                        <th class="header-tabela">Local</th>
                        <th class="header-tabela text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($studios as $studio)
                        <tr style="border-top: 1px solid var(--bg-elevated); transition: background-color var(--transition);"
                            onmouseover="this.style.backgroundColor='var(--bg-elevated)'"
                            onmouseout="this.style.backgroundColor='transparent'">
                            <td class="text-muted header-tabela ">{{ $studio->id }}</td>
                            <td class="header-tabela">{{ $studio->nome }}</td>
                            <td class="header-tabela">{{ $studio->local }}</td>
                            <td class="header-tabela text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('estudios.show', $studio->id) }}" class="btn btn-info btn-sm">
                                        Ver Detalhes
                                    </a>
                                    <a href="{{ route('estudios.edit', $studio->id) }}" class="btn btn-accent btn-sm">
                                        Editar
                                    </a>
                                    <form action="{{ route('estudios.destroy', $studio->id) }}" method="POST"
                                          onsubmit="return confirm('Remover o estúdio \'{{ $studio->nome }}\'?')">
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
                            <td colspan="4" style="padding: 2rem 1.25rem; text-align: center; color: var(--text-muted);">
                                Nenhum estúdio cadastrado ainda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $studios->links() }}
        </div>

    </div>

@endsection