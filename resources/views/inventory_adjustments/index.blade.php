@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Ajustes de Inventario</h1>
        <a href="{{ route('inventory_adjustments.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Nuevo Ajuste
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-0">
            <h6 class="m-0 fw-bold text-primary">Bitácora de Movimientos</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4">PRODUCTO</th>
                            <th>CANTIDAD</th>
                            <th>MOTIVO / RAZÓN</th>
                            <th>FECHA REGISTRO</th>
                            <th class="text-end pe-4">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($adjustments as $adjustment)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-2 rounded me-3">
                                        <i class="fas fa-box text-muted"></i>
                                    </div>
                                    <span class="fw-bold">{{ $adjustment->product->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3">
                                    + {{ $adjustment->quantity }} unidades
                                </span>
                            </td>
                            <td><span class="small">{{ $adjustment->reason }}</span></td>
                            <td class="text-muted small">
                                {{ $adjustment->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('inventory_adjustments.show', $adjustment->id) }}" class="btn btn-sm btn-white text-primary" title="Ver detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('inventory_adjustments.edit', $adjustment->id) }}" class="btn btn-sm btn-white text-warning" title="Editar ajuste">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('inventory_adjustments.destroy', $adjustment->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-white text-danger" onclick="return confirm('¿Eliminar ajuste? El stock volverá a disminuir.')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No se han registrado ajustes de stock.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection