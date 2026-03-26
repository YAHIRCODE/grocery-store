<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Grocery Store') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --sidebar-active: #6366f1;
            --accent-color: #818cf8;
        }

        body { 
            overflow-x: hidden; 
            font-family: 'Nunito', sans-serif;
            background-color: #f8fafc;
        }

        #wrapper { display: flex; width: 100%; }

        /* Sidebar Styling */
        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -16rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--sidebar-bg);
            z-index: 1000;
            width: 16rem;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        #sidebar-wrapper .sidebar-heading { 
            padding: 1.5rem 1.25rem; 
            font-size: 1.25rem; 
            color: #fff; 
            background: rgba(0,0,0,0.2);
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        #page-content-wrapper { 
            width: 100%; 
            min-width: 0; 
            background: #f8fafc; 
        }

        #wrapper.toggled #sidebar-wrapper { margin-left: 0; }

        /* Navigation Links */
        .nav-link-custom { 
            color: rgba(255,255,255,.7); 
            padding: 0.9rem 1.5rem; 
            text-decoration: none; 
            display: flex;
            align-items: center;
            transition: all 0.2s;
            border-left: 4px solid transparent;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .nav-link-custom:hover { 
            background: var(--sidebar-hover); 
            color: #fff; 
            border-left: 4px solid var(--accent-color);
        }

        .nav-link-custom.active {
            background: rgba(99, 102, 241, 0.15);
            color: var(--accent-color);
            border-left: 4px solid var(--sidebar-active);
        }

        .nav-link-custom i { 
            width: 25px; 
            margin-right: 12px; 
            font-size: 1.1rem;
            opacity: 0.8;
        }

        .menu-section { 
            padding: 1.5rem 1.5rem 0.5rem; 
            font-size: 0.7rem; 
            color: #94a3b8; 
            font-weight: 800; 
            text-transform: uppercase; 
            letter-spacing: 1.2px;
        }

        /* Navbar Styling */
        .navbar {
            padding: 0.8rem 1rem;
            border-bottom: 1px solid #e2e8f0 !important;
        }

        #sidebarToggle {
            border: none;
            background: #f1f5f9;
            color: #475569;
            padding: 0.5rem 0.8rem;
            border-radius: 8px;
            transition: 0.2s;
        }

        #sidebarToggle:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        @media (min-width: 768px) {
            #sidebar-wrapper { margin-left: 0; }
            #wrapper.toggled #sidebar-wrapper { margin-left: -16rem; }
        }

        /* Profile Badge */
        .user-badge {
            background: #eef2ff;
            color: #4f46e5;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div id="wrapper">
        @auth
        <div id="sidebar-wrapper">
            <div class="sidebar-heading">
                <i class="fas fa-shopping-basket text-accent me-2"></i> GROCERY <span style="color: var(--accent-color)">STORE</span>
            </div>
            
            <div class="list-group list-group-flush mt-2">
                <a href="{{ route('dashboard') }}" class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>

                @if(Auth::user()->canManageInventory())
                    <div class="menu-section">Inventario</div>
                    <a href="{{ route('categories.index') }}" class="nav-link-custom {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i> Categorías
                    </a>
                    <a href="{{ route('products.index') }}" class="nav-link-custom {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i> Productos
                    </a>
                    <a href="{{ route('inventory_adjustments.index') }}" class="nav-link-custom {{ request()->routeIs('inventory_adjustments.*') ? 'active' : '' }}">
                        <i class="fas fa-adjust"></i> Mermas del Producto
                    </a>
                @endif

                @if(Auth::user()->canManageSales())
                    <div class="menu-section">Operaciones</div>
                    <a href="{{ route('sales.create') }}" class="nav-link-custom {{ request()->routeIs('sales.create') ? 'active' : '' }}">
                        <i class="fas fa-cart-plus"></i> Punto de Venta
                    </a>
                    <a href="{{ route('sales.index') }}" class="nav-link-custom {{ request()->routeIs('sales.index') ? 'active' : '' }}">
                        <i class="fas fa-history"></i> Historial Ventas
                    </a>
                    <a href="{{ route('clients.index') }}" class="nav-link-custom {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Mis Clientes
                    </a>
                    <a href="{{ route('client_debts.index') }}" class="nav-link-custom {{ request()->routeIs('client_debts.*') ? 'active' : '' }}">
                        <i class="fas fa-hand-holding-dollar"></i> Cobros Clientes
                    </a>
                @endif
                

                @if(Auth::user()->isAdmin())
                    <div class="menu-section">Administración</div>
                    <a href="{{ route('employees.index') }}" class="nav-link-custom {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                        <i class="fas fa-user-shield"></i> Equipo / Empleados
                    </a>
                    <a href="{{ route('suppliers.index') }}" class="nav-link-custom {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                        <i class="fas fa-truck-ramp-box"></i> Proveedores
                    </a>
                    <a href="{{ route('supplier_debts.index') }}" class="nav-link-custom {{ request()->routeIs('supplier_debts.*') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice-dollar"></i> Deudas Proveedores
                    </a>
                    <div class="menu-section">Sitio Web</div>
                    <a href="{{ route('media.index') }}" class="nav-link-custom {{ request()->routeIs('media.*') ? 'active' : '' }}">
                        <i class="fas fa-photo-video"></i> Multimedia / Banner
                    </a>
                    <a href="{{ route('stock.low-stock') }}" class="nav-link-custom {{ request()->routeIs('stock.low-stock') ? 'active' : '' }}">
                        <i class="fas fa-exclamation-triangle"></i> Notificaciones de Stock
                    </a>
                @endif
                
            </div>
        </div>
        @endauth

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    @auth
                    <button id="sidebarToggle">
                        <i class="fas fa-align-left"></i>
                    </button>
                    @endauth

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            @guest
                                @if (Route::has('login')) <li class="nav-item"><a class="nav-link fw-bold" href="{{ route('login') }}">Ingresar</a></li> @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                        <div class="text-end me-3 d-none d-sm-block">
                                            <div class="fw-bold small text-dark" style="line-height: 1">{{ Auth::user()->getEmployeeFullName() }}</div>
                                            <span class="text-muted" style="font-size: 0.7rem;">{{ Auth::user()->getRole() }}</span>
                                        </div>
                                        <i class="fas fa-user-circle fs-3 text-primary"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg" aria-labelledby="navbarDropdown">
                                        <div class="px-4 py-2 border-bottom mb-2">
                                            <span class="small text-muted d-block">Sesión activa</span>
                                            <span class="fw-bold">{{ Auth::user()->email }}</span>
                                        </div>
                                        <a class="dropdown-item text-danger fw-bold" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-power-off me-2"></i> Cerrar Sesión
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4 px-4">
                @yield('content')
            </main>
        </div>
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
</body>
</html>