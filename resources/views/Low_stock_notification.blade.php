<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta de Stock Bajo</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .header p {
            margin: 10px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        .alert-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .alert-box strong {
            color: #856404;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .product-table th {
            background-color: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }
        .product-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        .product-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .stock-critical {
            color: #d32f2f;
            font-weight: bold;
        }
        .stock-low {
            color: #f57c00;
            font-weight: bold;
        }
        .cta-button {
            display: inline-block;
            background-color: #667eea;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
        }
        .cta-button:hover {
            background-color: #5568d3;
        }
        .footer {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .timestamp {
            background-color: #e3f2fd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 13px;
            color: #1976d2;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>⚠️ ALERTA DE STOCK BAJO</h1>
            <p>Grocery Store - Sistema de Inventario</p>
        </div>

        <div class="content">
            <div class="timestamp">
                📅 {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY - HH:mm:ss') }}
            </div>

            <p class="greeting">Hola <strong>{{ $adminName }}</strong>,</p>

            <div class="alert-box">
                <strong>⚠️ ATENCIÓN:</strong> Se han detectado <strong>{{ count($products) }}</strong> producto(s) con stock bajo o agotado.
            </div>

            <p style="color: #555; line-height: 1.6;">
                Los siguientes productos requieren tu atención inmediata para evitar desabastecimiento:
            </p>

            <table class="product-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Stock Actual</th>
                        <th>Stock Mínimo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <strong>{{ $product->name }}</strong>
                            <br>
                            <small style="color: #888;">{{ $product->category->name ?? 'Sin categoría' }}</small>
                        </td>
                        <td class="{{ $product->stock == 0 ? 'stock-critical' : 'stock-low' }}">
                            {{ $product->stock }} unidades
                        </td>
                        <td>{{ $product->min_stock }} unidades</td>
                        <td>
                            @if($product->stock == 0)
                                <span style="color: #d32f2f; font-weight: bold;">🔴 AGOTADO</span>
                            @else
                                <span style="color: #f57c00; font-weight: bold;">🟡 BAJO</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <center>
                <a href="{{ url('/products') }}" class="cta-button">
                    📦 Ver Inventario Completo
                </a>
            </center>

            <p style="margin-top: 30px; color: #666; font-size: 14px;">
                <strong>Recomendaciones:</strong>
            </p>
            <ul style="color: #666; font-size: 14px; line-height: 1.8;">
                <li>Contacta a los proveedores para realizar pedidos urgentes</li>
                <li>Verifica si hay productos similares disponibles</li>
                <li>Considera ajustar los niveles de stock mínimo si es necesario</li>
            </ul>
        </div>

        <div class="footer">
            <p>Este es un correo automático generado por el Sistema Grocery Store</p>
            <p>© {{ date('Y') }} Grocery Store. Todos los derechos reservados.</p>
            <p style="margin-top: 10px;">
                📧 {{ config('mail.from.address') }} | 📞 Contacto: +52 123 456 7890
            </p>
        </div>
    </div>
</body>
</html>