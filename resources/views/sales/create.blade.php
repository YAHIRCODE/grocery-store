@extends('layouts.app')

@section('title', 'Nueva Venta')
@section('page-title', 'Registrar Nueva Venta')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-shopping-cart"></i> Formulario de Nueva Venta
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('sales.store') }}" method="POST">
                    @csrf
                    
                    <!-- Producto -->
                    <div class="mb-3">
                        <label for="product_id" class="form-label">
                            Producto <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('product_id') is-invalid @enderror" 
                                id="product_id" 
                                name="product_id" 
                                required
                                onchange="updateProductInfo()">
                            <option value="">Seleccionar producto</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                        data-price="{{ $product->price }}"
                                        data-stock="{{ $product->stock }}"
                                        {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} - ${{ number_format($product->price, 2) }} (Stock: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="product-info" class="mt-2"></div>
                    </div>
                    
                    <div class="row">
                        <!-- Cantidad -->
                        <div class="col-md-6 mb-3">
                            <label for="quantity" class="form-label">
                                Cantidad <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('quantity') is-invalid @enderror" 
                                   id="quantity" 
                                   name="quantity" 
                                   min="1" 
                                   value="{{ old('quantity', 1) }}" 
                                   required
                                   onchange="calculateTotal()">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Cliente (Opcional) -->
                        <div class="col-md-6 mb-3">
                            <label for="client_id" class="form-label">Cliente (Opcional)</label>
                            <select class="form-select @error('client_id') is-invalid @enderror" 
                                    id="client_id" 
                                    name="client_id">
                                <option value="">Cliente general</option>
                                @foreach(\App\Models\Client::all() as $client)
                                    <option value="{{ $client->id }}" 
                                            {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->first_name }} {{ $client->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Método de Pago -->
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Método de Pago</label>
                        <select class="form-select @error('payment_method') is-invalid @enderror" 
                                id="payment_method" 
                                name="payment_method">
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Efectivo</option>
                            <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Tarjeta</option>
                            <option value="credit" {{ old('payment_method') == 'credit' ? 'selected' : '' }}>Crédito</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Total a Pagar (Solo lectura) -->
                    <div class="alert alert-info">
                        <h5>Total a Pagar: <span id="total-display">$0.00</span></h5>
                    </div>
                    
                    <!-- Botones -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-check"></i> Registrar Venta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateProductInfo() {
    const select = document.getElementById('product_id');
    const option = select.options[select.selectedIndex];
    const infoDiv = document.getElementById('product-info');
    
    if (option.value) {
        const price = option.dataset.price;
        const stock = option.dataset.stock;
        
        if (stock <= 0) {
            infoDiv.innerHTML = '<div class="alert alert-danger">¡Sin stock disponible!</div>';
        } else if (stock <= 5) {
            infoDiv.innerHTML = '<div class="alert alert-warning">Stock bajo: ' + stock + ' unidades disponibles</div>';
        } else {
            infoDiv.innerHTML = '<div class="alert alert-success">Stock disponible: ' + stock + ' unidades</div>';
        }
        
        calculateTotal();
    } else {
        infoDiv.innerHTML = '';
    }
}

function calculateTotal() {
    const select = document.getElementById('product_id');
    const quantity = document.getElementById('quantity').value;
    const option = select.options[select.selectedIndex];
    
    if (option.value && quantity) {
        const price = parseFloat(option.dataset.price);
        const total = price * quantity;
        document.getElementById('total-display').textContent = '$' + total.toFixed(2);
    }
}
</script>
@endpush
@endsection