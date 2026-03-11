@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('products.index') }}" class="text-decoration-none small text-muted">
                <i class="fas fa-arrow-left me-1"></i> Volver al Catálogo
            </a>
            <h1 class="h3 mb-0 text-gray-800 fw-bold mt-2">
                <i class="fas fa-trash-alt text-secondary me-2"></i>Productos Eliminados
            </h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light py-3 border-0">
            <h6 class="m-0 fw-bold text-secondary">Elementos en la Papelera</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4">PRODUCTO</th>
                            <th>CATEGORÍA</th>
                            <th>FECHA ELIMINACIÓN</th>
                            <th class="text-end pe-4">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-secondary bg-opacity-10 p-2 rounded me-3 text-secondary text-center" style="width: 40px;">
                                        <i class="fas fa-archive"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-muted">{{ $product->name }}</div>
                                        <small class="text-xs text-danger">ID: #{{ $product->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-muted border px-3">
                                    {{ $product->category->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="text-muted small">
                                {{ $product->deleted_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm border rounded bg-white">
                                    <form action="{{ route('products.restore', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-white text-success border-end" title="Restaurar Producto" onclick="return confirm('¿Deseas restaurar este producto al catálogo activo?')">
                                            <i class="fas fa-undo-alt"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('products.force-delete', $product->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-white text-danger" title="Eliminar Permanentemente" onclick="return confirm('¡Atención! Esta acción borrará el producto de forma definitiva. ¿Continuar?')">
                                            <i class="fas fa-fire-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-trash-restore fa-3x mb-3 opacity-25"></i><br>
                                La papelera está vacía.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-white { background-color: #fff; border: none; }
    .btn-white:hover { background-color: #f8f9fa; }
    .text-xs { font-size: 0.75rem; }
</style>
@endsection