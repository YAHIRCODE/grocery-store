@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Categorías de Productos</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-tags me-1"></i> Nueva Categoría
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
                            <th class="ps-4">NOMBRE DE CATEGORÍA</th>
                            <th>DESCRIPCIÓN</th>
                            <th class="text-center">PRODUCTOS</th>
                            <th class="text-end pe-4">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded me-3 text-primary text-center" style="width: 40px;">
                                        <i class="fas fa-folder-open"></i>
                                    </div>
                                    <span class="fw-bold text-dark">{{ $category->name }}</span>
                                </div>
                            </td>
                            <td>
                                <small class="text-muted">{{ Str::limit($category->description, 60) ?? 'Sin descripción' }}</small>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-info bg-opacity-10 text-info px-3">
                                    {{ $category->products_count }} artículos
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-white text-primary"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-white text-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-white text-danger" onclick="return confirm('¿Eliminar esta categoría?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">No hay categorías registradas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection