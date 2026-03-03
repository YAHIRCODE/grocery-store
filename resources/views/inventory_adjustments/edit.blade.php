@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('inventory_adjustments.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Cancelar y volver
        </a>
        <h1 class="h3 mb-0 text-gray-800 fw-bold mt-2 text-warning">Corregir Ajuste de Inventario</h1>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4 small">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li><i class="fas fa-exclamation-triangle me-2"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                    <span class="fw-bold text-warning-emphasis">
                        <i class="fas fa-edit me-2"></i> Editando Folio #{{ $adjustment->id }}
                    </span>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('inventory_adjustments.update', $adjustment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">Producto Asociado</label>
                                <input type="text" class="form-control bg-light" value="{{ $adjustment->product->name }}" readonly>
                                <input type="hidden" name="product_id" value="{{ $adjustment->product_id }}">
                                <small class="text-muted"><i>El producto no se puede cambiar para mantener la integridad del stock.</i></small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nueva Cantidad a Ajustar</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-sort-numeric-up-alt"></i></span>
                                    <input type="number" name="quantity" class="form-control fw-bold" 
                                           value="{{ old('quantity', $adjustment->quantity) }}" min="1" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold">Razón Actualizada</label>
                                <textarea name="reason" class="form-control" rows="3" required>{{ old('reason', $adjustment->reason) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4 p-3 bg-light rounded d-flex align-items-center">
                            <i class="fas fa-exclamation-circle text-warning fs-4 me-3"></i>
                            <p class="small mb-0 text-muted">
                                <strong>Atención:</strong> Al actualizar, el sistema recalculará el stock basándose en la diferencia entre la cantidad anterior y la nueva.
                            </p>
                        </div>

                        <div class="mt-4 pt-3 border-top text-end">
                            <button type="submit" class="btn btn-warning px-5 fw-bold shadow-sm">
                                <i class="fas fa-sync-alt me-2"></i> Actualizar Ajuste
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection