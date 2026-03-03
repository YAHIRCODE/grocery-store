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
                    @csrf @method('PUT')
                    <div class="row g-3">
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
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Precio Compra ($)</label>
                            <input type="number" step="0.01" name="purchase_price" class="form-control" value="{{ $product->purchase_price }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Precio Venta ($)</label>
                            <input type="number" step="0.01" name="price" class="form-control fw-bold text-primary" value="{{ $product->price }}" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 mt-4 fw-bold shadow-sm">
                        <i class="fas fa-sync-alt me-1"></i> Actualizar Producto
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection