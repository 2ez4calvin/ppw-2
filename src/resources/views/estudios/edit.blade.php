@extends('layouts.app')

@section('conteudo')

    <div class="container py-4" style="max-width: 520px;">

        <div class="mb-4">
            <a href="{{ route('estudios.index') }}" class="text-muted text-decoration-none small">
                Voltar
            </a>
            <h2 class="fw-bold mt-2 mb-0">Editar Estúdio</h2>
        </div>

        <div class="p-4 caixa">
            <form action="{{ route('estudios.update', $studio->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nome" class="form-label fw-semibold">Nome</label>
                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        value="{{ old('nome', $studio->nome) }}"
                        class="form-control input-custom @error('nome') is-invalid @enderror">
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="local" class="form-label fw-semibold">Local</label>
                    <input
                        type="text"
                        id="local"
                        name="local"
                        value="{{ old('local', $studio->local) }}"
                        class="form-control input-custom @error('local') is-invalid @enderror">
                    @error('local')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ route('estudios.index') }}" class="btn btn-remover">Cancelar</a>
                    <button type="submit" class="btn btn-accent">Salvar alterações</button>
                </div>
            </form>
        </div>

    </div>

@endsection