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
                        <input type="date" id="data_lancamento" name="data_lancamento"
                            value="{{ old('data_lancamento', $movie->data_lancamento) }}"
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
                        <input type="text" id="classificacao" name="classificacao"
                            value="{{ old('classificacao', $movie->classificacao) }}"
                            class="form-control input-custom @error('classificacao') is-invalid @enderror">
                        @error('classificacao') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="studio_id" class="form-label fw-semibold">Estúdio</label>
                        <select id="studio_id" name="studio_id"
                            class="form-control input-custom @error('studio_id') is-invalid @enderror" required>
                            @foreach($studios as $studio)
                                <option value="{{ $studio->id }}" {{ old('studio_id', $movie->studio_id) == $studio->id ? 'selected' : '' }}>{{ $studio->nome }}</option>
                            @endforeach
                        </select>
                        @error('studio_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="sinopse" class="form-label fw-semibold">Sinopse</label>
                    <textarea id="sinopse" name="sinopse" rows="4"
                        class="form-control input-custom @error('sinopse') is-invalid @enderror">{{ old('sinopse', $movie->sinopse) }}</textarea>
                    @error('sinopse') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="genres" class="form-label fw-semibold">Gêneros</label>
                    <select id="genres" name="genres[]"
                        class="form-control input-custom @error('genres') is-invalid @enderror" multiple required
                        style="height: 100px;">
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ in_array($genre->id, old('genres', $movie->genres->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $genre->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Pessoas vinculadas</label>
                    <div id="vinculos-container"></div>
                    <button type="button" id="btn-vincular" class="btn btn-outline-secondary btn-sm mt-2">
                        + Vincular pessoa
                    </button>
                    @error('vinculos') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <template id="template-vinculo">
                    <div class="card mb-2 card-vinculo">
                        <div class="card-body p-2">
                            <input type="text" class="form-control mb-2 campo-busca"
                                placeholder="Buscar pelo nome da pessoa...">
                            <div class="lista-resultados list-group mb-2"></div>
                            <input type="hidden" class="campo-pessoa-id">
                            <span class="nome-pessoa text-muted small fw-bold"></span>
                            <select class="form-select form-select-sm mb-2 campo-tipo">
                                <option value="ator">Ator</option>
                                <option value="diretor">Diretor</option>
                                <option value="produtor">Produtor</option>
                                <option value="escritor">Escritor</option>
                            </select>
                            <input type="text" class="form-control form-control-sm campo-personagem"
                                placeholder="Nome do personagem">
                            <button type="button" class="btn btn-sm btn-outline-danger mt-1 btn-remover">
                                Remover vínculo
                            </button>
                        </div>
                    </div>
                </template>

                <hr class="my-4" style="border-color: var(--bg-elevated);">

                @if($movie->images->isNotEmpty())
                    <div class="mb-3">
                        <span class="form-label fw-semibold d-block mb-2">Imagens Atuais (Marque para remover)</span>
                        <div class="row g-2">
                            @foreach($movie->images as $img)
                                <div class="col-4 text-center">
                                    <div class="position-relative border rounded p-1 d-inline-block bg-light">
                                        <img src="{{ asset('storage/' . $img->caminho) }}" alt="{{ $img->nome }}"
                                            class="img-thumbnail object-fit-cover" style="width: 120px; height: 120px;">
                                        <div class="form-check justify-content-center mt-1">
                                            <input class="form-check-input" type="checkbox" name="remover_imagens[]"
                                                value="{{ $img->id }}" id="img-{{ $img->id }}">
                                            <label class="form-check-label small text-danger fw-medium" for="img-{{ $img->id }}"
                                                style="cursor: pointer;">Remover</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="imagens" class="form-label fw-semibold">Adicionar Novas Imagens</label>
                    <input type="file" id="imagens" name="imagens[]" multiple accept="image/*"
                        class="form-control input-custom @error('imagens') is-invalid @enderror">
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('vinculos-container');
            const template = document.getElementById('template-vinculo');
            const btnVincular = document.getElementById('btn-vincular');
            let indicePessoa = 0;

            function adicionarCardVinculo(dados = null) {
                const card = template.content.cloneNode(true).querySelector('.card-vinculo');

                card.querySelector('.campo-pessoa-id').name = `vinculos[${indicePessoa}][person_id]`;
                card.querySelector('.campo-tipo').name = `vinculos[${indicePessoa}][tipo]`;
                card.querySelector('.campo-personagem').name = `vinculos[${indicePessoa}][papel]`;

                inicializarCard(card);

                if (dados) {
                    card.querySelector('.campo-pessoa-id').value = dados.person_id;
                    card.querySelector('.nome-pessoa').textContent = ' ' + dados.nome;
                    card.querySelector('.campo-tipo').value = dados.tipo;

                    if (dados.tipo === 'ator') {
                        card.querySelector('.campo-personagem').value = dados.papel || '';
                        card.querySelector('.campo-personagem').style.display = 'block';
                    } else {
                        card.querySelector('.campo-personagem').style.display = 'none';
                    }
                }

                container.appendChild(card);
                indicePessoa++;
            }

            btnVincular.addEventListener('click', () => {
                adicionarCardVinculo();
            });

            function inicializarCard(card) {
                const campoBusca = card.querySelector('.campo-busca');
                const listaResultados = card.querySelector('.lista-resultados');
                let timer;

                campoBusca.addEventListener('input', () => {
                    clearTimeout(timer);
                    timer = setTimeout(() => buscarPessoas(campoBusca.value, listaResultados, card), 300);
                });

                card.querySelector('.campo-tipo').addEventListener('change', (e) => {
                    card.querySelector('.campo-personagem').style.display =
                        e.target.value === 'ator' ? 'block' : 'none';
                });

                card.querySelector('.btn-remover').addEventListener('click', () => {
                    card.remove();
                    reindexarVinculos();
                });
            }

            function buscarPessoas(termo, lista, card) {
                if (termo.length < 2) {
                    lista.innerHTML = '';
                    return;
                }

                fetch(`{{ route('persons.buscar') }}?q=${encodeURIComponent(termo)}&movie_id={{ $movie->id }}`, {
                    headers: { 'Accept': 'application/json' }
                })
                    .then(res => res.json())
                    .then(persons => {
                        lista.innerHTML = '';

                        if (persons.length === 0) {
                            lista.innerHTML = '<span class="list-group-item text-muted">Nenhum resultado</span>';
                            return;
                        }

                        persons.forEach(p => {
                            const item = document.createElement('button');
                            item.type = 'button';
                            item.className = 'list-group-item list-group-item-action';

                            const aviso = p.vinculos.length > 0
                                ? ` <small class="text-warning">(já vinculado neste filme como ${p.vinculos.join(', ')})</small>`
                                : '';

                            item.innerHTML = `${p.nome}${aviso}`;

                            item.addEventListener('click', () => {
                                card.querySelector('.campo-pessoa-id').value = p.id;
                                card.querySelector('.campo-busca').value = '';
                                card.querySelector('.nome-pessoa').textContent = ' ' + p.nome;
                                lista.innerHTML = '';
                            });

                            lista.appendChild(item);
                        });
                    })
                    .catch(err => console.error(err));
            }

            function reindexarVinculos() {
                container.querySelectorAll('.card-vinculo').forEach((card, i) => {
                    card.querySelector('.campo-pessoa-id').name = `vinculos[${i}][person_id]`;
                    card.querySelector('.campo-tipo').name = `vinculos[${i}][tipo]`;
                    card.querySelector('.campo-personagem').name = `vinculos[${i}][papel]`;
                });
                indicePessoa = container.querySelectorAll('.card-vinculo').length;
            }

            const dadosIniciais = [];

            @foreach($movie->actors as $actor)
                dadosIniciais.push({
                    person_id: "{{ $actor->person_id }}",
                    nome: "{{ $actor->person->nome }}",
                    tipo: "ator",
                    papel: "{{ $actor->pivot->papel }}"
                });
            @endforeach

            @foreach($movie->directors as $director)
                dadosIniciais.push({
                    person_id: "{{ $director->person_id }}",
                    nome: "{{ $director->person->nome }}",
                    tipo: "diretor",
                    papel: ""
                });
            @endforeach

            @foreach($movie->writers as $writer)
                dadosIniciais.push({
                    person_id: "{{ $writer->person_id }}",
                    nome: "{{ $writer->person->nome }}",
                    tipo: "escritor",
                    papel: ""
                });
            @endforeach

            @foreach($movie->producers as $producer)
                dadosIniciais.push({
                    person_id: "{{ $producer->person_id }}",
                    nome: "{{ $producer->person->nome }}",
                    tipo: "produtor",
                    papel: ""
                });
            @endforeach
            dadosIniciais.forEach(dado => adicionarCardVinculo(dado));
        });
    </script>
@endpush