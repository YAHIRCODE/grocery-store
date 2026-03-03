@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('inventory_adjustments.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Volver a la bitácora
        </a>
        
        <div class="d-flex gap-2">
            <a href="{{ route('inventory_adjustments.edit', $adjustment->id) }}" class="btn btn-warning btn-sm shadow-sm px-3">
                <i class="fas fa-edit me-1"></i> Corregir
            </a>
            
            <button onclick="window.print();" class="btn btn-light btn-sm shadow-sm border px-3">
                <i class="fas fa-print me-1"></i> Imprimir
            </button>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="bg-dark p-4 text-white text-center">
                    <div class="mb-2">
                        <i class="fas fa-receipt fa-3x opacity-50"></i>
                    </div>
                    <h5 class="fw-bold mb-0">Detalle de Ajuste de Stock</h5>
                    <span class="badge bg-primary mt-2">Folio #{{ str_pad($adjustment->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-12 border-bottom pb-3">
                            <label class="text-muted small d-block uppercase fw-bold">Producto Impactado</label>
                            <div class="d-flex align-items-center mt-1">
                                <div class="bg-light p-2 rounded me-3">
                                    <i class="fas fa-box text-primary"></i>
                                </div>
                                <span class="fw-bold text-dark fs-5">{{ $adjustment->product->name }}</span>
                            </div>
                        </div>

                        <div class="col-md-6 border-bottom pb-3">
                            <label class="text-muted small d-block fw-bold">Cantidad Ajustada</label>
                            <span class="fw-bold text-success fs-4">+ {{ $adjustment->quantity }}</span>
                            <span class="text-muted small">unidades</span>
                        </div>

                        <div class="col-md-6 border-bottom pb-3">
                            <label class="text-muted small d-block fw-bold">Fecha de Registro</label>
                            <span class="fw-bold d-block">{{ $adjustment->created_at->format('d/m/Y') }}</span>
                            <span class="text-muted small">{{ $adjustment->created_at->format('H:i A') }}</span>
                        </div>

                        <div class="col-12">
                            <label class="text-muted small d-block fw-bold mb-2">Motivo o Razón del Ajuste</label>
                            <div class="p-3 bg-light rounded border-start border-4 border-primary">
                                <p class="mb-0 italic text-dark">{{ $adjustment->reason }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white py-3 text-center border-0">
                    <small class="text-muted">
                        Este ajuste afectó el stock contable de forma inmediata el {{ $adjustment->created_at->format('d/m/Y') }}.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, .mb-4 { display: none !important; }
        .card { border: 1px solid #ddd !important; shadow: none !important; }
    }
</style>
@endsection