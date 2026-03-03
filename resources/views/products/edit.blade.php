@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4 text-muted small">
        <a href="{{ route('products.index') }}" class="text-decoration-none text-muted">
            <i class="fas fa-arrow-left me-1"></i> Cancelar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-warning bg-opacity-10 p-3 rounded me-3 text-warning">
                        <i class="fas fa-edit fa-lg"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">Modificar Producto</h4>
                        <p class="text-muted small mb-0">{{ $product->name }}</p>
                    </div>
                </div>

                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label small fw-bold">Nombre</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
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
                            <textarea name="description" class="form-control" rows="3" required>{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Precio ($)</label>
                            <input type="number" step="0.01" name="price" class="form-control fw-bold" value="{{ old('price', $product->price) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Existencia Actual</label>
                            <input type="number" name="stock" class="form-control bg-light" value="{{ old('stock', $product->stock) }}">
                        </div>
                    </div>

                    <div class="mt-5 text-end">
                        <button type="submit" class="btn btn-warning px-5 py-2 fw-bold shadow-sm">
                            <i class="fas fa-sync-alt me-1"></i> Actualizar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection