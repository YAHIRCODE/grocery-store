@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Cuentas por Cobrar (Clientes)</h1>
        <a href="{{ route('client_debts.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-hand-holding-usd me-1"></i> Registrar Deuda
        </a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 border-start border-warning border-4">
                <p class="text-muted mb-0 small fw-bold text-uppercase">Pendiente de Cobro</p>
                <h4 class="fw-bold mb-0 text-warning">${{ number_format($debts->where('status', 'pending')->sum('balance_due'), 2) }}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 border-start border-danger border-4">
                <p class="text-muted mb-0 small fw-bold text-uppercase">Total Vencido</p>
                <h4 class="fw-bold mb-0 text-danger">${{ number_format($debts->where('status', 'overdue')->sum('balance_due'), 2) }}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 border-start border-success border-4">
                <p class="text-muted mb-0 small fw-bold text-uppercase">Total Recuperado</p>
                <h4 class="fw-bold mb-0 text-success">${{ number_format($debts->where('status', 'paid')->sum('balance_due'), 2) }}</h4>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4">CLIENTE</th>
                            <th>F. INICIO</th>
                            <th>VENCIMIENTO</th>
                            <th>MONTO</th>
                            <th>ESTADO</th>
                            <th class="text-end pe-4">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($debts as $debt)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 p-2 rounded-circle me-3 text-info">
                                        <i class="fas fa-user-tag"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold d-block text-dark">{{ $debt->client->name }}</span>
                                        <small class="text-muted">ID: #{{ $debt->client->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($debt->start_date)->format('d/m/y') }}</td>
                            <td>
                                <span class="{{ $debt->status == 'overdue' ? 'text-danger fw-bold' : '' }}">
                                    {{ \Carbon\Carbon::parse($debt->due_date)->format('d/m/y') }}
                                </span>
                            </td>
                            <td class="fw-bold">${{ number_format($debt->balance_due, 2) }}</td>
                            <td>
                                @php
                                    $badge = [
                                        'pending' => 'bg-warning text-warning',
                                        'paid' => 'bg-success text-success',
                                        'overdue' => 'bg-danger text-danger'
                                    ];
                                @endphp
                                <span class="badge rounded-pill {{ $badge[$debt->status] }} bg-opacity-10 px-3">
                                    {{ ucfirst($debt->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('client_debts.show', $debt->id) }}" class="btn btn-sm btn-white text-primary"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('client_debts.edit', $debt->id) }}" class="btn btn-sm btn-white text-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('client_debts.destroy', $debt->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-white text-danger" onclick="return confirm('¿Eliminar registro?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-5">No hay deudas de clientes.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection