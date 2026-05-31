@extends('layouts.app')

@section('conteudo')

    <div class="container py-4" style="max-width: 520px;">

        <div class="mb-4">
            <a href="{{ route('pessoas.index') }}" class="text-muted text-decoration-none small">
                Voltar
            </a>
            <h2 class="fw-bold mt-2 mb-0">Nova Pessoa</h2>
        </div>

        <div class="p-4 caixa">
            <form action="{{ route('pessoas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="nome" class="form-label fw-semibold">Nome Completo</label>
                    <input type="text" id="nome" name="nome" value="{{ old('nome') }}"
                        class="form-control input-custom @error('nome') is-invalid @enderror">
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cpf" class="form-label fw-semibold">CPF</label>
                        <input type="text" id="cpf" name="cpf" maxlength="11" value="{{ old('cpf') }}" placeholder="12345678900"
                            class="form-control input-custom @error('cpf') is-invalid @enderror">
                        @error('cpf')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="data_nascimento" class="form-label fw-semibold">Nascimento</label>
                        <input type="date" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento') }}"
                            class="form-control input-custom @error('data_nascimento') is-invalid @enderror">
                        @error('data_nascimento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="genero" class="form-label fw-semibold">Gênero</label>
                        <input type="text" id="genero" name="genero" value="{{ old('genero') }}"
                            class="form-control input-custom @error('genero') is-invalid @enderror">
                        @error('genero')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nacionalidade" class="form-label fw-semibold">Nacionalidade</label>
                        <input type="text" id="nacionalidade" name="nacionalidade" value="{{ old('nacionalidade') }}"
                            class="form-control input-custom @error('nacionalidade') is-invalid @enderror">
                        @error('nacionalidade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="biografia" class="form-label fw-semibold">Biografia</label>
                    <textarea id="biografia" name="biografia" rows="3"
                        class="form-control input-custom @error('biografia') is-invalid @enderror">{{ old('biografia') }}</textarea>
                    @error('biografia')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold d-block">Funções no Sistema</label>
                    <div class="d-flex flex-wrap gap-3 p-3 rounded border">
                        @foreach(['ator' => 'Ator/Atriz', 'diretor' => 'Diretor(a)', 'escritor' => 'Escritor(a)', 'produtor' => 'Produtor(a)'] as $value => $label)
                            <div class="form-check d-flex align-items-center">
                                <input class="form-check-input mt-0" type="checkbox" name="funcoes[]" value="{{ $value }}" id="f-{{ $value }}"
                                    {{ is_array(old('funcoes')) && in_array($value, old('funcoes')) ? 'checked' : '' }}>
                                <label class="form-check-label ms-1 small fw-medium" for="f-{{ $value }}" style="cursor: pointer;">
                                    {{ $label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('funcoes')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="imagens" class="form-label fw-semibold">Imagens da Pessoa</label>
                    <input type="file" id="imagens" name="imagens[]" multiple accept="image/*"
                        class="form-control input-custom @error('imagens') is-invalid @enderror @error('imagens.*') is-invalid @enderror">
                    @error('imagens')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('imagens.*')
                        <div class="invalid-feedback">Cada arquivo deve ser uma imagem válida (jpg, png, webp) de até 2MB.</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ route('pessoas.index') }}" class="btn btn-remover">Cancelar</a>
                    <button type="submit" class="btn btn-accent">Salvar</button>
                </div>
            </form>
        </div>

    </div>

@endsection