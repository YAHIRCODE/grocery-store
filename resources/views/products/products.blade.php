@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Catálogo de Productos</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> Nuevo Producto
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4">PRODUCTO</th>
                            <th>CATEGORÍA</th>
                            <th>PRECIO</th>
                            <th>EXISTENCIA</th>
                            <th class="text-end pe-4">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded me-3 text-primary text-center" style="width: 40px;">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $product->name }}</div>
                                        <small class="text-muted text-truncate d-block" style="max-width: 200px;">{{ $product->description }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-3">
                                    {{ $product->category->name ?? 'Sin Categoría' }}
                                </span>
                            </td>
                            <td class="fw-bold text-dark">${{ number_format($product->price, 2) }}</td>
                            <td>
                                @if($product->stock <= 5)
                                    <span class="text-danger fw-bold"><i class="fas fa-arrow-down me-1"></i> {{ $product->stock }}</span>
                                @else
                                    <span class="text-success fw-bold">{{ $product->stock }}</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-white text-primary"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-white text-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-white text-danger" onclick="return confirm('¿Eliminar producto?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No hay productos en el inventario.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection