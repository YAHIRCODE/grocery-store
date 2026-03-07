@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('products.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Cancelar
        </a>
        <h1 class="h3 mb-0 text-gray-800 fw-bold mt-2 text-warning">Editar Producto</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4">
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf 
                    @method('PUT')
                    
                    <h6 class="text-muted fw-bold mb-3 uppercase small">Información General</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label class="form-label small fw-bold">Nombre</label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Categoría</label>
                            <select name="category_id" class="form-select" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Descripción</label>
                            <textarea name="description" class="form-control" rows="2" required>{{ $product->description }}</textarea>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-4 border-start border-4 border-warning">
                        <h6 class="text-dark fw-bold mb-3">
                            <i class="fas fa-boxes me-2 text-warning"></i>Inventario y Precios
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Stock Actual</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-cubes text-muted"></i></span>
                                    <input type="number" name="stock" class="form-control border-start-0 fw-bold" value="{{ $product->stock }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Stock Mínimo</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-exclamation-triangle text-muted"></i></span>
                                    <input type="number" name="min_stock" class="form-control border-start-0" value="{{ $product->min_stock ?? 0 }}" required title="Alerta de bajo stock">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Precio Compra ($)</label>
                                <input type="number" step="0.01" name="purchase_price" class="form-control" value="{{ $product->purchase_price }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Precio Venta ($)</label>
                                <input type="number" step="0.01" name="price" class="form-control fw-bold text-primary" value="{{ $product->price }}" required>
                            </div>
                        </div>
                        <div class="mt-2 text-end">
                            <small class="text-muted italic">Ajuste el stock manualmente solo para correcciones de inventario.</small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning w-100 fw-bold shadow-sm py-2">
                        <i class="fas fa-sync-alt me-1"></i> Actualizar Producto Completamente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilo para que los campos de inventario resalten ligeramente */
    .bg-light {
        background-color: #f8f9fc !important;
    }
    .input-group-text {
        font-size: 0.85rem;
    }
</style>
@endsection