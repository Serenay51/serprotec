<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SERPROTEC</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('sweetalert::alert')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    

    <!-- Canvas Confetti for achievements -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>



    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background-color: #F4F6F8; }
        .sidebar {
            width: 250px;
            background-color: #2A8D6C;
            min-height: 100vh;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
        }
        .sidebar a:hover {
            background-color: #1F6A52;
        }
        .content { margin-left: 250px; padding: 20px; }
        footer { text-align: center; padding: 10px; color: #888; }
    </style>
</head>
<body>
    @auth
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar position-fixed">
            <a class="mt-5" href="{{ route('dashboard') }}"><i class="fa fa-home"></i>  Home</a>
            <a href="{{ route('products.index') }}"><i class="fa fa-box"></i>  Productos</a>
            <a href="{{ route('clients.index') }}"><i class="fa fa-users"></i>  Clientes</a>
            <a href="{{ route('providers.index') }}"><i class="fa fa-truck"></i>  Proveedores</a>
            <a href="{{ route('quotations.index') }}"><i class="fa fa-file-invoice"></i>  Presupuestos</a>
            <a href="{{ route('sales.index') }}"><i class="fa fa-shopping-cart"></i>  Ventas</a>
            <a href="{{ route('costs.index') }}"><i class="fa fa-tags"></i>  Listas de Precios</a>
        </div>

        <!-- Contenido -->
        <div class="content w-100">
            <!-- Navbar superior -->
            <nav class="navbar navbar-light bg-white shadow-sm mb-4">
                <div class="container-fluid d-flex justify-content-between">
                    <img src="/images/logo.png" alt="Logo" width="120">
                    <div>
                        <span class="me-3"><i class="fa fa-user-circle"></i> {{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-sign-out-alt"></i> Cerrar sesión</button>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- Contenido dinámico -->
            <main>
                @yield('content')
            </main>

            <!-- Footer -->
            <hr class="my-4">
            <footer class="mt-4 bg-light">
                &copy; {{ date('Y') }} SERPROTEC - Todos los derechos reservados
                <img src="/images/logo.png" alt="Logo" width="100" class="d-block mx-auto mt-2">
                <div class="mt-2">
                    <span>Desarrollado por: <strong>Lautaro Arana</strong></span>
                </div>
                <div class="mt-2" style="font-size: 0.9em;">
                    <a href="#">Política de Privacidad</a>
                    <a href="#">Términos de Servicio</a>
                    <a href="#">Contacto</a>
                </div>
            </footer>
        </div>
    </div>
    @endauth

    @guest
    <!-- Si NO está logueado, solo mostramos el contenido de login/register -->
    <main class="container mt-5">
        @yield('content')
    </main>
    @endguest

     @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
