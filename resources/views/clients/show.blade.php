@extends('layouts.app')

@section('title', 'Detalles del Cliente')
@section('page-title', 'Detalles del Cliente')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <!-- Información del Cliente -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-user"></i> {{ $client->first_name }} {{ $client->last_name }}
                </h5>
                
                <div>
                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    
                    @if(auth()->user()->isAdmin())
                        <form action="{{ route('clients.destroy', $client->id) }}" 
                              method="POST" 
                              style="display:inline;"
                              onsubmit="return confirm('¿Eliminar este cliente?');">
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
                    <div class="col-md-6">
                        <h6 class="text-muted">INFORMACIÓN PERSONAL</h6>
                        <hr>
                        <p><strong>ID:</strong> #{{ $client->id }}</p>
                        <p><strong>Nombre Completo:</strong> {{ $client->first_name }} {{ $client->last_name }}</p>
                        <p><strong>Teléfono:</strong> {{ $client->phone }}</p>
                        <p><strong>Email:</strong> {{ $client->email ?? 'No registrado' }}</p>
                    </div>
                    
                    <div class="col-md-6">
                        <h6 class="text-muted">DIRECCIÓN</h6>
                        <hr>
                        <p><strong>Calle Principal:</strong> {{ $client->street_1 }}</p>
                        <p><strong>Calle Secundaria:</strong> {{ $client->street_2 ?? '-' }}</p>
                        <p><strong>Colonia:</strong> {{ $client->neighborhood }}</p>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">CRÉDITO</h6>
                        <hr>
                        <p><strong>Límite de Crédito:</strong> 
                            <span class="text-success">${{ number_format($client->credit_limit ?? 0, 2) }}</span>
                        </p>
                        <p><strong>Deuda Actual:</strong> 
                            @php
                                $debtPending = $client->debts()->whereIn('status', ['pending', 'overdue'])->sum('balance_due');
                            @endphp
                            <span class="{{ $debtPending > 0 ? 'text-danger' : 'text-success' }}">
                                ${{ number_format($debtPending, 2) }}
                            </span>
                        </p>
                        <p><strong>Crédito Disponible:</strong> 
                            <span class="text-info fw-bold">
                                ${{ number_format(($client->credit_limit ?? 0) - $debtPending, 2) }}
                            </span>
                        </p>
                    </div>
                    
                    <div class="col-md-6">
                        <h6 class="text-muted">ESTADÍSTICAS</h6>
                        <hr>
                        <p><strong>Total de Compras:</strong> {{ $client->sales->count() }}</p>
                        <p><strong>Monto Total Comprado:</strong> 
                            ${{ number_format($client->sales->sum('total_price'), 2) }}
                        </p>
                        <p><strong>Última Compra:</strong> 
                            {{ $client->sales->sortByDesc('created_at')->first()?->created_at->format('d/m/Y') ?? 'Nunca' }}
                        </p>
                    </div>
                </div>
                
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-calendar-plus"></i> Registrado: {{ $client->created_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt"></i> Actualizado: {{ $client->updated_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Historial de Compras -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-shopping-cart"></i> Historial de Compras (Últimas 10)
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($client->sales()->latest()->take(10)->get() as $sale)
                            <tr>
                                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $sale->product->name ?? 'N/A' }}</td>
                                <td>{{ $sale->quantity }}</td>
                                <td>${{ number_format($sale->total_price, 2) }}</td>
                                <td>
                                    @if($sale->payment_method === 'cash')
                                        <span class="badge bg-success">Efectivo</span>
                                    @elseif($sale->payment_method === 'card')
                                        <span class="badge bg-info">Tarjeta</span>
                                    @else
                                        <span class="badge bg-warning">Crédito</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-3 text-muted">
                                    No hay compras registradas
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Deudas Pendientes -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-credit-card"></i> Deudas Pendientes
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha Inicio</th>
                                <th>Fecha Vencimiento</th>
                                <th>Monto</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($client->debts()->whereIn('status', ['pending', 'overdue'])->get() as $debt)
                            <tr>
                                <td>{{ $debt->start_date->format('d/m/Y') }}</td>
                                <td>{{ $debt->due_date->format('d/m/Y') }}</td>
                                <td>${{ number_format($debt->balance_due, 2) }}</td>
                                <td>
                                    @if($debt->status === 'pending')
                                        <span class="badge bg-warning">Pendiente</span>
                                    @else
                                        <span class="badge bg-danger">Vencida</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-3 text-success">
                                    <i class="fas fa-check-circle"></i> Sin deudas pendientes
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="mt-3">
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Listado
            </a>
        </div>
    </div>
</div>
@endsection