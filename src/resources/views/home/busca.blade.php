@extends('layouts.app')

@section('conteudo')
    <div class="container mt-4" >
        <h2>Resultados da busca por: "<strong>{{ $termo }}</strong>"</h2>
        <hr>

        <h3 class="mt-4">Filmes ({{ $movies->total() }})</h3>
        <div class="row g-3">
            @forelse ($movies as $movie)
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch">
                    <div class="card w-100 h-100 d-flex flex-column justify-content-between">
                        @if($movie->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $movie->images->first()->caminho) }}" class="card-img-top"
                                alt="{{ $movie->nome }}" style="height: 220px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default-movie.jpg') }}" class="card-img-top" alt="Sem foto"
                                style="height: 220px; object-fit: cover;">
                        @endif

                        <div class="card-body d-flex flex-column p-3">
                            <h5 class="card-title fw-bold text-truncate mb-2" title="{{ $movie->nome }}">
                                {{ $movie->nome }}
                            </h5>
                            <div class="mb-3 flex-grow-1">
                                @forelse($movie->genres as $genre)
                                    <span class="badge me-1 mb-1 small"
                                        style="background-color: var(--bg-elevated); color: var(--text-primary);">
                                        {{ $genre->nome }}
                                    </span>
                                @empty
                                    <span class="text-muted small italic">Sem gênero</span>
                                @endforelse
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('filmes.show', $movie->id) }}"
                                    class="btn w-100 fw-semibold justify-content-center transition-all btn-sm"
                                    style="background-color: var(--color-info); border: none; color: white;">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="italic text-center py-4" style="color: var(--text-muted);">Nenhum filme encontrado.</p>
                </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $movies->links() }}
        </div>

        <h3 class="mt-5">Atores ({{ $actors->total() }})</h3>
        <div class="row g-3">
            @forelse ($actors as $ator)
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch">
                    <div class="card w-100 h-100 d-flex flex-column justify-content-between">
                        @if($ator->person && $ator->person->image && $ator->person->image->isNotEmpty())
                            <img src="{{ asset('storage/' . $ator->person->image->first()->caminho) }}" class="card-img-top"
                                alt="{{ $ator->person->nome }}" style="height: 220px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default-avatar.jpg') }}" class="card-img-top" alt="Sem foto"
                                style="height: 220px; object-fit: cover;">
                        @endif

                        <div class="card-body d-flex flex-column p-3">
                            <h5 class="card-title fw-bold text-truncate mb-2" title="{{ $ator->person->nome ?? 'Ator' }}">
                                {{ $ator->person->nome ?? 'Sem nome' }}
                            </h5>
                            <div class="mb-3 flex-grow-1">
                                <span class="badge small" style="background-color: var(--bg-elevated); color: var(--text-primary);">
                                    {{ $ator->person->nacionalidade ?? 'Nacionalidade não informada' }}
                                </span>
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('pessoas.show', $ator->person_id) }}"
                                    class="btn w-100 fw-semibold justify-content-center transition-all btn-sm"
                                    style="background-color: var(--color-info); border: none; color: white;">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="italic text-center py-4" style="color: var(--text-muted);">Nenhum ator encontrado.</p>
                </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $actors->links() }}
        </div>

        <h3 class="mt-5">Diretores ({{ $directors->total() }})</h3>
        <div class="row g-3">
            @forelse ($directors as $diretor)
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch">
                    <div class="card w-100 h-100 d-flex flex-column justify-content-between">
                        @if($diretor->person && $diretor->person->image && $diretor->person->image->isNotEmpty())
                            <img src="{{ asset('storage/' . $diretor->person->image->first()->caminho) }}" class="card-img-top"
                                alt="{{ $diretor->person->nome }}" style="height: 220px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default-avatar.jpg') }}" class="card-img-top" alt="Sem foto"
                                style="height: 220px; object-fit: cover;">
                        @endif

                        <div class="card-body d-flex flex-column p-3">
                            <h5 class="card-title fw-bold text-truncate mb-2" title="{{ $diretor->person->nome ?? 'Diretor' }}">
                                {{ $diretor->person->nome ?? 'Sem nome' }}
                            </h5>
                            <div class="mb-3 flex-grow-1">
                                <span class="badge small" style="background-color: var(--bg-elevated); color: var(--text-primary);">
                                    {{ $diretor->person->nacionalidade ?? 'Nacionalidade não informada' }}
                                </span>
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('pessoas.show', $diretor->person_id) }}"
                                    class="btn w-100 fw-semibold justify-content-center transition-all btn-sm"
                                    style="background-color: var(--color-info); border: none; color: white;">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="italic text-center py-4" style="color: var(--text-muted);">Nenhum diretor encontrado.</p>
                </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $directors->links() }}
        </div>

        <h3 class="mt-5">Escritores ({{ $writers->total() }})</h3>
        <div class="row g-3">
            @forelse ($writers as $escritor)
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch">
                    <div class="card w-100 h-100 d-flex flex-column justify-content-between">
                        @if($escritor->person && $escritor->person->image && $escritor->person->image->isNotEmpty())
                            <img src="{{ asset('storage/' . $escritor->person->image->first()->caminho) }}" class="card-img-top"
                                alt="{{ $escritor->person->nome }}" style="height: 220px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default-avatar.jpg') }}" class="card-img-top" alt="Sem foto"
                                style="height: 220px; object-fit: cover;">
                        @endif

                        <div class="card-body d-flex flex-column p-3">
                            <h5 class="card-title fw-bold text-truncate mb-2" title="{{ $escritor->person->nome ?? 'Escritor' }}">
                                {{ $escritor->person->nome ?? 'Sem nome' }}
                            </h5>
                            <div class="mb-3 flex-grow-1">
                                <span class="badge small" style="background-color: var(--bg-elevated); color: var(--text-primary);">
                                    {{ $escritor->person->nacionalidade ?? 'Nacionalidade não informada' }}
                                </span>
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('pessoas.show', $escritor->person_id) }}"
                                    class="btn w-100 fw-semibold justify-content-center transition-all btn-sm"
                                    style="background-color: var(--color-info); border: none; color: white;">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="italic text-center py-4" style="color: var(--text-muted);">Nenhum escritor encontrado.</p>
                </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $writers->links() }}
        </div>

        <h3 class="mt-5">Estúdios ({{ $studios->total() }})</h3>
        <div class="row g-3">
            @forelse ($studios as $estudio)
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch">
                    <div class="card w-100 h-100 d-flex flex-column justify-content-between">
                        @if($estudio->image && $estudio->image->isNotEmpty())
                            <img src="{{ asset('storage/' . $estudio->image->first()->caminho) }}" class="card-img-top"
                                alt="{{ $estudio->nome }}" style="height: 220px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default-studio.jpg') }}" class="card-img-top" alt="Sem foto"
                                style="height: 220px; object-fit: cover;">
                        @endif

                        <div class="card-body d-flex flex-column p-3">
                            <h5 class="card-title fw-bold text-truncate mb-2" title="{{ $estudio->nome }}">
                                {{ $estudio->nome }}
                            </h5>
                            <div class="mb-3 flex-grow-1">
                                <span class="badge small" style="background-color: var(--bg-elevated); color: var(--text-primary);">
                                    {{ $estudio->local ?? 'Localização não informada' }}
                                </span>
                            </div>
                            <div class="mt-auto p-2">
                                <a href="{{ route('estudios.show', $estudio->id) }}"
                                    class="btn w-100 fw-semibold justify-content-center transition-all btn-sm"
                                    style="background-color: var(--color-info); border: none; color: white;">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="italic text-center py-4" style="color: var(--text-muted);">Nenhum estudio encontrado.</p>
                </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $studios->links() }}
        </div>
    </div>
@endsection