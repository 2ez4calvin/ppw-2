@extends('layouts.app')

@section('conteudo')

    <div class="container py-4">

        @if(session('sucesso'))
            <div class="alert alert-success">{{ session('sucesso') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Pessoas</h2>
            <a href="{{ route('pessoas.create') }}" class="btn btn-accent">
                <span class="btn-icon">+</span> Nova Pessoa
            </a>
        </div>

        <div class="table-responsive tabela">
            <table class="table mb-0" style="background-color: var(--bg-surface);">
                <thead style="background-color: var(--bg-elevated);">
                    <tr>
                        <th class="header-tabela">Nome</th>
                        <th class="header-tabela">CPF</th>
                        <th class="header-tabela">Funções</th>
                        <th class="header-tabela text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($person as $pessoa)
                        <tr style="border-top: 1px solid var(--bg-elevated); transition: background-color var(--transition);"
                            onmouseover="this.style.backgroundColor='var(--bg-elevated)'"
                            onmouseout="this.style.backgroundColor='transparent'">
                            <td class="header-tabela fw-bold">{{ $pessoa->nome }}</td>
                            <td class="header-tabela text-muted">{{ $pessoa->cpf }}</td>
                            <td class="header-tabela">
                                <div class="d-flex gap-1 flex-wrap">
                                    @if($pessoa->actor) <span class="badge bg-primary">Ator</span> @endif
                                    @if($pessoa->director) <span class="badge bg-secondary">Diretor</span> @endif
                                    @if($pessoa->writer) <span class="badge bg-info text-dark">Escritor</span> @endif
                                    @if($pessoa->producer) <span class="badge bg-dark">Produtor</span> @endif
                                </div>
                            </td>
                            <td class="header-tabela text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('pessoas.show', $pessoa->id) }}" class="btn btn-info btn-sm">
                                        Ver Detalhes
                                    </a>
                                    <a href="{{ route('pessoas.edit', $pessoa->id) }}" class="btn btn-accent btn-sm">
                                        Editar
                                    </a>
                                    <form action="{{ route('pessoas.destroy', $pessoa->id) }}" method="POST"
                                        onsubmit="return confirm('Remover a pessoa \'{{ $pessoa->nome }}\'?')">
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
                                Nenhuma pessoa cadastrada ainda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $person->links() }}
        </div>

    </div>

@endsection