@extends('layouts.app')

@section('title', 'Clientes')
@section('page-title', 'Gestión de Clientes')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-users"></i> Lista de Clientes
        </h5>
        
        <div>
            <a href="{{ route('clients.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Nuevo Cliente
            </a>
            <a href="{{ route('pdf.deudas.clientes') }}" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> Reporte PDF
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Búsqueda -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           id="searchClient" 
                           placeholder="Buscar por nombre, teléfono o email...">
                </div>
            </div>
            <div class="col-md-6 text-end">
                <span class="badge bg-info" style="font-size: 14px;">
                    Total: {{ $clients->count() }} clientes
                </span>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover" id="clientsTable">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Límite Crédito</th>
                        <th>Deuda Actual</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                    <tr>
                        <td><strong>#{{ $client->id }}</strong></td>
                        <td>
                            <strong>{{ $client->first_name }} {{ $client->last_name }}</strong>
                        </td>
                        <td>
                            <i class="fas fa-phone text-success"></i>
                            {{ $client->phone }}
                        </td>
                        <td>
                            @if($client->email)
                                <i class="fas fa-envelope text-primary"></i>
                                {{ $client->email }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <small>
                                {{ $client->street_1 }}, {{ $client->neighborhood }}
                            </small>
                        </td>
                        <td>
                            <span class="text-success">
                                ${{ number_format($client->credit_limit ?? 0, 2) }}
                            </span>
                        </td>
                        <td>
                            @php
                                $debtPending = $client->debts()
                                    ->whereIn('status', ['pending', 'overdue'])
                                    ->sum('balance_due');
                            @endphp
                            @if($debtPending > 0)
                                <span class="badge bg-warning text-dark">
                                    ${{ number_format($debtPending, 2) }}
                                </span>
                            @else
                                <span class="badge bg-success">$0.00</span>
                            @endif
                        </td>
                        <td>
                            @if($debtPending > 0)
                                @if($client->debts()->where('status', 'overdue')->count() > 0)
                                    <span class="badge bg-danger">
                                        <i class="fas fa-exclamation-triangle"></i> Vencida
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock"></i> Pendiente
                                    </span>
                                @endif
                            @else
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle"></i> Al corriente
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('clients.show', $client->id) }}" 
                                   class="btn btn-sm btn-info" 
                                   title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <a href="{{ route('clients.edit', $client->id) }}" 
                                   class="btn btn-sm btn-warning" 
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                @if(auth()->user()->isAdmin())
                                    <form action="{{ route('clients.destroy', $client->id) }}" 
                                          method="POST" 
                                          style="display:inline;"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este cliente?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                title="Eliminar">
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
                            <i class="fas fa-users fa-3x mb-3 d-block"></i>
                            <p>No hay clientes registrados</p>
                            <a href="{{ route('clients.create') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Registrar Primer Cliente
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tarjetas de Resumen -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Clientes</h6>
                        <h2 class="mb-0">{{ $clients->count() }}</h2>
                    </div>
                    <div>
                        <i class="fas fa-users fa-3x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Sin Deudas</h6>
                        <h2 class="mb-0">
                            {{ $clients->filter(function($c) {
                                return $c->debts()->whereIn('status', ['pending', 'overdue'])->count() == 0;
                            })->count() }}
                        </h2>
                    </div>
                    <div>
                        <i class="fas fa-check-circle fa-3x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Con Deudas</h6>
                        <h2 class="mb-0">
                            {{ $clients->filter(function($c) {
                                return $c->debts()->whereIn('status', ['pending', 'overdue'])->count() > 0;
                            })->count() }}
                        </h2>
                    </div>
                    <div>
                        <i class="fas fa-exclamation-triangle fa-3x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Adeudado</h6>
                        <h2 class="mb-0">
                            @php
                                $totalDebt = $clients->sum(function($c) {
                                    return $c->debts()->whereIn('status', ['pending', 'overdue'])->sum('balance_due');
                                });
                            @endphp
                            ${{ number_format($totalDebt, 0) }}
                        </h2>
                    </div>
                    <div>
                        <i class="fas fa-money-bill-wave fa-3x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Búsqueda en tiempo real
document.getElementById('searchClient').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('#clientsTable tbody tr');
    
    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});
</script>
@endpush
@endsection