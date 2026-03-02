@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4">
    <!-- Tarjeta: Ventas de Hoy -->
    <div class="col-md-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="opacity: 0.8;">Ventas Hoy</h6>
                        <h2 class="mb-0">${{ number_format($ventasHoyTotal, 2) }}</h2>
                        <small>{{ $ventasHoy }} transacciones</small>
                    </div>
                    <div>
                        <i class="fas fa-shopping-cart fa-3x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tarjeta: Productos con Bajo Stock -->
    <div class="col-md-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="opacity: 0.8;">Stock Bajo</h6>
                        <h2 class="mb-0">{{ $productosConBajoStock }}</h2>
                        <small>productos</small>
                    </div>
                    <div>
                        <i class="fas fa-exclamation-triangle fa-3x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tarjeta: Deudas Pendientes -->
    <div class="col-md-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="opacity: 0.8;">Deudas Pendientes</h6>
                        <h2 class="mb-0">${{ number_format($deudasPendientes, 2) }}</h2>
                        <small>por cobrar</small>
                    </div>
                    <div>
                        <i class="fas fa-credit-card fa-3x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tarjeta: Clientes Activos -->
    <div class="col-md-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="opacity: 0.8;">Clientes</h6>
                        <h2 class="mb-0">{{ $clientesActivos }}</h2>
                        <small>registrados</small>
                    </div>
                    <div>
                        <i class="fas fa-users fa-3x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Últimas Ventas -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-history"></i> Últimas Ventas
                </h5>
                <a href="{{ route('sales.index') }}" class="btn btn-sm btn-primary">
                    Ver Todas
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Producto</th>
                                <th>Cliente</th>
                                <th>Empleado</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimasVentas as $sale)
                            <tr>
                                <td>
                                    <strong>#{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                </td>
                                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $sale->product->name }}</td>
                                <td>
                                    @if($sale->client)
                                        {{ $sale->client->first_name }} {{ $sale->client->last_name }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $sale->employee->first_name }} {{ $sale->employee->last_name }}</td>
                                <td>{{ $sale->quantity }}</td>
                                <td>
                                    <strong>${{ number_format($sale->total_price, 2) }}</strong>
                                </td>
                                <td>
                                    <a href="{{ route('pdf.venta', $sale->id) }}" 
                                       class="btn btn-sm btn-danger" 
                                       target="_blank" 
                                       title="Descargar PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                    <p>No hay ventas registradas hoy</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Accesos Rápidos -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt"></i> Accesos Rápidos
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @if(auth()->user()->isCashier() || auth()->user()->isAdmin())
                    <div class="col-md-3">
                        <a href="{{ route('sales.create') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="fas fa-plus-circle fa-2x d-block mb-2"></i>
                            Nueva Venta
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('clients.create') }}" class="btn btn-outline-success w-100 py-3">
                            <i class="fas fa-user-plus fa-2x d-block mb-2"></i>
                            Nuevo Cliente
                        </a>
                    </div>
                    @endif
                    
                    @if(auth()->user()->isWarehouseWorker() || auth()->user()->isAdmin())
                    <div class="col-md-3">
                        <a href="{{ route('products.create') }}" class="btn btn-outline-info w-100 py-3">
                            <i class="fas fa-box fa-2x d-block mb-2"></i>
                            Nuevo Producto
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('inventory_adjustments.create') }}" class="btn btn-outline-warning w-100 py-3">
                            <i class="fas fa-clipboard-list fa-2x d-block mb-2"></i>
                            Ajustar Inventario
                        </a>
                    </div>
                    @endif
                    
                    <div class="col-md-3">
                        <a href="{{ route('pdf.ventas.diarias') }}" class="btn btn-outline-danger w-100 py-3" target="_blank">
                            <i class="fas fa-file-pdf fa-2x d-block mb-2"></i>
                            Reporte del Día
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('pdf.inventario') }}" class="btn btn-outline-secondary w-100 py-3" target="_blank">
                            <i class="fas fa-warehouse fa-2x d-block mb-2"></i>
                            Reporte Inventario
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection