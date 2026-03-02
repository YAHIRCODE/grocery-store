@extends('layouts.app')

@section('title', 'Detalles del Producto')
@section('page-title', 'Detalles del Producto')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <!-- Información del Producto -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-box"></i> {{ $product->name }}
                </h5>
                
                <div>
                    @if(auth()->user()->isAdmin() || auth()->user()->isWarehouseWorker())
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    @endif
                    
                    @if(auth()->user()->isAdmin())
                        <form action="{{ route('products.destroy', $product->id) }}" 
                              method="POST" 
                              style="display:inline;"
                              onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Columna Izquierda -->
                    <div class="col-md-6">
                        <h6 class="text-muted">INFORMACIÓN BÁSICA</h6>
                        <hr>
                        
                        <p><strong>ID:</strong> #{{ $product->id }}</p>
                        <p><strong>Nombre:</strong> {{ $product->name }}</p>
                        <p><strong>Código de Barras:</strong> {{ $product->barcode ?? 'No asignado' }}</p>
                        <p><strong>Categoría:</strong> 
                            <span class="badge bg-secondary">{{ $product->category->name ?? 'Sin categoría' }}</span>
                        </p>
                        <p><strong>Proveedor:</strong> {{ $product->supplier->company_name ?? 'Sin proveedor' }}</p>
                        
                        @if($product->description)
                            <p><strong>Descripción:</strong></p>
                            <p class="text-muted">{{ $product->description }}</p>
                        @endif
                    </div>
                    
                    <!-- Columna Derecha -->
                    <div class="col-md-6">
                        <h6 class="text-muted">PRECIOS E INVENTARIO</h6>
                        <hr>
                        
                        <p><strong>Precio de Compra:</strong> 
                            ${{ number_format($product->purchase_price ?? 0, 2) }}
                        </p>
                        <p><strong>Precio de Venta:</strong> 
                            <span class="text-success fw-bold">${{ number_format($product->price, 2) }}</span>
                        </p>
                        
                        @if($product->purchase_price)
                        <p><strong>Margen de Ganancia:</strong>
                            @php
                                $margin = (($product->price - $product->purchase_price) / $product->purchase_price) * 100;
                            @endphp
                            <span class="badge bg-info">{{ number_format($margin, 1) }}%</span>
                        </p>
                        @endif
                        
                        <hr>
                        
                        <p><strong>Stock Actual:</strong> 
                            <span class="badge {{ $product->stock <= $product->min_stock ? 'bg-danger' : 'bg-success' }}" style="font-size: 16px;">
                                {{ $product->stock }} unidades
                            </span>
                        </p>
                        <p><strong>Stock Mínimo:</strong> {{ $product->min_stock }} unidades</p>
                        
                        @if($product->stock <= $product->min_stock)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Alerta:</strong> El stock está por debajo del mínimo
                            </div>
                        @endif
                        
                        <p><strong>Valor en Inventario:</strong> 
                            <span class="fw-bold">${{ number_format($product->stock * $product->price, 2) }}</span>
                        </p>
                    </div>
                </div>
                
                <!-- Fechas -->
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-calendar-plus"></i> Creado: {{ $product->created_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt"></i> Actualizado: {{ $product->updated_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Historial de Ventas -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history"></i> Historial de Ventas (Últimas 10)
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Empleado</th>
                                <th>Cliente</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($product->sales()->latest()->take(10)->get() as $sale)
                            <tr>
                                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $sale->quantity }}</td>
                                <td>${{ number_format($sale->total_price, 2) }}</td>
                                <td>{{ $sale->employee->first_name ?? 'N/A' }}</td>
                                <td>{{ $sale->client ? $sale->client->first_name : '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-3 text-muted">
                                    No hay ventas registradas para este producto
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Botón Volver -->
        <div class="mt-3">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Listado
            </a>
        </div>
    </div>
</div>
@endsection