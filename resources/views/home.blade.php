</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Tienda de Abarrotes</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
        }
        
        .hero-content h1 {
            font-size: 4rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .hero-content p {
            font-size: 1.5rem;
            margin-bottom: 40px;
            opacity: 0.9;
        }
        
        .hero-buttons .btn {
            padding: 15px 40px;
            font-size: 1.1rem;
            border-radius: 50px;
            font-weight: 600;
            margin: 10px;
            transition: transform 0.3s;
        }
        
        .hero-buttons .btn:hover {
            transform: translateY(-5px);
        }
        
        .btn-light {
            background: white;
            color: #667eea;
        }
        
        .btn-outline-light {
            border: 2px solid white;
            color: white;
        }
        
        .btn-outline-light:hover {
            background: white;
            color: #667eea;
        }
        
        .features {
            margin-top: 80px;
        }
        
        .feature-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            margin: 15px;
            transition: transform 0.3s;
        }
        
        .feature-box:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .feature-box i {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        
        .feature-box h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="mb-4">
                    <i class="fas fa-shopping-cart" style="font-size: 6rem;"></i>
                </div>
                <h1>🛒 Tienda de Abarrotes</h1>
                <p>Sistema de Gestión Integral para tu Negocio</p>
                
                <div class="hero-buttons">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-home me-2"></i>
                            Ir al Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Iniciar Sesión
                        </a>
                        
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-user-plus me-2"></i>
                                Registrarse
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
            
            <!-- Características -->
            <div class="features">
                <div class="row">
                    <div class="col-md-3">
                        <div class="feature-box">
                            <i class="fas fa-boxes"></i>
                            <h3>Inventario</h3>
                            <p>Control total de tu stock en tiempo real</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-box">
                            <i class="fas fa-cash-register"></i>
                            <h3>Ventas</h3>
                            <p>Registro rápido y eficiente de transacciones</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-box">
                            <i class="fas fa-users"></i>
                            <h3>Clientes</h3>
                            <p>Gestión de clientes y créditos</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-box">
                            <i class="fas fa-chart-line"></i>
                            <h3>Reportes</h3>
                            <p>Análisis y reportes detallados</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>