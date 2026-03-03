@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4 text-muted small">
        <a href="{{ route('sales.index') }}" class="text-decoration-none text-muted">
            <i class="fas fa-arrow-left me-1"></i> Regresar al historial
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary py-3">
                    <h5 class="m-0 fw-bold text-white"><i class="fas fa-cart-arrow-down me-2"></i>Nueva Operación de Venta</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Buscar Producto (Solo con stock)</label>
                                <select name="product_id" id="product_id" class="form-select form-select-lg @error('product_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>Seleccione un producto...</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                                            {{ $product->name }} — ${{ number_format($product->price, 2) }} (Disp: {{ $product->stock }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Cantidad a Vender</label>
                                <input type="number" name="quantity" id="quantity" class="form-control form-control-lg" value="1" min="1" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-primary">Total a Cobrar</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white fw-bold">$</span>
                                    <input type="text" id="total_display" class="form-control form-control-lg fw-bold text-primary bg-light" value="0.00" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 pt-3 border-top text-end">
                            <button type="submit" class="btn btn-success px-5 py-3 fw-bold shadow-sm rounded-pill">
                                <i class="fas fa-check-circle me-2"></i> COMPLETAR VENTA
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
        if (selectedOption && selectedOption.value) {
            const price = parseFloat(selectedOption.getAttribute('data-price'));
            const quantity = parseInt(quantityInput.value) || 0;
            const total = price * quantity;
            totalDisplay.value = total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    }

    productSelect.addEventListener('change', calculateTotal);
    quantityInput.addEventListener('input', calculateTotal);
</script>
@endsection