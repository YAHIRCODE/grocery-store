@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('inventory_adjustments.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Regresar al historial
        </a>
        <h1 class="h3 mb-0 text-gray-800 fw-bold mt-2">Nuevo Ajuste de Stock</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4">
                <form action="{{ route('inventory_adjustments.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Seleccionar Producto</label>
                        <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                            <option value="" selected disabled>Elija un producto para ajustar...</option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }} (Stock actual: {{ $product->stock }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Tipo de Ajuste</label>
                        <select name="adjustment_type" class="form-select" required>
                            <option value="addition">Entrada (Aumentar Stock)</option>
                            <option value="subtraction">Salida / Merma (Disminuir Stock)</option>
                        </select>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Cantidad a Sumar</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-plus"></i></span>
                                <input type="number" name="quantity" class="form-control" min="1" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Motivo del Ajuste</label>
                        <textarea name="reason" class="form-control" rows="3" placeholder="Ej: Ingreso por devolución, reposición, etc." required></textarea>
                    </div>

                    <div class="alert alert-info border-0 small">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Nota:</strong> Esta acción incrementará el stock actual del producto de forma inmediata.
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Registrar Movimiento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection