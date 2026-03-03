@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('products.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Volver al catálogo
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="bg-primary p-4 text-white text-center">
                    <i class="fas fa-barcode fa-4x mb-3 opacity-50"></i>
                    <h3 class="fw-bold mb-0">{{ $product->name }}</h3>
                    <span class="badge bg-white text-primary rounded-pill px-3 mt-2">
                        {{ $product->category->name ?? 'Sin Categoría' }}
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="row text-center mb-4">
                        <div class="col-6 border-end">
                            <p class="text-muted small mb-0 text-uppercase fw-bold">Precio</p>
                            <h4 class="fw-bold text-dark">${{ number_format($product->price, 2) }}</h4>
                        </div>
                        <div class="col-6">
                            <p class="text-muted small mb-0 text-uppercase fw-bold">Existencia</p>
                            <h4 class="fw-bold {{ $product->stock <= 5 ? 'text-danger' : 'text-success' }}">
                                {{ $product->stock }} <small class="fs-6">unid.</small>
                            </h4>
                        </div>
                    </div>
                    
                    <div class="bg-light p-3 rounded">
                        <h6 class="fw-bold small text-muted">Descripción:</h6>
                        <p class="mb-0">{{ $product->description }}</p>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning w-100 fw-bold shadow-sm">
                            <i class="fas fa-edit me-1"></i> Editar Producto
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection