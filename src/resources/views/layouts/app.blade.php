<!DOCTYPE html>
<html lang='pt-BR'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>@yield('titulo', 'Meu Sistema')</title>
    {{-- Estilos específicos de cada página (opcional) --}}
    @stack('styles')
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>

<body>
    <nav>
        <a href='/'>Início</a>
        <a href='/produtos'>Produtos</a>
    </nav>
    <main>
        {{-- Aqui será inserido o conteúdo de cada página --}}
        @yield('conteudo')
    </main>
    <footer>
        <p>&copy; {{ date('Y') }} Meu Sistema</p>
    </footer>
    {{-- Scripts específicos de cada página (opcional) --}}
    @stack('scripts')
</body>

</html>