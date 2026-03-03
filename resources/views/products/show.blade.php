@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('products.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Volver al catálogo
        </a>
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm shadow-sm fw-bold">
            <i class="fas fa-edit me-1"></i> Editar Información
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="bg-primary bg-gradient p-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="bg-white bg-opacity-25 p-3 rounded-circle">
                                <i class="fas fa-box fa-3x"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h2 class="fw-bold mb-0">{{ $product->name }}</h2>
                            <span class="badge bg-light text-primary rounded-pill px-3 mt-1">
                                {{ $product->category->name ?? 'Sin Categoría' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-3 mb-4 text-center">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Costo de Compra</small>
                                <h4 class="fw-bold mb-0 text-dark">${{ number_format($product->purchase_price, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 border border-primary border-opacity-25">
                                <small class="text-primary d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Precio de Venta</small>
                                <h4 class="fw-bold mb-0 text-primary">${{ number_format($product->price, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-success bg-opacity-10 rounded-3">
                                <small class="text-success d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Ganancia Unit.</small>
                                <h4 class="fw-bold mb-0 text-success">${{ number_format($product->price - $product->purchase_price, 2) }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted border-bottom pb-2">Descripción del Producto</h6>
                            <p class="text-dark">{{ $product->description }}</p>
                            
                            <div class="mt-4">
                                <h6 class="fw-bold text-muted border-bottom pb-2">Estado del Inventario</h6>
                                <div class="d-flex align-items-center mt-2">
                                    <div class="fs-1 fw-bold me-3 {{ $product->stock <= 5 ? 'text-danger' : 'text-dark' }}">
                                        {{ $product->stock }}
                                    </div>
                                    <div class="small text-muted">
                                        Unidades disponibles <br>
                                        @if($product->stock <= 5)
                                            <span class="badge bg-danger">STOCK CRÍTICO</span>
                                        @else
                                            <span class="badge bg-success">STOCK SALUDABLE</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card bg-light border-0 h-100 p-3">
                                <h6 class="fw-bold text-muted mb-3">Resumen de Rentabilidad</h6>
                                @php
                                    $margen = $product->purchase_price > 0 
                                        ? (($product->price - $product->purchase_price) / $product->purchase_price) * 100 
                                        : 0;
                                @endphp
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Margen de Utilidad:</span>
                                    <span class="fw-bold text-success">{{ number_format($margen, 1) }}%</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ min($margen, 100) }}%"></div>
                                </div>
                                <p class="small text-muted mt-3">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Este margen representa el porcentaje de beneficio sobre el costo original del producto.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection