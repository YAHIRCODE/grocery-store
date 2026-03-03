@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('inventory_adjustments.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="bg-dark p-4 text-white text-center">
                    <i class="fas fa-history fa-3x mb-3 opacity-50"></i>
                    <h5 class="fw-bold mb-0">Detalle de Ajuste #{{ $adjustment->id }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-12 border-bottom pb-2">
                            <label class="text-muted small d-block">Producto Impactado</label>
                            <span class="fw-bold text-dark fs-5">{{ $adjustment->product->name }}</span>
                        </div>
                        <div class="col-md-6 border-bottom pb-2">
                            <label class="text-muted small d-block">Cantidad Ajustada</label>
                            <span class="fw-bold text-success">+ {{ $adjustment->quantity }} unidades</span>
                        </div>
                        <div class="col-md-6 border-bottom pb-2">
                            <label class="text-muted small d-block">Fecha y Hora</label>
                            <span class="fw-bold">{{ $adjustment->created_at->format('d/m/Y H:i A') }}</span>
                        </div>
                        <div class="col-12">
                            <label class="text-muted small d-block">Razón del Ajuste</label>
                            <p class="p-3 bg-light rounded mt-1">{{ $adjustment->reason }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection