@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4 text-muted small">
        <a href="{{ route('sales.index') }}" class="text-decoration-none text-muted">
            <i class="fas fa-arrow-left me-1"></i> Cancelar y volver al historial
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-warning py-3">
                    <h5 class="m-0 fw-bold text-dark"><i class="fas fa-edit me-2"></i>Corregir Registro de Venta #{{ $sale->id }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('sales.update', $sale->id) }}" method="POST" id="editSaleForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted">Cambiar Producto</label>
                                <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" 
                                            data-price="{{ $product->price }}" 
                                            {{ $sale->product_id == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} — ${{ number_format($product->price, 2) }} 
                                            (Stock actual: {{ $product->stock }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted italic">Nota: Al cambiar el producto, el stock del anterior se restaurará automáticamente.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Cantidad Vendida</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-sort-numeric-up"></i></span>
                                    <input type="number" name="quantity" id="quantity" class="form-control" 
                                           value="{{ old('quantity', $sale->quantity) }}" min="1" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-primary">Nuevo Total</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold text-primary">$</span>
                                    <input type="text" id="total_display" class="form-control fw-bold text-primary bg-light" 
                                           value="{{ number_format($sale->total_price, 2) }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning border-0 mt-4 small d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                            <div>
                                <strong>Advertencia de Inventario:</strong> Al guardar, el sistema devolverá las <strong>{{ $sale->quantity }}</strong> unidades al stock original y descontará la nueva cantidad del producto seleccionado.
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top text-end">
                            <button type="submit" class="btn btn-warning px-5 py-2 fw-bold shadow-sm">
                                <i class="fas fa-sync-alt me-1"></i> ACTUALIZAR VENTA
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const totalDisplay = document.getElementById('total_display');

    function calculateTotal() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption) {
            const price = parseFloat(selectedOption.getAttribute('data-price'));
            const quantity = parseInt(quantityInput.value) || 0;
            const total = price * quantity;
            totalDisplay.value = total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    }

    productSelect.addEventListener('change', calculateTotal);
    quantityInput.addEventListener('input', calculateTotal);
    
    // Ejecutar al cargar para asegurar que el total mostrado sea correcto
    window.onload = calculateTotal;
</script>
@endsection