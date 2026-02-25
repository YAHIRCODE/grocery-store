@extends('layouts.app')

@section('title', 'Productos')
@section('page-title', 'Gestión de Productos')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-box"></i> Lista de Productos
        </h5>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Producto
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Stock Mínimo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="{{ $product->stock <= $product->min_stock ? 'table-warning' : '' }}">
                        <td><strong>#{{ $product->id }}</strong></td>
                        <td>
                            <strong>{{ $product->name }}</strong>
                            @if($product->barcode)
                                <br><small class="text-muted">{{ $product->barcode }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $product->category->name ?? '-' }}
                            </span>
                        </td>
                        <td><strong>${{ number_format($product->price, 2) }}</strong></td>
                        <td>
                            <strong class="{{ $product->stock <= $product->min_stock ? 'text-danger' : 'text-success' }}">
                                {{ $product->stock }}
                            </strong>
                        </td>
                        <td>{{ $product->min_stock }}</td>
                        <td>
                            @if($product->stock <= 0)
                                <span class="badge bg-danger">Sin Stock</span>
                            @elseif($product->stock <= $product->min_stock)
                                <span class="badge bg-warning">Stock Bajo</span>
                            @else
                                <span class="badge bg-success">Disponible</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('products.show', $product->id) }}" 
                                   class="btn btn-sm btn-info" 
                                   title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}" 
                                   class="btn btn-sm btn-warning" 
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" 
                                      method="POST" 
                                      style="display:inline;"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            <p>No hay productos registrados</p>
                            <a href="{{ route('products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Crear Primer Producto
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Resumen de Stock -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6>Productos con Stock Suficiente</h6>
                <h2>{{ $products->filter(fn($p) => $p->stock > $p->min_stock)->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h6>Productos con Stock Bajo</h6>
                <h2>{{ $products->filter(fn($p) => $p->stock <= $p->min_stock && $p->stock > 0)->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h6>Productos Sin Stock</h6>
                <h2>{{ $products->filter(fn($p) => $p->stock == 0)->count() }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection