@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('categories.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Volver a categorías
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 h-100">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 p-4 rounded-circle d-inline-block text-primary mb-3">
                        <i class="fas fa-tags fa-3x"></i>
                    </div>
                    <h3 class="fw-bold">{{ $category->name }}</h3>
                </div>
                <hr>
                <h6 class="fw-bold text-muted small text-uppercase">Descripción</h6>
                <p>{{ $category->description ?? 'Sin descripción disponible.' }}</p>
                
                <div class="mt-4 pt-3 border-top">
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-outline-warning btn-sm w-100 mb-2">
                        <i class="fas fa-edit me-1"></i> Editar Categoría
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-4">Productos en esta categoría</h5>
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead class="text-muted small">
                            <tr>
                                <th>PRODUCTO</th>
                                <th class="text-center">STOCK</th>
                                <th class="text-end">PRECIO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($category->products as $product)
                            <tr>
                                <td>
                                    <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none fw-bold">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $product->stock <= 5 ? 'bg-danger' : 'bg-success' }} bg-opacity-10 {{ $product->stock <= 5 ? 'text-danger' : 'text-success' }}">
                                        {{ $product->stock }} unid.
                                    </span>
                                </td>
                                <td class="text-end fw-bold">${{ number_format($product->price, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted small italic">No hay productos vinculados a esta categoría.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection