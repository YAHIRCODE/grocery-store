@extends('layouts.app')

@section('title', 'Detalles de Venta')
@section('page-title', 'Detalles de Venta')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <!-- Ticket de Venta -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-receipt"></i> Ticket de Venta #{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
                </h5>
                
                <div>
                    <a href="{{ route('pdf.venta', $sale->id) }}" 
                       class="btn btn-danger" 
                       target="_blank">
                        <i class="fas fa-file-pdf"></i> Descargar PDF
                    </a>
                    
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <!-- Información General -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted">INFORMACIÓN DE LA VENTA</h6>
                        <hr>
                        <p><strong>Folio:</strong> #{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</p>
                        <p><strong>Fecha:</strong> {{ $sale->created_at->format('d/m/Y H:i:s') }}</p>
                        <p><strong>Empleado:</strong> {{ $sale->employee->first_name }} {{ $sale->employee->last_name }}</p>
                        <p><strong>ID Nómina:</strong> {{ $sale->employee->payroll_id }}</p>
                    </div>
                    
                    <div class="col-md-6">
                        <h6 class="text-muted">INFORMACIÓN DEL CLIENTE</h6>
                        <hr>
                        @if($sale->client)
                            <p><strong>Cliente:</strong> {{ $sale->client->first_name }} {{ $sale->client->last_name }}</p>
                            <p><strong>Teléfono:</strong> {{ $sale->client->phone }}</p>
                            <p><strong>Email:</strong> {{ $sale->client->email ?? 'No registrado' }}</p>
                        @else
                            <p class="text-muted">Cliente general (sin registro)</p>
                        @endif
                    </div>
                </div>
                
                <!-- Detalle del Producto -->
                <h6 class="text-muted">DETALLE DE PRODUCTOS</h6>
                <hr>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th>Descripción</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Precio Unit.</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>{{ $sale->product->name }}</strong></td>
                            <td>{{ $sale->product->description ?? '-' }}</td>
                            <td class="text-center">{{ $sale->quantity }}</td>
                            <td class="text-end">${{ number_format($sale->product->price, 2) }}</td>
                            <td class="text-end"><strong>${{ number_format($sale->total_price, 2) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
                
                <!-- Total -->
                <div class="row mt-4">
                    <div class="col-md-6 offset-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <strong>${{ number_format($sale->total_price, 2) }}</strong>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <h5>TOTAL:</h5>
                                    <h5 class="text-primary">${{ number_format($sale->total_price, 2) }} MXN</h5>
                                </div>
                                <div class="mt-2">
                                    <small>Método de pago: 
                                        @if($sale->payment_method === 'cash')
                                            <span class="badge bg-success">Efectivo</span>
                                        @elseif($sale->payment_method === 'card')
                                            <span class="badge bg-info">Tarjeta</span>
                                        @else
                                            <span class="badge bg-warning">Crédito</span>
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Fechas -->
                <hr class="mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-calendar-plus"></i> Registrado: {{ $sale->created_at->format('d/m/Y H:i:s') }}
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt"></i> Actualizado: {{ $sale->updated_at->format('d/m/Y H:i:s') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Botones de Acción -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Listado
            </a>
            
            @if(auth()->user()->isAdmin())
                <form action="{{ route('sales.destroy', $sale->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('¿Estás seguro de eliminar esta venta?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Eliminar Venta
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection