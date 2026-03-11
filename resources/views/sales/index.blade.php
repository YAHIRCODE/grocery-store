@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Historial de Ventas</h1>
        <a href="{{ route('sales.create') }}" class="btn btn-primary shadow-sm px-4">
            <i class="fas fa-cart-plus me-1"></i> Nueva Venta
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
        <div class="card-header bg-white py-3 border-0">
            <h6 class="m-0 fw-bold text-primary">Registro General de Operaciones</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4">FOLIO</th>
                            <th>PRODUCTO</th>
                            <th>CANTIDAD</th>
                            <th>TOTAL</th>
                            <th>VENDEDOR</th>
                            <th>FECHA</th>
                            <th class="text-end pe-4">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">
                                #{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
                            </td>
                            
                            <td>
                                <div class="fw-bold text-dark">{{ $sale->product->name }}</div>
                                <small class="text-muted">${{ number_format($sale->product->price, 2) }} c/u</small>
                            </td>

                            <td>
                                <span class="badge bg-light text-dark border px-3">
                                    {{ $sale->quantity }} unidades
                                </span>
                            </td>

                            <td class="fw-bold text-success">
                                ${{ number_format($sale->total_price, 2) }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle text-muted me-2"></i>
                                    <span class="small fw-bold">{{ $sale->employee->first_name }}</span>
                                </div>
                            </td>

                            <td class="small text-muted">
                                {{ $sale->created_at->format('d/m/Y') }}<br>
                                <small>{{ $sale->created_at->format('H:i A') }}</small>
                            </td>

                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm bg-white border rounded">
                                    <a href="{{ route('pdf.venta', $sale->id) }}" class="btn btn-sm btn-white text-danger border-end" title="Descargar PDF" target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>

                                    <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-white text-primary border-end" title="Ver Detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <form action="{{ route('sales.revert', $sale->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-white text-warning border-end" 
                                                title="revertir la cancelacion de la venta " 
                                                onclick="return confirm('¿Seguro que deseas revertir la cancelación de esta venta?')">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('sales.cancel', $sale->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-white text-danger" 
                                                title="Devolucion del producto al inventario" 
                                                onclick="return confirm('¿Seguro que deseas cancelar esta venta? Esta acción no se puede deshacer.')">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i><br>
                                No se han registrado ventas aún.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($sales instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="card-footer bg-white border-0 py-3">
                {{ $sales->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    /* Estilo para que los botones blancos se vean más limpios */
    .btn-white {
        background-color: #fff;
        border: none;
    }
    .btn-white:hover {
        background-color: #f8f9fa;
        filter: brightness(0.95);
    }
    .btn-group .btn-sm {
        padding: 0.4rem 0.7rem;
    }
</style>
@endsection