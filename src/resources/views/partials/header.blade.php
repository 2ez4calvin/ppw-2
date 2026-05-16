<nav class="navbar navbar-expand-sm align-content-center py-3">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/">IMDp</a>


    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end " id="navbarSupportedContent">
      <ul class="navbar-nav flex-row flex-wrap gap-3 align-items-center">
        @auth
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
            <div class="dropdown">
              <button aria-label="Login ou cadastro de usuário" class="botao" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle fs-2"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Meu Perfil</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">Sair</button>
                  </form>
                </li>
              </ul>

            </div>

          </li>
        @endauth
        @guest
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Entrar</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">Registrar</a>
          </li>


        @endguest
        <button id="toggle-theme" aria-label="Alternar tema">
          <i class="bi bi-moon-fill fs-2" id="icone-escuro"></i>
          <i class="bi bi-sun-fill hiddenNavbar fs-2" id="icone-claro"></i>
        </button>
        </li>

      </ul>

    </div>
  </div>
</nav>