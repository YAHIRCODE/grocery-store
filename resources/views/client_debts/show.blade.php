@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('client_debts.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
        <a href="{{ route('client_debts.edit', $debt->id) }}" class="btn btn-sm btn-outline-warning">
            <i class="fas fa-edit me-1"></i> Editar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-dark text-white text-center py-4">
                    <p class="small text-uppercase mb-1 opacity-75">Saldo Pendiente del Cliente</p>
                    <h2 class="fw-bold mb-0">${{ number_format($debt->balance_due, 2) }}</h2>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold fs-5">{{ $debt->client->name }}</span>
                        <span class="badge rounded-pill bg-{{ $debt->status == 'paid' ? 'success' : 'danger' }} px-3 py-2">
                            {{ strtoupper($debt->status) }}
                        </span>
                    </div>
                    
                    <div class="list-group list-group-flush small">
                        <div class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Fecha del Crédito:</span>
                            <span class="fw-bold">{{ \Carbon\Carbon::parse($debt->start_date)->format('d M, Y') }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Fecha de Vencimiento:</span>
                            <span class="fw-bold text-danger">{{ \Carbon\Carbon::parse($debt->due_date)->format('d M, Y') }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Teléfono Cliente:</span>
                            <span class="fw-bold">{{ $debt->client->phone ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded text-center small text-muted italic">
                        <i class="fas fa-info-circle me-1"></i>
                        Esta deuda fue creada hace {{ $debt->created_at->diffForHumans() }}.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection