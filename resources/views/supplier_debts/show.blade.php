@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <a href="{{ route('supplier_debts.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
        <a href="{{ route('supplier_debts.edit', $debt->id) }}" class="btn btn-sm btn-outline-warning shadow-sm">
            <i class="fas fa-edit me-1"></i> Editar Deuda
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="bg-primary p-4 text-white text-center">
                    <p class="mb-1 opacity-75">Monto de la Deuda</p>
                    <h2 class="fw-bold mb-0">${{ number_format($debt->amount, 2) }}</h2>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Detalles del Proveedor</h5>
                        <span class="badge bg-{{ $debt->status == 'paid' ? 'success' : ($debt->status == 'overdue' ? 'danger' : 'warning') }} px-3 py-2">
                            {{ strtoupper($debt->status) }}
                        </span>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 border-bottom pb-2">
                            <small class="text-muted d-block">Empresa</small>
                            <span class="fw-bold text-dark fs-5">{{ $debt->supplier->company_name }}</span>
                        </div>
                        <div class="col-md-6 border-bottom pb-2">
                            <small class="text-muted d-block">Fecha de Emisión</small>
                            <span class="fw-bold">{{ \Carbon\Carbon::parse($debt->start_date)->format('d M, Y') }}</span>
                        </div>
                        <div class="col-md-6 border-bottom pb-2">
                            <small class="text-muted d-block">Fecha Límite</small>
                            <span class="fw-bold text-danger">{{ \Carbon\Carbon::parse($debt->due_date)->format('d M, Y') }}</span>
                        </div>
                        <div class="col-12 border-bottom pb-2">
                            <small class="text-muted d-block">Contacto</small>
                            <span class="fw-bold">{{ $debt->supplier->contact_name }} ({{ $debt->supplier->phone }})</span>
                        </div>
                    </div>
                    
                    <div class="mt-4 bg-light p-3 rounded">
                        <small class="text-muted d-block mb-1 font-italic">Nota del sistema:</small>
                        <p class="small mb-0">Esta deuda fue registrada el {{ $debt->created_at->format('d/m/Y H:i') }}.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection