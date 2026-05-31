@extends('layouts.app')

@section('conteudo')

    <div class="container py-4" style="max-width: 520px;">

        <div class="mb-4">
            <a href="{{ route('pessoas.index') }}" class="text-muted text-decoration-none small">
                Voltar
            </a>
            <h2 class="fw-bold mt-2 mb-0">Detalhes da Pessoa</h2>
        </div>

        <div class="p-4"
            style="background-color: var(--bg-surface); border-radius: var(--radius); box-shadow: var(--shadow-card); border: 1px solid var(--bg-elevated);">

            <div class="mb-3">
                <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">ID</span>
                <p class="mb-0 mt-1 fw-medium">{{ $person->id }}</p>
            </div>

            <hr style="border-color: var(--bg-elevated);">

            <div class="mb-3">
                <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">Nome Completo</span>
                <p class="mb-0 mt-1 fw-bold fs-5 text-dark">{{ $person->nome }}</p>
            </div>

            <div class="row">
                <div class="col-6 mb-3">
                    <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">CPF</span>
                    <p class="mb-0 mt-1 fw-bold fs-6">{{ $person->cpf }}</p>
                </div>
                <div class="col-6 mb-3">
                    <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">Nascimento</span>
                    <p class="mb-0 mt-1 fw-bold fs-6">
                        {{ $person->data_nascimento ? date('d/m/Y', strtotime($person->data_nascimento)) : 'Não informada' }}
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-6 mb-3">
                    <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">Gênero</span>
                    <p class="mb-0 mt-1 fw-bold fs-6">{{ $person->genero ?? 'Não informado' }}</p>
                </div>
                <div class="col-6 mb-3">
                    <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">Nacionalidade</span>
                    <p class="mb-0 mt-1 fw-bold fs-6">{{ $person->nacionalidade ?? 'Não informada' }}</p>
                </div>
            </div>

            <div class="mb-3">
                <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">Funções Associadas</span>
                <div class="d-flex gap-2 mt-1">
                    @if($person->actor) <span class="badge bg-primary">Ator / Atriz</span> @endif
                    @if($person->director) <span class="badge bg-secondary">Diretor(a)</span> @endif
                    @if($person->writer) <span class="badge bg-info text-dark">Escritor(a)</span> @endif
                    @if($person->producer) <span class="badge bg-dark">Produtor(a)</span> @endif
                    @if(!$person->actor && !$person->director && !$person->writer && !$person->producer)
                        <p class="text-muted mb-0 small">Nenhuma função definida.</p>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">Biografia</span>
                <p class="mb-0 mt-1 text-secondary" style="white-space: pre-line;">
                    {{ $person->biografia ?? 'Nenhuma biografia cadastrada.' }}</p>
            </div>

            <div class="mb-4">
                <span class="text-muted small text-uppercase" style="letter-spacing: 0.05em;">Imagens Relacionadas</span>
                <div class="d-flex flex-wrap gap-2 mt-2">
                    @forelse($person->image as $img)
                        <div class="position-relative" style="width: 100px; height: 100px;">
                            <img src="{{ asset('storage/' . $img->caminho) }}" alt="{{ $img->nome }}"
                                class="img-thumbnail w-100 h-100 object-fit-cover" title="{{ $img->nome }}">
                        </div>
                    @empty
                        <p class="text-muted small mb-0 mt-1">Nenhuma imagem cadastrada para esta pessoa.</p>
                    @endforelse
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end mt-4">
                <a href="{{ route('pessoas.edit', $person->id) }}" class="btn btn-info">Editar</a>
                <form action="{{ route('pessoas.destroy', $person->id) }}" method="POST"
                    onsubmit="return confirm('Remover a pessoa \'{{ $person->nome }}\'?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-remover">Remover</button>
                </form>
            </div>
        </div>

    </div>

@endsection