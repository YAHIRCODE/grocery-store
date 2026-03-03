@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Cuentas por Pagar (Proveedores)</h1>
        <a href="{{ route('supplier_debts.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-file-invoice-dollar me-1"></i> Registrar Nueva Deuda
        </a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 border-start border-warning border-4">
                <p class="text-muted mb-0 small fw-bold">TOTAL PENDIENTE</p>
                <h4 class="fw-bold mb-0 text-warning">${{ number_format($debts->where('status', 'pending')->sum('amount'), 2) }}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 border-start border-danger border-4">
                <p class="text-muted mb-0 small fw-bold">TOTAL VENCIDO</p>
                <h4 class="fw-bold mb-0 text-danger">${{ number_format($debts->where('status', 'overdue')->sum('amount'), 2) }}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 border-start border-success border-4">
                <p class="text-muted mb-0 small fw-bold">TOTAL PAGADO</p>
                <h4 class="fw-bold mb-0 text-success">${{ number_format($debts->where('status', 'paid')->sum('amount'), 2) }}</h4>
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
                            <th class="ps-4">PROVEEDOR</th>
                            <th>FECHA INICIO</th>
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
                                <div class="fw-bold text-dark">{{ $debt->supplier->company_name }}</div>
                                <small class="text-muted">{{ $debt->supplier->contact_name }}</small>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($debt->start_date)->format('d/m/Y') }}</td>
                            <td>
                                <span class="{{ $debt->status == 'overdue' ? 'text-danger fw-bold' : '' }}">
                                    {{ \Carbon\Carbon::parse($debt->due_date)->format('d/m/Y') }}
                                </span>
                            </td>
                            <td class="fw-bold text-dark">${{ number_format($debt->amount, 2) }}</td>
                            <td>
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-warning text-warning',
                                        'paid' => 'bg-success text-success',
                                        'overdue' => 'bg-danger text-danger'
                                    ];
                                    $label = ['pending' => 'Pendiente', 'paid' => 'Pagado', 'overdue' => 'Vencido'];
                                @endphp
                                <span class="badge rounded-pill {{ $statusClasses[$debt->status] }} bg-opacity-10 px-3">
                                    {{ $label[$debt->status] }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('supplier_debts.show', $debt->id) }}" class="btn btn-sm btn-white text-primary"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('supplier_debts.edit', $debt->id) }}" class="btn btn-sm btn-white text-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('supplier_debts.destroy', $debt->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-white text-danger" onclick="return confirm('¿Eliminar registro de deuda?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted">No hay deudas registradas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection