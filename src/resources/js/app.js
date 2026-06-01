import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const toggleBtn = document.getElementById('toggle-theme');
const iconeEscuro = document.getElementById('icone-escuro');
const iconeClaro = document.getElementById('icone-claro');

// Aplica o tema salvo ao carregar
const temaSalvo = localStorage.getItem('tema');
const isDarkInicial = temaSalvo === 'dark';

document.documentElement.classList.toggle('dark', isDarkInicial);
iconeEscuro.classList.toggle('hiddenNavbar', isDarkInicial);
iconeClaro.classList.toggle('hiddenNavbar', !isDarkInicial);

toggleBtn.addEventListener('click', () => {
    const isDark = document.documentElement.classList.toggle('dark');

    iconeEscuro.classList.toggle('hiddenNavbar', isDark);
    iconeClaro.classList.toggle('hiddenNavbar', !isDark);

    localStorage.setItem('tema', isDark ? 'dark' : 'light');
});

const filmeId = document.getElementById('avaliacoes-container').dataset.filmeId;
let paginaAtual = 1;
function carregarAvaliacoes(pagina) {
    fetch(`/filmes/${filmeId}/avaliacoes?page=${pagina}`, {
        headers: { 'Accept': 'application/json' }
    })
        .then(res => {
            if (!res.ok) throw new Error('Erro na requisição');
            return res.json();
        })
        .then(dados => {

            renderizarAvaliacoes(dados.data);
            atualizarNavegacao(dados);
            paginaAtual = dados.current_page;
        })
        .catch(erro => {
            document.getElementById('avaliacoes-container').innerHTML =
                '<p class="text-danger">Erro ao carregar avaliações.</p>';
        });
}

function renderizarAvaliacoes(reviews) {
    const container = document.getElementById('avaliacoes-container');
    container.innerHTML = reviews.map(av => `
                <div class="card mb-2">
                    <div class="card-body">
                        <strong>${av.user.name}</strong>
                        <span class="badge bg-primary">${av.nota}/5</span>
                        <p class="mb-0">${av.descricao ?? ''}</p>
                    </div>
                </div>
                `).join('');
}
function atualizarNavegacao(dados) {
    document.getElementById('btn-anterior').disabled = !dados.prev_page_url;
    document.getElementById('btn-proxima').disabled = !dados.next_page_url;
    document.getElementById('info-pagina').textContent =
        `Página ${dados.current_page} de ${dados.last_page}`;
}
document.getElementById('btn-anterior')
    .addEventListener('click', () => carregarAvaliacoes(paginaAtual - 1));
document.getElementById('btn-proxima')
    .addEventListener('click', () => carregarAvaliacoes(paginaAtual + 1));

// Carrega a primeira página ao abrir a página
carregarAvaliacoes(1);
