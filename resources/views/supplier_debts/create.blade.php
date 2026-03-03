@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('supplier_debts.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Volver al listado
        </a>
        <h1 class="h3 mb-0 text-gray-800 fw-bold mt-2">Registrar Deuda con Proveedor</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4">
                <form action="{{ route('supplier_debts.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Seleccionar Proveedor</label>
                            <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                                <option value="" selected disabled>Elija un proveedor...</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Fecha de Inicio / Factura</label>
                            <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Fecha de Vencimiento</label>
                            <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Monto de la Deuda</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">$</span>
                                <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Estado Inicial</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" selected>Pendiente</option>
                                <option value="paid">Pagado</option>
                                <option value="overdue">Vencido</option>
                            </select>
                        </div>

                        <div class="col-12 text-end mt-4">
                            <hr>
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm">
                                <i class="fas fa-save me-2"></i> Guardar Registro
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection