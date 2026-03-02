@extends('layouts.app')

@section('title', 'Editar Cliente')
@section('page-title', 'Editar Cliente')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit"></i> Editar Cliente: {{ $client->first_name }} {{ $client->last_name }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('clients.update', $client->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <h6 class="text-muted">DATOS PERSONALES</h6>
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">
                                Nombre <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('first_name') is-invalid @enderror" 
                                   id="first_name" 
                                   name="first_name" 
                                   value="{{ old('first_name', $client->first_name) }}" 
                                   required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">
                                Apellido <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('last_name') is-invalid @enderror" 
                                   id="last_name" 
                                   name="last_name" 
                                   value="{{ old('last_name', $client->last_name) }}" 
                                   required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">
                                Teléfono <span class="text-danger">*</span>
                            </label>
                            <input type="tel" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $client->phone) }}" 
                                   required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $client->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <h6 class="text-muted mt-4">DIRECCIÓN</h6>
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="street_1" class="form-label">
                                Calle Principal <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('street_1') is-invalid @enderror" 
                                   id="street_1" 
                                   name="street_1" 
                                   value="{{ old('street_1', $client->street_1) }}" 
                                   required>
                            @error('street_1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="street_2" class="form-label">Calle Secundaria</label>
                            <input type="text" 
                                   class="form-control @error('street_2') is-invalid @enderror" 
                                   id="street_2" 
                                   name="street_2" 
                                   value="{{ old('street_2', $client->street_2) }}">
                            @error('street_2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="neighborhood" class="form-label">
                            Colonia/Barrio <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('neighborhood') is-invalid @enderror" 
                               id="neighborhood" 
                               name="neighborhood" 
                               value="{{ old('neighborhood', $client->neighborhood) }}" 
                               required>
                        @error('neighborhood')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="credit_limit" class="form-label">Límite de Crédito</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" 
                                       class="form-control @error('credit_limit') is-invalid @enderror" 
                                       id="credit_limit" 
                                       name="credit_limit" 
                                       step="0.01" 
                                       min="0" 
                                       value="{{ old('credit_limit', $client->credit_limit ?? 0) }}">
                                @error('credit_limit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection