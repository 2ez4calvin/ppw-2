@extends('layouts.app')

@section('conteudo')
<div class="container py-4" style="max-width: 550px;">
    <h2 class="fw-bold mb-4">Nova Avaliação</h2>

    @if($errors->has('error'))
        <div class="alert alert-danger">{{ $errors->first('error') }}</div>
    @endif

    <div class="p-4 caixa">
        <form action="{{ route('reviews.update', $review->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="movie_id" class="form-label fw-semibold">Filme</label>
                <select id="movie_id" name="movie_id" class="form-control input-custom" required>
                    <option value="">Selecione o Filme</option>
                    @foreach($movies as $movie)
                        <option value="{{ $movie->id }}" {{ $review->movie_id == $movie->id ? 'selected' : '' }}>
                            {{ $movie->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="user_id" class="form-label fw-semibold">Usuário</label>
                <select id="user_id" name="user_id" class="form-control input-custom" required>
                    <option value="">Selecione o Usuário</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $review->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="nota" class="form-label fw-semibold">Nota (1 a 5 estrelas)</label>
                <select id="nota" name="nota" class="form-control input-custom" required>
                    <option value="5">★★★★★ (5 - Excelente)</option>
                    <option value="4">★★★★☆ (4 - Muito Bom)</option>
                    <option value="3">★★★☆☆ (3 - Regular)</option>
                    <option value="2">★★☆☆☆ (2 - Ruim)</option>
                    <option value="1">★☆☆☆☆ (1 - Péssimo)</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label fw-semibold">Crítica / Comentário</label>
                <textarea id="descricao" name="descricao" rows="4" class="form-control input-custom">{{ $review->descricao }}</textarea>
            </div>

            <div class="d-flex gap-2 justify-content-end mt-4">
                <a href="{{ route('reviews.index') }}" class="btn btn-remover">Cancelar</a>
                <button type="submit" class="btn btn-accent">Salvar Review</button>
            </div>
        </form>
    </div>
</div>
@endsection