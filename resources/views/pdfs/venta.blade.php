<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Venta #{{ $sale->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #667eea;
        }
        
        .header h1 {
            color: #667eea;
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .header h2 {
            color: #666;
            font-size: 18px;
            font-weight: normal;
        }
        
        .header .folio {
            background: #667eea;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
            font-size: 16px;
            font-weight: bold;
        }
        
        .info-section {
            margin-bottom: 25px;
        }
        
        .info-section h3 {
            color: #667eea;
            font-size: 14px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f5f5f5;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .label {
            font-weight: bold;
            color: #555;
        }
        
        .value {
            color: #333;
            text-align: right;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
        }
        
        th {
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        
        tbody tr {
            border-bottom: 1px solid #e0e0e0;
        }
        
        tbody tr:last-child {
            border-bottom: none;
        }
        
        tbody td {
            font-size: 12px;
        }
        
        .total-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 3px solid #667eea;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
        }
        
        .total-label {
            font-size: 18px;
            font-weight: bold;
            color: #555;
        }
        
        .total-amount {
            font-size: 28px;
            font-weight: bold;
            color: #667eea;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
            color: #999;
            font-size: 11px;
        }
        
        .footer p {
            margin: 5px 0;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        
        .badge-warning {
            background-color: #ffc107;
            color: #333;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>🛒 TIENDA DE ABARROTES</h1>
        <h2>Ticket de Venta</h2>
        <div class="folio">FOLIO: #{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</div>
    </div>

    <!-- Información General -->
    <div class="info-section">
        <h3>📋 Información General</h3>
        
        <div class="info-row">
            <span class="label">Fecha:</span>
            <span class="value">{{ $sale->created_at->format('d/m/Y H:i:s') }}</span>
        </div>

        <div class="info-row">
            <span class="label">Empleado:</span>
            <span class="value">
                {{ $sale->employee->first_name }} {{ $sale->employee->last_name }}
            </span>
        </div>

        <div class="info-row">
            <span class="label">ID Nómina:</span>
            <span class="value">{{ $sale->employee->payroll_id }}</span>
        </div>

        @if($sale->client)
        <div class="info-row">
            <span class="label">Cliente:</span>
            <span class="value">
                {{ $sale->client->first_name }} {{ $sale->client->last_name }}
            </span>
        </div>
        @endif

        <div class="info-row">
            <span class="label">Método de Pago:</span>
            <span class="value">
                @if($sale->payment_method === 'cash')
                    <span class="badge badge-success">EFECTIVO</span>
                @elseif($sale->payment_method === 'card')
                    <span class="badge badge-success">TARJETA</span>
                @else
                    <span class="badge badge-warning">CRÉDITO</span>
                @endif
            </span>
        </div>
    </div>

    <!-- Detalle del Producto -->
    <div class="info-section">
        <h3>🛍️ Detalle de Productos</h3>
        
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th style="text-align: center;">Cantidad</th>
                    <th style="text-align: right;">Precio Unit.</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>{{ $sale->product->name }}</strong></td>
                    <td>{{ $sale->product->description ?? '-' }}</td>
                    <td style="text-align: center;">{{ $sale->quantity }}</td>
                    <td style="text-align: right;">${{ number_format($sale->product->price, 2) }}</td>
                    <td style="text-align: right;"><strong>${{ number_format($sale->total_price, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Total -->
    <div class="total-section">
        <div class="total-row">
            <span class="total-label">TOTAL A PAGAR:</span>
            <span class="total-amount">${{ number_format($sale->total_price, 2) }} MXN</span>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>¡Gracias por su compra!</strong></p>
        <p>Este documento fue generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Sistema de Gestión - Tienda de Abarrotes</p>
    </div>
</body>
</html>