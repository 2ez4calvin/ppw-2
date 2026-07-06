@extends('layouts.app')
@section('conteudo')
    <div class="container py-4" style="max-width: 100%; width: 90vw; margin: 0 auto;">
        <div class="mb-4">
            <a href="{{ route('home') }}" class="text-muted text-decoration-none small">
                ← Voltar
            </a>
        </div>
        <div class="border-0 mb-4 p-4 div-demonstracao">
            <div class="row g-4 align-items-stretch">
                <div class="col-sm-5 col-md-4 d-flex flex-column">
                    @if($movie->images && $movie->images->isNotEmpty())
                        <div class="rounded shadow-sm overflow-hidden border flex-grow-1"
                            style="border-color: var(--bg-elevated) !important; background-color: rgba(0,0,0,0.02); min-height: 320px;">
                            <img src="{{ asset('storage/' . $movie->images->first()->caminho) }}" alt="{{ $movie->nome }}"
                                class="w-100 h-100" style="object-fit: cover; display: block;">
                        </div>
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light text-muted rounded shadow-sm w-100 h-100 border"
                            style="border-color: var(--bg-elevated) !important; min-height: 320px;">
                            <span class="small">Sem poster disponível</span>
                        </div>
                    @endif
                    @if($movie->images && $movie->images->count() > 1)
                        <div class="d-flex flex-wrap gap-2 justify-content-center mt-2">
                            @foreach($movie->images->skip(1) as $img)
                                <img src="{{ asset('storage/' . $img->caminho) }}" alt="Foto extra do filme"
                                    class="img-thumbnail object-fit-cover" style="width: 45px; height: 45px;">
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-sm-7 col-md-8 d-flex flex-column justify-content-between">
                    <div>
                        <h2 class="fw-bold mt-1 mb-2" style="font-size: 1.75rem;">{{ $movie->nome }}</h2>
                        <div class="p-3 rounded mb-3 border bg-light row mx-0 g-2 small"
                            style="background-color: rgba(0,0,0,0.02) !important;">
                            <div class="col-4 border-end pr-2">
                                <strong class="text-muted small d-block uppercase"
                                    style="font-size: 0.7rem;">LANÇAMENTO</strong>
                                <span class="fw-semibold">
                                    {{ $movie->data_lancamento ? date('d/m/Y', strtotime($movie->data_lancamento)) : 'Não informado' }}
                                </span>
                            </div>
                            <div class="col-4 border-end px-2">
                                <strong class="text-muted small d-block uppercase"
                                    style="font-size: 0.7rem;">DURAÇÃO</strong>
                                <span
                                    class="fw-semibold">{{ $movie->duracao ? $movie->duracao . ' min' : 'Não informada' }}</span>
                            </div>
                            <div class="col-4 pl-2">
                                <strong class="text-muted small d-block uppercase"
                                    style="font-size: 0.7rem;">CLASSIFICAÇÃO</strong>
                                <span class="fw-semibold">{{ $movie->classificacao ?? 'Livre' }}</span>
                            </div>
                        </div>
                        @if($movie->genres && $movie->genres->isNotEmpty())
                            <div class="mb-3">
                                @foreach($movie->genres as $genre)
                                    <span class="badge bg-secondary me-1">{{ $genre->nome }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="mt-3">
                            <strong class="text-muted small text-uppercase d-block mb-1"
                                style="letter-spacing: 0.05em; font-size: 0.75rem;">Sinopse</strong>
                            <p class="mb-0"
                                style="white-space: pre-line; text-align: justify; line-height: 1.5; font-size: 0.95rem;">
                                {{ $movie->sinopse ?? 'Nenhuma sinopse cadastrada para este filme.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="fw-bold mt-5 mb-3">Créditos e Elenco</h4>
        <div class="row g-4">
            @if($movie->actors && $movie->actors->isNotEmpty())
                <div class="col-12">
                    <div class="p-3 caixa">
                        <h5 class="fw-bold text-primary mb-3">Elenco (Atores / Atrizes)</h5>
                        <div class="row g-3">
                            @foreach($movie->actors as $actor)
                                @if($actor->person)
                                    <div class="col-12 col-lg-4">
                                        <div class="d-flex align-items-center p-2 rounded border bg-transparent list-group-item">
                                            <div class="me-3" style="width: 50px; height: 50px; flex-shrink: 0;">
                                                @if($actor->person->image && $actor->person->image->isNotEmpty())
                                                    <img src="{{ asset('storage/' . $actor->person->image->first()->caminho) }}"
                                                        alt="{{ $actor->person->nome }}" class="rounded-circle w-100 h-100"
                                                        style="object-fit: cover;">
                                                @else
                                                @endif
                                            </div>
                                            <div>
                                                <a href="{{ route('pessoaPublico', $actor->person->id) }}"
                                                    class="text-decoration-none fw-semibold d-block"
                                                    style="color: var(--text-primary);">
                                                    {{ $actor->person->nome }}
                                                </a>
                                                @if(isset($actor->pivot->papel) && $actor->pivot->papel)
                                                    <small class="text-muted">como <span
                                                            class="fst-italic text-secondary">{{ $actor->pivot->papel }}</span></small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            @if($movie->directors && $movie->directors->isNotEmpty())
                <div class="col-12">
                    <div class="p-3 caixa h-100">
                        <h5 class="fw-bold text-secondary mb-3">Direção</h5>
                        <ul class="list-group list-group-flush">
                            @foreach($movie->directors as $director)
                                @if($director->person)
                                    <li class="list-group-item bg-transparent px-0 py-2">
                                        <a href="{{ route('pessoaPublico', $director->person->id) }}"
                                            class="text-decoration-none fw-bold" style="color: var(--text-primary);">
                                            {{ $director->person->nome }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @if($movie->writers && $movie->writers->isNotEmpty())
                <div class="col-12">
                    <div class="p-3 caixa h-100">
                        <h5 class="fw-bold text-info mb-3">Roteiro</h5>
                        <ul class="list-group list-group-flush">
                            @foreach($movie->writers as $writer)
                                @if($writer->person)
                                    <li class="list-group-item bg-transparent px-0 py-2">
                                        <a href="{{ route('pessoaPublico', $writer->person->id) }}" class="text-decoration-none fw-bold"
                                            style="color: var(--text-primary);">
                                            {{ $writer->person->nome }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @if($movie->producers && $movie->producers->isNotEmpty())
                <div class="col-12">
                    <div class="p-3 caixa">
                        <h5 class="fw-bold mb-3" style="color: #6f42c1;">Produção</h5>
                        <ul class="list-group list-group-flush">
                            @foreach($movie->producers as $producer)
                                @if($producer->person)
                                    <li class="list-group-item bg-transparent px-0 py-2">
                                        <a href="{{ route('pessoaPublico', $producer->person->id) }}"
                                            class="text-decoration-none fw-bold" style="color: var(--text-primary);">
                                            {{ $producer->person->nome }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @if($movie->actors->isEmpty() && $movie->directors->isEmpty() && $movie->writers->isEmpty() && $movie->producers->isEmpty())
                <div class="col-12 text-center py-4">
                    <p class="text-muted italic">Nenhuma informação de elenco ou equipe técnica registrada para este filme.</p>
                </div>
            @endif
        </div>
        <section id="secao-avaliacoes" class="mb-5 mt-5">
            @if(session('erro_review'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('erro_review') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('sucesso'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('sucesso') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">Avaliações dos Usuários</h4>
                <button type="button" class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#modalNovaAvaliacao">
                    + Adicionar Avaliação
                </button>
            </div>
            <div id="avaliacoes-container">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary spinner-border-sm me-2" role="status"></div>
                    <span class="text-muted small">Carregando avaliações...</span>
                </div>
            </div>
            <div id="navegacao-avaliacoes" class="d-flex align-items-center gap-3 mt-3 d-none">
                <button id="btn-anterior" class="btn btn-sm btn-outline-secondary" disabled>
                    ← Anterior
                </button>
                <span id="info-pagina" class="text-muted small fw-semibold"></span>
                <button id="btn-proxima" class="btn btn-sm btn-outline-secondary">
                    Próxima →
                </button>
            </div>
        </section>
        <div class="modal fade" id="modalNovaAvaliacao" tabindex="-1" aria-labelledby="modalNovaAvaliacaoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="modalNovaAvaliacaoLabel">Nova Avaliação para {{ $movie->nome }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <div class="mb-3">
                                <label for="nota" class="form-label small fw-semibold text-muted">Sua Nota (★ de 1 a
                                    5)</label>
                                <select class="form-select" name="nota" id="nota" required>
                                    <option value="" disabled selected>Selecione uma nota...</option>
                                    <option value="5">★★★★★ (5/5) - Excelente</option>
                                    <option value="4">★★★★☆ (4/5) - Muito Bom</option>
                                    <option value="3">★★★☆☆ (3/5) - Regular</option>
                                    <option value="2">★★☆☆☆ (2/5) - Ruim</option>
                                    <option value="1">★☆☆☆☆ (1/5) - Péssimo</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="descricao" class="form-label small fw-semibold text-muted">Seu Comentário
                                    (Opcional)</label>
                                <textarea class="form-control" name="descricao" id="descricao" rows="4"
                                    placeholder="Escreva aqui o que achou do filme..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-top-0">
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-sm btn-accent">Enviar Avaliação</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
    @push('scripts')
        <script>
            (function () {
                const filmeId = {{ $movie->id }};
                let paginaAtual = 1;
                let usuarioLogadoId = null;

                function carregarAvaliacoesPrivado(pagina) {
                    fetch(`/filmes/${filmeId}/avaliacoes?page=${pagina}`, {
                        headers: { 'Accept': 'application/json' }
                    })
                        .then(res => res.json())
                        .then(dados => {
                            usuarioLogadoId = dados.usuario_logado_id;
                            renderizarAvaliacoesPrivado(dados.data);
                            atualizarNavegacaoPrivado(dados);
                            paginaAtual = dados.current_page;
                        })
                        .catch(erro => {
                            console.error(erro);
                            const container = document.getElementById('avaliacoes-container');
                            if (container) {
                                container.innerHTML =
                                    '<div class="p-3 border rounded text-danger text-center bg-light small">Erro ao carregar as avaliações.</div>';
                            }
                        });
                }
                function renderizarAvaliacoesPrivado(avaliacoes) {
                    const container = document.getElementById('avaliacoes-container');
                    if (!container) return;
                    if (avaliacoes.length === 0) {
                        container.innerHTML = '<p class="text-muted fst-italic small py-2">Este filme ainda não recebeu nenhuma avaliação.</p>';
                        const nav = document.getElementById('navegacao-avaliacoes');
                        if (nav) nav.classList.add('d-none');
                        return;
                    }
                    container.innerHTML = avaliacoes.map(av => {
                        const ehMinhaAvaliacao = (av.user_id === usuarioLogadoId);
                        const botaoDeletarHtml = ehMinhaAvaliacao ? `
                                        <form action="/reviews/${av.id}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir sua avaliação?');" class="d-inline">
                                            <input type="hidden" name="_token" value="${document.querySelector('input[name="_token"]').value}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0 p-1" title="Excluir minha avaliação" style="font-size: 0.75rem;">
                                                <i class="bi bi-trash3-fill"></i> Excluir
                                            </button>
                                        </form>
                                    ` : '';
                        return `
                                        <div class="p-3 mb-2 rounded border bg-transparent list-group-item spec-review" style="background-color: rgba(0,0,0,0.01) !important;">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <strong style="color: var(--text-primary); font-size: 0.95rem;">
                                                        ${av.user ? av.user.name : 'Usuário Anônimo'}
                                                    </strong>
                                                    ${ehMinhaAvaliacao ? '<span class="badge bg-secondary ms-2" style="font-size: 0.65rem; vertical-align: middle;">Sua avaliação</span>' : ''}
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge bg-primary px-2 py-1" style="font-size: 0.75rem;">★ ${av.nota}/5</span>
                                                    ${botaoDeletarHtml}
                                                </div>
                                            </div>
                                            <p class="mb-0 text-muted small" style="white-space: pre-line; text-align: justify; line-height: 1.4;">
                                                ${av.descricao ? av.descricao : '<span class="text-muted fst-italic opacity-70">Avaliado sem comentário escrito.</span>'}
                                            </p>
                                        </div>
                                    `;
                    }).join('');
                }
                function atualizarNavegacaoPrivado(dados) {
                    const navContainer = document.getElementById('navegacao-avaliacoes');
                    if (!navContainer) return;
                    if (dados.last_page > 1) {
                        navContainer.classList.remove('d-none');
                        document.getElementById('btn-anterior').disabled = !dados.prev_page_url;
                        document.getElementById('btn-proxima').disabled = !dados.next_page_url;
                        document.getElementById('info-pagina').textContent = `Página ${dados.current_page} de ${dados.last_page}`;
                    } else {
                        navContainer.classList.add('d-none');
                    }
                }
                document.getElementById('btn-anterior').addEventListener('click', () => carregarAvaliacoesPrivado(paginaAtual - 1));
                document.getElementById('btn-proxima').addEventListener('click', () => carregarAvaliacoesPrivado(paginaAtual + 1));
                carregarAvaliacoesPrivado(1);
            })();
        </script>
    @endpush