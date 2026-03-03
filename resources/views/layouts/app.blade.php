<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
<head>
    <style>
    body { overflow-x: hidden; }
    #sidebar-wrapper {
        min-height: 100vh;
        margin-left: -15rem;
        transition: margin .25s ease-out;
        background: #212529; /* Color oscuro profesional */
    }
    #sidebar-wrapper .sidebar-heading { padding: 0.875rem 1.25rem; font-size: 1.2rem; color: white; }
    #sidebar-wrapper .list-group { width: 15rem; }
    #page-content-wrapper { min-width: 100vw; }
    #wrapper.toggled #sidebar-wrapper { margin-left: 0; }
    .nav-link-custom { color: rgba(255,255,255,.75); padding: 10px 20px; text-decoration: none; display: block; }
    .nav-link-custom:hover { background: #343a40; color: white; }
    .nav-link-custom i { width: 25px; }
    
    @media (min-width: 768px) {
        #sidebar-wrapper { margin-left: 0; }
        #page-content-wrapper { min-width: 0; width: 100%; }
        #wrapper.toggled #sidebar-wrapper { margin-left: -15rem; }
    }
</style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
<div class="d-flex" id="wrapper">
    @auth
    <div id="sidebar-wrapper" class="border-end">
        <div class="sidebar-heading border-bottom bg-dark">
            <i class="fas fa-store me-2"></i> Mi Tiendita
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('dashboard') }}" class="nav-link-custom border-bottom">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>

            @if(Auth::user()->canManageInventory())
                <div class="p-2 text-muted small fw-bold">INVENTARIO</div>
                <a href="{{ route('categories.index') }}" class="nav-link-custom"><i class="fas fa-tags"></i> Categorías</a>
                <a href="{{ route('products.index') }}" class="nav-link-custom"><i class="fas fa-box"></i> Productos</a>
                <a href="{{ route('inventory_adjustments.index') }}" class="nav-link-custom"><i class="fas fa-adjust"></i> Ajustes</a>
            @endif

            @if(Auth::user()->canManageSales())
                <div class="p-2 text-muted small fw-bold">OPERACIONES</div>
                <a href="{{ route('sales.index') }}" class="nav-link-custom"><i class="fas fa-shopping-cart"></i> Ventas</a>
                <a href="{{ route('clients.index') }}" class="nav-link-custom"><i class="fas fa-users"></i> Clientes</a>
                <a href="{{ route('client_debts.index') }}" class="nav-link-custom"><i class="fas fa-hand-holding-usd"></i> Deudas Clientes</a>
            @endif

            @if(Auth::user()->isAdmin())
                <div class="p-2 text-muted small fw-bold">ADMINISTRACIÓN</div>
                <a href="{{ route('employees.index') }}" class="nav-link-custom"><i class="fas fa-user-tie"></i> Empleados</a>
                <a href="{{ route('suppliers.index') }}" class="nav-link-custom"><i class="fas fa-truck"></i> Proveedores</a>
                <a href="{{ route('supplier_debts.index') }}" class="nav-link-custom"><i class="fas fa-file-invoice-dollar"></i> Deudas Proveedores</a>
            @endif
        </div>
    </div>
    @endauth

    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
            <div class="container-fluid">
                @auth
                    <button class="btn btn-dark" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                @endauth
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        @guest
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Entrar</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                    {{ Auth::user()->getEmployeeFullName() }} 
                                    <span class="badge bg-primary ms-1">{{ Auth::user()->getRole() }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Salir</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container-fluid py-4">
            @yield('content')
        </main>
    </div>
</div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script>
    window.addEventListener('DOMContentLoaded', event => {
        const sidebarToggle = document.body.querySelector('#sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', event => {
                event.preventDefault();
                document.body.querySelector('#wrapper').classList.toggle('toggled');
            });
        }
    });
</script>
<script src="https://kit.fontawesome.com/your-code.js" crossorigin="anonymous"></script>
</body>
</html>

