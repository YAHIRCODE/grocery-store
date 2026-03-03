@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('products.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Regresar al catálogo
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
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Ej. Leche Entera 1L" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Categoría</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="" selected disabled>Seleccionar...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Descripción</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Detalles del producto..." required>{{ old('description') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Precio de Venta</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold">$</span>
                                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Stock Inicial</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-cubes"></i></span>
                                <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}">
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-5">
                        <hr>
                        <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Guardar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection