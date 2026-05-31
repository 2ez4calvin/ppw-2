@extends('layouts.app')

@section('conteudo')
<div class="container py-4" style="max-width: 600px;">
    <div class="mb-4">
        <a href="{{ route('filmes.index') }}" class="text-muted text-decoration-none small">Voltar</a>
        <h2 class="fw-bold mt-2 mb-0">Editar Filme</h2>
    </div>

    @if($errors->has('error'))
        <div class="alert alert-danger">
            {{ $errors->first('error') }}
        </div>
    @endif

    <div class="p-4 caixa">
        <form action="{{ route('filmes.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nome" class="form-label fw-semibold">Título do Filme</label>
                <input type="text" id="nome" name="nome" value="{{ old('nome', $movie->nome) }}"
                    class="form-control input-custom @error('nome') is-invalid @enderror" required>
                @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="data_lancamento" class="form-label fw-semibold">Data de Lançamento</label>
                    <input type="date" id="data_lancamento" name="data_lancamento" value="{{ old('data_lancamento', $movie->data_lancamento) }}"
                        class="form-control input-custom @error('data_lancamento') is-invalid @enderror" required>
                    @error('data_lancamento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="duracao" class="form-label fw-semibold">Duração (minutos)</label>
                    <input type="number" id="duracao" name="duracao" value="{{ old('duracao', $movie->duracao) }}"
                        class="form-control input-custom @error('duracao') is-invalid @enderror" required>
                    @error('duracao') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="classificacao" class="form-label fw-semibold">Classificação</label>
                    <input type="text" id="classificacao" name="classificacao" value="{{ old('classificacao', $movie->classificacao) }}"
                        class="form-control input-custom @error('classificacao') is-invalid @enderror">
                    @error('classificacao') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="studio_id" class="form-label fw-semibold">Estúdio</label>
                    <select id="studio_id" name="studio_id" class="form-control input-custom @error('studio_id') is-invalid @enderror" required>
                        @foreach($studios as $studio)
                            <option value="{{ $studio->id }}" {{ old('studio_id', $movie->studio_id) == $studio->id ? 'selected' : '' }}>{{ $studio->nome }}</option>
                        @endforeach
                    </select>
                    @error('studio_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="sinopse" class="form-label fw-semibold">Sinopse</label>
                <textarea id="sinopse" name="sinopse" rows="4" class="form-control input-custom @error('sinopse') is-invalid @enderror">{{ old('sinopse', $movie->sinopse) }}</textarea>
                @error('sinopse') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="genres" class="form-label fw-semibold">Gêneros</label>
                <select id="genres" name="genres[]" class="form-control input-custom @error('genres') is-invalid @enderror" multiple required style="height: 100px;">
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ in_array($genre->id, old('genres', $movie->genres->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $genre->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="directors" class="form-label fw-semibold">Diretores</label>
                <select id="directors" name="directors[]" class="form-control input-custom @error('directors') is-invalid @enderror" multiple required style="height: 80px;">
                    @foreach($directors as $director)
                        <option value="{{ $director->id }}" {{ in_array($director->id, old('directors', $movie->directors->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $director->person->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="actors" class="form-label fw-semibold">Atores / Elenco</label>
                <select id="actors" name="actors[]" class="form-control input-custom" multiple style="height: 100px;">
                    @foreach($actors as $actor)
                        <option value="{{ $actor->id }}" {{ in_array($actor->id, old('actors', $movie->actors->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $actor->person->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="writers" class="form-label fw-semibold">Escritores</label>
                <select id="writers" name="writers[]" class="form-control input-custom" multiple style="height: 80px;">
                    @foreach($writers as $writer)
                        <option value="{{ $writer->id }}" {{ in_array($writer->id, old('writers', $movie->writers->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $writer->person->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="producers" class="form-label fw-semibold">Produtores</label>
                <select id="producers" name="producers[]" class="form-control input-custom" multiple style="height: 80px;">
                    @foreach($producers as $producer)
                        <option value="{{ $producer->id }}" {{ in_array($producer->id, old('producers', $movie->producers->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $producer->person->nome }}</option>
                    @endforeach
                </select>
            </div>

            <hr class="my-4" style="border-color: var(--bg-elevated);">

            @if($movie->images->isNotEmpty())
                <div class="mb-3">
                    <span class="form-label fw-semibold d-block mb-2">Imagens Atuais (Marque para remover)</span>
                    <div class="row g-2">
                        @foreach($movie->images as $img)
                            <div class="col-4 text-center">
                                <div class="position-relative border rounded p-1 d-inline-block bg-light">
                                    <img src="{{ asset('storage/' . $img->caminho) }}" alt="{{ $img->nome }}" class="img-thumbnail object-fit-cover" style="width: 120px; height: 120px;">
                                    <div class="form-check justify-content-center mt-1">
                                        <input class="form-check-input" type="checkbox" name="remover_imagens[]" value="{{ $img->id }}" id="img-{{ $img->id }}">
                                        <label class="form-check-label small text-danger fw-medium" for="img-{{ $img->id }}" style="cursor: pointer;">Remover</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mb-3">
                <label for="imagens" class="form-label fw-semibold">Adicionar Novas Imagens</label>
                <input type="file" id="imagens" name="imagens[]" multiple accept="image/*" class="form-control input-custom @error('imagens') is-invalid @enderror">
                @error('imagens') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex gap-2 justify-content-end mt-4">
                <a href="{{ route('filmes.index') }}" class="btn btn-remover">Cancelar</a>
                <button type="submit" class="btn btn-accent">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>
@endsection