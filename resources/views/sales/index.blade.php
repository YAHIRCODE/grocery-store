@extends('layouts.app')

@section('title', 'Ventas')
@section('page-title', 'Gestión de Ventas')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-shopping-cart"></i> Lista de Ventas
        </h5>
        
        <div>
            <a href="{{ route('sales.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Venta
            </a>
            <a href="{{ route('pdf.ventas.diarias') }}" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> Reporte del Día
            </a>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Cliente</th>
                        <th>Empleado</th>
                        <th>Pago</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td><strong>#{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                        <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $sale->product->name ?? 'N/A' }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td><strong>${{ number_format($sale->total_price, 2) }}</strong></td>
                        <td>
                            @if($sale->client)
                                {{ $sale->client->first_name }} {{ $sale->client->last_name }}
                            @else
                                <span class="text-muted">Cliente general</span>
                            @endif
                        </td>
                        <td>
                            <small>{{ $sale->employee->first_name ?? 'N/A' }}</small>
                        </td>
                        <td>
                            @if($sale->payment_method === 'cash')
                                <span class="badge bg-success">Efectivo</span>
                            @elseif($sale->payment_method === 'card')
                                <span class="badge bg-info">Tarjeta</span>
                            @else
                                <span class="badge bg-warning">Crédito</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('sales.show', $sale->id) }}" 
                                   class="btn btn-sm btn-info" 
                                   title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <a href="{{ route('pdf.venta', $sale->id) }}" 
                                   class="btn btn-sm btn-danger" 
                                   target="_blank"
                                   title="PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('sales.edit', $sale->id) }}" 
                                       class="btn btn-sm btn-warning" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('sales.destroy', $sale->id) }}" 
                                          method="POST" 
                                          style="display:inline;"
                                          onsubmit="return confirm('¿Eliminar esta venta?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            <p>No hay ventas registradas</p>
                            <a href="{{ route('sales.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Registrar Primera Venta
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Resumen del día -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6>Ventas de Hoy</h6>
                <h2>{{ $sales->filter(fn($s) => $s->created_at->isToday())->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6>Total del Día</h6>
                <h2>${{ number_format($sales->filter(fn($s) => $s->created_at->isToday())->sum('total_price'), 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h6>Total del Mes</h6>
                <h2>${{ number_format($sales->filter(fn($s) => $s->created_at->isCurrentMonth())->sum('total_price'), 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-secondary">
            <div class="card-body">
                <h6>Total Acumulado</h6>
                <h2>${{ number_format($sales->sum('total_price'), 2) }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection