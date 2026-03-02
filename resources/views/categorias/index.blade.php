@extends('layouts.app')

@section('title', 'Categorías')
@section('page-title', 'Gestión de Categorías')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-tags"></i> Lista de Categorías
        </h5>
        
        @if(auth()->user()->isAdmin() || auth()->user()->isWarehouseWorker())
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Categoría
            </a>
        @endif
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Productos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td><strong>#{{ $category->id }}</strong></td>
                        <td>
                            <span class="badge bg-primary" style="font-size: 14px;">
                                {{ $category->name }}
                            </span>
                        </td>
                        <td>{{ $category->description ?? '-' }}</td>
                        <td>
                            <span class="badge bg-info">
                                {{ $category->products_count ?? 0 }} productos
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('categories.show', $category->id) }}" 
                                   class="btn btn-sm btn-info" 
                                   title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if(auth()->user()->isAdmin() || auth()->user()->isWarehouseWorker())
                                    <a href="{{ route('categories.edit', $category->id) }}" 
                                       class="btn btn-sm btn-warning" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if(auth()->user()->isAdmin())
                                        <form action="{{ route('categories.destroy', $category->id) }}" 
                                              method="POST" 
                                              style="display:inline;"
                                              onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            <p>No hay categorías registradas</p>
                            @if(auth()->user()->isAdmin() || auth()->user()->isWarehouseWorker())
                                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Crear Primera Categoría
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection