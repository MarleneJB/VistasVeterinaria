<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'Veterinaria')</title>
    @stack('styles')
</head>
<body>
    <header>
        <h1>Veterinaria</h1>
    </header>
    <nav>
        <a href="/mascotas">Mascotas</a> |
        <a href="/servicios">Servicios</a> |
        <a href="/citas">Citas</a>
        <a href="/trashed">Eliminados</a>
    </nav>
    <main div class= container-section>
        @yield('content')
    </main>
    <footer>
        <p>Derechos reservados 2024 Veterinaria </p>
    </footer>
</body>
</html>
