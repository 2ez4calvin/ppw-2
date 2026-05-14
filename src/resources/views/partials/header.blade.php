<nav class="navbar navbar-expand-sm align-content-center">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/">IMDp</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav flex-row flex-wrap gap-3 align-items-center" >
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Início</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Filmes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pessoas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Gêneros</a>
        </li>
        <li class="nav-item">
          <button aria-label="Login ou cadastro de usuário" class="botao">
            <i class="bi bi-person-circle fs-4"></i>
            <i class="bi bi-person-circle fs-4 hiddenNavbar"></i>
          </button>
        </li>
          <button id="toggle-theme" aria-label="Alternar tema">
            <i class="bi bi-moon-fill fs-4" id="icone-escuro"></i>
            <i class="bi bi-sun-fill hiddenNavbar fs-4" id="icone-claro"></i>
          </button>
        </li>

      </ul>
    </div>
  </div>
</nav>