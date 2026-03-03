@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('sales.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Volver al historial
        </a>
        <a href="{{ route('pdf.venta', $sale->id) }}" class="btn btn-danger btn-sm shadow-sm" target="_blank">
            <i class="fas fa-file-pdf me-1"></i> Imprimir Comprobante
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-shopping-basket fa-3x text-primary mb-3"></i>
                        <h4 class="fw-bold mb-0">GROCERY STORE</h4>
                        <p class="text-muted small">Ticket de Venta #{{ $sale->id }}</p>
                    </div>

                    <div class="border-top border-bottom py-3 mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Fecha:</span>
                            <span class="fw-bold">{{ $sale->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Atendido por:</span>
                            <span class="fw-bold">{{ $sale->employee->first_name }} {{ $sale->employee->last_name }}</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="small fw-bold text-muted mb-3 text-uppercase">Detalle del Producto</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-0">{{ $sale->product->name }}</h6>
                                <small class="text-muted">{{ $sale->quantity }} unidad(es) x ${{ number_format($sale->product->price, 2) }}</small>
                            </div>
                            <h5 class="fw-bold mb-0">${{ number_format($sale->total_price, 2) }}</h5>
                        </div>
                    </div>

                    <div class="bg-light p-4 rounded text-center">
                        <p class="text-muted small mb-1">TOTAL PAGADO</p>
                        <h2 class="fw-bold text-success mb-0">${{ number_format($sale->total_price, 2) }}</h2>
                    </div>

                    <div class="text-center mt-5">
                        <p class="small text-muted italic">¡Gracias por su compra!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection