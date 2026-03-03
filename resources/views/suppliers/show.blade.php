@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <a href="{{ route('suppliers.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-outline-warning">
            <i class="fas fa-edit me-1"></i> Editar Datos
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 text-center">
                <div class="bg-primary bg-opacity-10 p-4 rounded-circle d-inline-block mx-auto mb-3 text-primary">
                    <i class="fas fa-truck-loading fa-3x"></i>
                </div>
                <h4 class="fw-bold">{{ $supplier->company_name }}</h4>
                <p class="text-muted small">Proveedor de la Tienda</p>
                <hr>
                <div class="text-start">
                    <p class="mb-1 small text-muted">Contacto Principal:</p>
                    <p class="fw-bold">{{ $supplier->contact_name }}</p>
                    <p class="mb-1 small text-muted">Teléfono:</p>
                    <p class="fw-bold">{{ $supplier->phone ?? 'Sin teléfono' }}</p>
                    <p class="mb-1 small text-muted">Email:</p>
                    <p class="fw-bold small text-primary">{{ $supplier->email ?? 'Sin email' }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-4"><i class="fas fa-file-invoice-dollar me-2"></i>Historial de Deudas / Pagos</h5>
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead class="text-muted small">
                            <tr>
                                <th>FECHA</th>
                                <th>MONTO</th>
                                <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supplier->debts as $debt)
                            <tr>
                                <td>{{ $debt->created_at->format('d/m/Y') }}</td>
                                <td class="fw-bold">${{ number_format($debt->amount, 2) }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $debt->status == 'paid' ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $debt->status == 'paid' ? 'text-success' : 'text-danger' }} px-3">
                                        {{ strtoupper($debt->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted small italic">No hay registros de deudas con este proveedor.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection