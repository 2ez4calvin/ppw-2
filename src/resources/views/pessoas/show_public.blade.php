@extends('layouts.app')

@section('conteudo')
    <div class="container py-4" style="max-width: 100%; width: 90vw; margin: 0 auto;">

        <div class="mb-4">
            <a href="{{ route('home') }}" class="text-muted text-decoration-none small">
                ← Voltar
            </a>
        </div>

        <div class=" border-0 mb-4 p-4 div-demonstracao">
            <div class="row g-4 align-items-stretch">

                <div class="col-sm-5 col-md-4 d-flex flex-column">
                    @if($person->image && $person->image->isNotEmpty())
                        <div class="rounded shadow-sm overflow-hidden border flex-grow-1"
                            style="border-color: var(--bg-elevated) !important; background-color: rgba(0,0,0,0.02); min-height: 320px;">
                            <img src="{{ asset('storage/' . $person->image->first()->caminho) }}" alt="{{ $person->nome }}"
                                class="w-100 h-100" style="object-fit: cover; display: block;">
                        </div>
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light text-muted rounded shadow-sm w-100 h-100 border"
                            style="border-color: var(--bg-elevated) !important; min-height: 320px;" img
                            src="{{ asset('storage/images/sem_foto.png') }}" alt="Sem foto disponível">
                            <span class="small">Sem foto disponível</span>
                        </div>
                    @endif

                    @if($person->image && $person->image->count() > 1)
                        <div class="d-flex flex-wrap gap-2 justify-content-center mt-2">
                            @foreach($person->image->skip(1) as $img)
                                <img src="{{ asset('storage/' . $img->caminho) }}" alt="Foto extra"
                                    class="img-thumbnail object-fit-cover" style="width: 45px; height: 45px;">
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-sm-7 col-md-8 d-flex flex-column justify-content-between">
                    <div>
                        <h2 class="fw-bold mt-1 mb-2" style="font-size: 1.75rem;">{{ $person->nome }}</h2>
                        <div class="p-3 rounded mb-3 border bg-light row mx-0 g-2 small"
                            style="background-color: rgba(0,0,0,0.02) !important;">
                            <div class="col-6 border-end pr-2">
                                <strong class="text-muted small d-block uppercase"
                                    style="font-size: 0.7rem;">NASCIMENTO</strong>
                                <span
                                    class="fw-semibold">{{ $person->data_nascimento ? date('d/m/Y', strtotime($person->data_nascimento)) : 'Não informada' }}</span>
                            </div>
                            <div class="col-6 pl-2">
                                <strong class="text-muted small d-block uppercase"
                                    style="font-size: 0.7rem;">NACIONALIDADE</strong>
                                <span class="fw-semibold">{{ $person->nacionalidade ?? 'Não informada' }}</span>
                            </div>
                        </div>

                        <div class="mt-3">
                            <strong class="text-muted small text-uppercase d-block mb-1"
                                style="letter-spacing: 0.05em; font-size: 0.75rem;">Biografia</strong>
                            <p class="mb-0"
                                style="white-space: pre-line; text-align: justify; line-height: 1.5; font-size: 0.95rem;">
                                {{ $person->biografia ?? 'Nenhuma biografia cadastrada para esta pessoa.' }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <h4 class="fw-bold  mt-5 mb-3">Participações</h4>

        <div class="row g-4">

            @if($person->actor && $person->actor->movie && $person->actor->movie->isNotEmpty())
                <div class="col-12">
                    <div class="p-3 caixa">
                        <h5 class="fw-bold text-primary mb-3">Interpretações</h5>
                        <div class="list-group list-group-flush">
                            @foreach($person->actor->movie as $movie)
                                <div
                                    class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0 py-2 lista-publico">
                                    <div>
                                        <a href="{{ route('filmePublico', $movie->id) }}" class="text-decoration-none fw-semibold"
                                            style="color: var(--text-primary);">
                                            {{ $movie->nome }}
                                        </a>
                                        <span
                                            class="text-muted small ms-2">({{ date('Y', strtotime($movie->data_lancamento)) }})</span>
                                    </div>
                                    @if(isset($movie->pivot->papel) && $movie->pivot->papel)
                                        <span class="badge bg-light text-secondary border">Interpreta: {{ $movie->pivot->papel }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if($person->director && $person->director->movie && $person->director->movie->isNotEmpty())
                <div class="col-md-6">
                    <div class="p-3 caixa h-100">
                        <h5 class="fw-bold text-secondary mb-3">Como Diretor(a)</h5>
                        <ul class="list-group list-group-flush">
                            @foreach($person->director->movie as $movie)
                                <li class="list-group-item bg-transparent px-0 py-2">
                                    <a href="{{ route('filmePublico', $movie->id) }}" class="text-decoration-none fw-bold"
                                        style="color: var(--text-primary);">
                                        {{ $movie->nome }}
                                    </a>
                                    <span class="text-muted small ms-1">({{ date('Y', strtotime($movie->data_lancamento)) }})</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if($person->writer && $person->writer->movie && $person->writer->movie->isNotEmpty())
                <div class="col-md-6">
                    <div class="p-3 caixa h-100">
                        <h5 class="fw-bold text-info mb-3">Como Escritor(a) / Roteirista</h5>
                        <ul class="list-group list-group-flush">
                            @foreach($person->writer->movie as $movie)
                                <li class="list-group-item bg-transparent px-0 py-2">
                                    <a href="{{ route('filmePublico', $movie->id) }}" class="text-decoration-none fw-bold"
                                        style="color: var(--text-primary);">
                                        {{ $movie->nome }}
                                    </a>
                                    <span class="text-muted small ms-1">({{ date('Y', strtotime($movie->data_lancamento)) }})</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if($person->producer && $person->producer->movie && $person->producer->movie->isNotEmpty())
                <div class="col-12">
                    <div class="p-3 caixa">
                        <h5 class="fw-bold mb-3">Como Produtor(a)</h5>
                        <ul class="list-group list-group-flush lista-publico">
                            @foreach($person->producer->movie as $movie)
                                <li class="list-group-item lista-publico px-0 py-2">
                                    <a href="{{ route('movies.show', $movie->id) }}" class="text-decoration-none fw-bold"
                                        style="color: var(--text-primary);">
                                        {{ $movie->nome }}
                                    </a>
                                    <span class="text-muted small ms-1">({{ date('Y', strtotime($movie->data_lancamento)) }})</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @if(
                    (!$person->actor || !$person->actor->movie || $person->actor->movie->isEmpty()) &&
                    (!$person->director || !$person->director->movie || $person->director->movie->isEmpty()) &&
                    (!$person->writer || !$person->writer->movie || $person->writer->movie->isEmpty()) &&
                    (!$person->producer || !$person->producer->movie || $person->producer->movie->isEmpty())
                )
                <div class="col-12 text-center py-4">
                    <p class="text-muted italic">Nenhuma participação em filmes registrada para esta pessoa.</p>
                </div>
            @endif

        </div>

    </div>
@endsection