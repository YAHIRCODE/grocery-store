@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Historial de Ventas</h1>
        <a href="{{ route('sales.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-cart-plus me-1"></i> Nueva Venta
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
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
                            <td class="ps-4 fw-bold text-primary">#{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="fw-bold">{{ $sale->product->name }}</div>
                                <small class="text-muted">${{ number_format($sale->product->price, 2) }} c/u</small>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $sale->quantity }} unid.</span></td>
                            <td class="fw-bold text-success">${{ number_format($sale->total_price, 2) }}</td>
                            <td>
                                <small class="fw-bold text-dark"><i class="fas fa-user-circle me-1"></i> {{ $sale->employee->first_name }}</small>
                            </td>
                            <td class="small text-muted">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('pdf.venta', $sale->id) }}" class="btn btn-sm btn-white text-danger" title="Descargar PDF" target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-white text-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-white text-muted" onclick="return confirm('¿Anular esta venta? El stock se devolverá al producto.')">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No se han registrado ventas aún.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection