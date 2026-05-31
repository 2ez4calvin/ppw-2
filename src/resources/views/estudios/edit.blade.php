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
            <form action="{{ route('estudios.update', $studio->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nome" class="form-label fw-semibold">Nome</label>
                    <input type="text" id="nome" name="nome" value="{{ old('nome', $studio->nome) }}"
                        class="form-control input-custom @error('nome') is-invalid @enderror">
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="local" class="form-label fw-semibold">Local</label>
                    <input type="text" id="local" name="local" value="{{ old('local', $studio->local) }}"
                        class="form-control input-custom @error('local') is-invalid @enderror">
                    @error('local')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if($studio->image->isNotEmpty())
                    <div class="mb-3 pb-3">
                        <label class="form-label fw-semibold d-block">Imagens Atuais (Selecione para remover)</label>
                        <div class="d-flex flex-wrap gap-3 p-3 bg-light rounded border">
                            @foreach($studio->image as $img)
                                <div class="text-center" style="width: 100px;">
                                    <img src="{{ asset('storage/' . $img->caminho) }}"
                                        class="img-thumbnail w-100 object-fit-cover mb-2"
                                        style="height: 100px;">
                                    <div class="form-check d-flex align-items-center justify-content-center m-0 p-0">
                                        <input class="form-check-input m-0" type="checkbox" name="remover_imagens[]"
                                            value="{{ $img->id }}" id="img-{{ $img->id }}">
                                        <label class="form-check-label small text-danger ms-1 fw-medium"
                                            for="img-{{ $img->id }}" style="cursor: pointer;">Remover</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="imagens" class="form-label fw-semibold">Adicionar Novas Imagens</label>
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
                    <a href="{{ route('estudios.index') }}" class="btn btn-remover">Cancelar</a>
                    <button type="submit" class="btn btn-accent">Salvar alterações</button>
                </div>
            </form>
        </div>

    </div>

@endsection