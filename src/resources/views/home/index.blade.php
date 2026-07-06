@extends('layouts.app')
@section('titulo', 'IMDp - Página Inicial')

@section('conteudo')
    <div class="container py-4" style="max-width: 100%; width: 90vw; margin: 0 auto;">
        @if(isset($carouselMovies) && $carouselMovies->isNotEmpty())
            <div class="d-flex justify-content-center mb-5">
                <div id="carouselExample" class="carousel slide col-md-12 shadow rounded overflow-hidden">
                    <div class="carousel-inner">
                        @foreach($carouselMovies as $index => $movie)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="position-relative" style="height: 400px; background-color: #000;">
                                    @if($movie->images && $movie->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $movie->images->first()->caminho) }}"
                                            class="d-block w-100 h-100 opacity-75" style="object-fit: cover;" alt="{{ $movie->nome }}">
                                    @else
                                        <img src="{{ asset('imagens/placeholder.png') }}" class="d-block w-100 h-100 opacity-50"
                                            style="object-fit: cover;" alt="">
                                    @endif
                                    <div class="carousel-caption d-none d-md-block text-start p-4 rounded align-itens-start">
                                        <h3 class="fw-bold --text-primary">{{ $movie->nome }}</h3>
                                        <p class="small text-truncate-2 mb-3">{{ $movie->sinopse }}</p>
                                        <a href="{{ route('filmePublico', $movie->id) }}"
                                            class="btn btn-sm btn-accent text-white text-decoration-none px-3 py-2 rounded">Ver
                                            Detalhes</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Próximo</span>
                    </button>
                </div>
            </div>
        @endif
        @if(isset($movies) && $movies->isNotEmpty())
            <h4 class="fw-bold mb-3 mt-4">Filmes em Destaque</h4>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
                @foreach($movies as $movie)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm div-demonstracao">
                            <div style="height: 240px; overflow: hidden;" class="position-relative bg-light rounded-top">
                                @if($movie->images && $movie->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $movie->images->first()->caminho) }}"
                                        class="w-100 h-100 object-fit-cover" alt="{{ $movie->nome }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 text-muted small">Sem Poster
                                    </div>
                                @endif
                            </div>
                            <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                                <div>
                                    <h5 class="fw-bold mb-1 text-truncate" style="font-size: 1.1rem;">{{ $movie->nome }}</h5>
                                    <p class="text-muted small mb-2">{{ $movie->duracao ? $movie->duracao . ' min' : '' }} |
                                        {{ $movie->classificacao ?? 'Livre' }}</p>
                                    <p class="text-muted small text-truncate-3 mb-3" style="font-size: 0.85rem;">
                                        {{ $movie->sinopse ?? 'Sem sinopse.' }}</p>
                                </div>
                                <a href="{{ route('filmePublico', $movie->id) }}"
                                    class="btn-accent text-center text-decoration-none mt-auto">
                                    Ver mais <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @if(isset($actors) && $actors->isNotEmpty())
            <h4 class="fw-bold mb-3 mt-5">Atores e Atrizes</h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mb-5">
                @foreach($actors as $actor)
                    @if($actor->person)
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm p-3 text-center div-demonstracao">
                                <div class="mx-auto mb-3 rounded-circle overflow-hidden shadow-sm border"
                                    style="width: 100px; height: 100px;">
                                    @if($actor->person->image && $actor->person->image->isNotEmpty())
                                        <img src="{{ asset('storage/' . $actor->person->image->first()->caminho) }}"
                                            alt="{{ $actor->person->nome }}" class="w-100 h-100 object-fit-cover">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted small">Foto
                                        </div>
                                    @endif
                                </div>
                                <h6 class="fw-bold mb-1 text-truncate">{{ $actor->person->nome }}</h6>
                                <p class="text-muted small text-truncate mb-3" style="font-size: 0.8rem;">
                                    {{ $actor->person->nacionalidade ?? 'Nacionalidade não informada' }}</p>
                                <a href="{{ route('pessoaPublico', $actor->person->id) }}"
                                    class="btn btn-sm btn-outline-secondary w-100 rounded">Ver Perfil</a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
        @if(isset($directors) && $directors->isNotEmpty())
            <h4 class="fw-bold mb-3 mt-5">Diretores e Diretoras</h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mb-5">
                @foreach($directors as $director)
                    @if($director->person)
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm p-3 text-center div-demonstracao">
                                <div class="mx-auto mb-3 rounded-circle overflow-hidden shadow-sm border"
                                    style="width: 100px; height: 100px;">
                                    @if($director->person->image && $director->person->image->isNotEmpty())
                                        <img src="{{ asset('storage/' . $director->person->image->first()->caminho) }}"
                                            alt="{{ $director->person->nome }}" class="w-100 h-100 object-fit-cover">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted small">Foto
                                        </div>
                                    @endif
                                </div>
                                <h6 class="fw-bold mb-1 text-truncate">{{ $director->person->nome }}</h6>
                                <p class="text-muted small text-truncate mb-3" style="font-size: 0.8rem;">
                                    {{ $director->person->nacionalidade ?? 'Nacionalidade não informada' }}</p>
                                <a href="{{ route('pessoaPublico', $director->person->id) }}"
                                    class="btn btn-sm btn-outline-secondary w-100 rounded">Ver Perfil</a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
        @if(isset($recentReviews) && $recentReviews->isNotEmpty())
            <h4 class="fw-bold mb-3 mt-5">Avaliações Recentes dos Usuários</h4>
            <div class="row row-cols-1 row-cols-md-2 g-4 mb-4">
                @foreach($recentReviews as $review)
                    <div class="col">
                        <div class="p-3 rounded border shadow-sm h-100 d-flex flex-column justify-content-between spec-review"
                            style="background-color: rgba(0,0,0,0.01) !important;">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <strong style="color: var(--text-primary); font-size: 0.95rem;">
                                            {{ $review->user ? $review->user->name : 'Usuário Anônimo' }}
                                            </h6>
                                            <span class="text-muted d-block" style="font-size: 0.75rem;">
                                                avaliou <a href="{{ route('filmePublico', $review->movie->id) }}"
                                                    class="text-decoration-none fw-semibold text-primary">{{ $review->movie->nome }}</a>
                                            </span>
                                    </div>
                                    <span class="badge bg-primary px-2 py-1" style="font-size: 0.75rem;">★
                                        {{ $review->nota }}/5</span>
                                </div>
                                <p class="mb-0 text-muted small text-truncate-3"
                                    style="white-space: pre-line; text-align: justify; line-height: 1.4;">
                                    {!! $review->descricao ? e($review->descricao) : '<span class="text-muted fst-italic opacity-70">Avaliado sem comentário escrito.</span>' !!}
                                </p>
                            </div>
                            <small class="text-muted d-block text-end mt-2"
                                style="font-size: 0.7rem;">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection