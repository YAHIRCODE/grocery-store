@extends('layouts.app')

@section('title', 'Nuevo Producto')
@section('page-title', 'Crear Nuevo Producto')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-box"></i> Formulario de Nuevo Producto
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <!-- Nombre -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">
                                Nombre del Producto <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Código de Barras -->
                        <div class="col-md-6 mb-3">
                            <label for="barcode" class="form-label">Código de Barras</label>
                            <input type="text" 
                                   class="form-control @error('barcode') is-invalid @enderror" 
                                   id="barcode" 
                                   name="barcode" 
                                   value="{{ old('barcode') }}">
                            @error('barcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Descripción -->
                    <div class="mb-3">
                        <label for="description" class="form-label">
                            Descripción <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3" 
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <!-- Categoría -->
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">
                                Categoría <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" 
                                    name="category_id" 
                                    required>
                                <option value="">Seleccionar categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Proveedor -->
                        <div class="col-md-6 mb-3">
                            <label for="supplier_id" class="form-label">Proveedor</label>
                            <select class="form-select @error('supplier_id') is-invalid @enderror" 
                                    id="supplier_id" 
                                    name="supplier_id">
                                <option value="">Sin proveedor</option>
                                @foreach(\App\Models\Supplier::all() as $supplier)
                                    <option value="{{ $supplier->id }}" 
                                            {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->company_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Precio de Compra -->
                        <div class="col-md-4 mb-3">
                            <label for="purchase_price" class="form-label">Precio de Compra</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" 
                                       class="form-control @error('purchase_price') is-invalid @enderror" 
                                       id="purchase_price" 
                                       name="purchase_price" 
                                       step="0.01" 
                                       min="0" 
                                       value="{{ old('purchase_price') }}">
                                @error('purchase_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Precio de Venta -->
                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">
                                Precio de Venta <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       id="price" 
                                       name="price" 
                                       step="0.01" 
                                       min="0.01" 
                                       value="{{ old('price') }}" 
                                       required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Stock Inicial -->
                        <div class="col-md-4 mb-3">
                            <label for="stock" class="form-label">Stock Inicial</label>
                            <input type="number" 
                                   class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" 
                                   name="stock" 
                                   min="0" 
                                   value="{{ old('stock', 0) }}">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Stock Mínimo -->
                        <div class="col-md-6 mb-3">
                            <label for="min_stock" class="form-label">Stock Mínimo</label>
                            <input type="number" 
                                   class="form-control @error('min_stock') is-invalid @enderror" 
                                   id="min_stock" 
                                   name="min_stock" 
                                   min="0" 
                                   value="{{ old('min_stock', 5) }}">
                            @error('min_stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Cantidad mínima antes de alerta de stock bajo
                            </small>
                        </div>
                    </div>
                    
                    <!-- Botones -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection