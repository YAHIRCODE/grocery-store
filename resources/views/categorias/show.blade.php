@extends('layouts.app')

@section('title', 'Detalles de Categoría')
@section('page-title', 'Detalles de Categoría')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <!-- Información de la Categoría -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-tags"></i> {{ $category->name }}
                </h5>
                
                @if(auth()->user()->isAdmin() || auth()->user()->isWarehouseWorker())
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> #{{ $category->id }}</p>
                        <p><strong>Nombre:</strong> {{ $category->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Creada:</strong> {{ $category->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Actualizada:</strong> {{ $category->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                
                @if($category->description)
                    <hr>
                    <p><strong>Descripción:</strong></p>
                    <p>{{ $category->description }}</p>
                @endif
            </div>
        </div>
        
        <!-- Productos de esta Categoría -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-box"></i> Productos en esta Categoría ({{ $category->products->count() }})
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($category->products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>${{ number_format($product->price, 2) }}</td>
                                <td>
                                    <span class="badge {{ $product->stock <= $product->min_stock ? 'bg-danger' : 'bg-success' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('products.show', $product->id) }}" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted">
                                    No hay productos en esta categoría
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Botón Volver -->
        <div class="mt-3">
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Listado
            </a>
        </div>
    </div>
</div>
@endsection