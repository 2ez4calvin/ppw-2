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