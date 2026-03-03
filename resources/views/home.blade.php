<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Grocery Store</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800" rel="stylesheet">
    
    <style>
        :root {
            --primary-dark: #0f172a;
            --accent-color: #6366f1; /* Indigo */
            --highlight-color: #fbbf24; /* Amber para máxima visibilidad */
        }

        body {
            background-color: var(--primary-dark);
            font-family: 'Nunito', sans-serif;
            color: white;
            margin: 0;
        }

        /* Carrusel Fullscreen */
        .carousel-item {
            height: 100vh;
            min-height: 700px;
            background: no-repeat center center scroll;
            background-size: cover;
        }

        .carousel-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.7); /* Capa oscura para legibilidad */
            display: flex;
            align-items: center;
            z-index: 2;
        }

        /* Títulos y Animación */
        .hero-title {
            font-size: 5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        /* Subtítulo con color llamativo y animación de cursor */
        .typing-text {
            font-size: 1.8rem;
            color: var(--highlight-color); /* Color ámbar para que no se pierda */
            font-weight: 700;
            border-right: 3px solid var(--highlight-color);
            white-space: nowrap;
            overflow: hidden;
            display: inline-block;
            animation: typing 4s steps(50) infinite, blink 0.5s step-end infinite;
        }

        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }

        @keyframes blink {
            from, to { border-color: transparent }
            50% { border-color: var(--highlight-color) }
        }

        /* Video Container */
        .video-box {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.8);
            border: 2px solid rgba(255,255,255,0.1);
        }

        /* Botón Principal */
        .btn-main {
            background: var(--accent-color);
            color: white;
            padding: 18px 50px;
            border-radius: 15px;
            font-weight: 800;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            border: none;
            margin-top: 2rem;
        }

        .btn-main:hover {
            background: #4f46e5;
            transform: translateY(-5px);
            color: white;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.5);
        }

        /* Sección de Características (Abajo del carrusel) */
        .features-section {
            padding: 100px 0;
            background: #1e293b;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 40px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: 0.3s;
            height: 100%;
        }

        .feature-card:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-10px);
        }

        .feature-card i {
            font-size: 3rem;
            color: var(--accent-color);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div id="homeCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="10000" style="background-image: url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1920')"></div>
            <div class="carousel-item" data-bs-interval="10000" style="background-image: url('https://images.unsplash.com/photo-1578916171728-46686eac8d58?q=80&w=1920')"></div>
            <div class="carousel-item" data-bs-interval="10000" style="background-image: url('https://images.unsplash.com/photo-1534723452862-4c874018d66d?q=80&w=1920')"></div>
        </div>

        <div class="carousel-overlay">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 text-center text-lg-start">
                        <h1 class="hero-title">GROCERY <span style="color: var(--accent-color)">STORE</span></h1>
                        
                        <div class="typing-container">
                            <span class="typing-text">Gestión de inventarios y .</span>
                        </div>
                        
                        <div class="mt-4">
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn btn-main shadow">
                                    <i class="fas fa-th-large me-2"></i> IR AL DASHBOARD
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-main shadow">
                                    <i class="fas fa-sign-in-alt me-2"></i> INICIAR SESIÓN
                                </a>
                            @endauth
                        </div>
                    </div>

                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="video-box">
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/watch?v=mfJhMfOPWdE&list=RDgb1uXeEkusE&index=7" title="Video" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="features-section">
        <div class="container text-center">
            <h2 class="fw-bold mb-5 display-5">¿Qué ofrecemos?</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="feature-card">
                        <i class="fas fa-boxes"></i>
                        <h4>Inventario</h4>
                        <p class="text-white-50 small">Control total de stock y ajustes automatizados.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <i class="fas fa-cash-register"></i>
                        <h4>Ventas</h4>
                        <p class="text-white-50 small">Registro rápido de transacciones y cálculo de totales.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <i class="fas fa-users-cog"></i>
                        <h4>Recursos Humanos</h4>
                        <p class="text-white-50 small">Gestión de empleados, roles y acceso seguro.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <h4>Finanzas</h4>
                        <p class="text-white-50 small">Administración de deudas de proveedores y clientes.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>