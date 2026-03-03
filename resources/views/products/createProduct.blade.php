@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('products.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Regresar
        </a>
        <h1 class="h3 mb-0 text-gray-800 fw-bold mt-2">Registrar Producto</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label small fw-bold">Nombre del Producto</label>
                            <input type="text" name="name" class="form-control" placeholder="Ej. Arroz 1kg" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Categoría</label>
                            <select name="category_id" class="form-select" required>
                                <option value="" selected disabled>Seleccionar...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Descripción</label>
                            <textarea name="description" class="form-control" rows="2" required></textarea>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Precio de Compra (Costo)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">$</span>
                                <input type="number" step="0.01" name="purchase_price" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Precio de Venta</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">$</span>
                                <input type="number" step="0.01" name="price" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Stock Inicial</label>
                            <input type="number" name="stock" class="form-control" value="0">
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <hr>
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Guardar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection