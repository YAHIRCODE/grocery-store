@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('supplier_debts.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Cancelar y volver
        </a>
        <h1 class="h3 mb-0 text-gray-800 fw-bold mt-2 text-warning">Actualizar Deuda de Proveedor</h1>
        <p class="text-muted small">ID de Registro: #DEBT-{{ str_pad($debt->id, 4, '0', STR_PAD_LEFT) }}</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <ul class="mb-0 small">
                @foreach($errors->all() as $error)
                    <li><i class="fas fa-exclamation-triangle me-2"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <form action="{{ route('supplier_debts.update', $debt->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm p-4">
                            <h5 class="fw-bold mb-4 border-bottom pb-2">Información de la Cuenta</h5>
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Proveedor</label>
                                <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ $debt->supplier_id == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Fecha de Inicio</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $debt->start_date) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Fecha de Vencimiento</label>
                                    <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $debt->due_date) }}" required>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Monto Actual ($)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light fw-bold">$</span>
                                        <input type="number" step="0.01" name="amount" class="form-control fw-bold" value="{{ old('amount', $debt->amount) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Estado del Pago</label>
                                    <select name="status" class="form-select fw-bold {{ $debt->status == 'pending' ? 'text-warning' : ($debt->status == 'paid' ? 'text-success' : 'text-danger') }}" required>
                                        <option value="pending" {{ $debt->status == 'pending' ? 'selected' : '' }}>PENDIENTE</option>
                                        <option value="paid" {{ $debt->status == 'paid' ? 'selected' : '' }}>PAGADO</option>
                                        <option value="overdue" {{ $debt->status == 'overdue' ? 'selected' : '' }}>VENCIDO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-4 bg-light mb-4 text-center">
                            <i class="fas fa-history fa-2x text-muted mb-3"></i>
                            <h6 class="fw-bold">Última Modificación</h6>
                            <p class="small text-muted mb-0">{{ $debt->updated_at->format('d/m/Y H:i A') }}</p>
                        </div>
                        
                        <button type="submit" class="btn btn-warning w-100 py-3 fw-bold shadow-sm mb-2">
                            <i class="fas fa-sync-alt me-2"></i> Actualizar Registro
                        </button>
                        <a href="{{ route('supplier_debts.index') }}" class="btn btn-link w-100 text-muted text-decoration-none small">
                            Descartar cambios
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection