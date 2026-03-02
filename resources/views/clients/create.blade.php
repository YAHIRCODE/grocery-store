@extends('layouts.app')

@section('title', 'Nuevo Cliente')
@section('page-title', 'Registrar Nuevo Cliente')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-plus"></i> Formulario de Nuevo Cliente
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('clients.store') }}" method="POST" id="clientForm">
                    @csrf
                    
                    <!-- DATOS PERSONALES -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted border-bottom pb-2 mb-3">
                                <i class="fas fa-user"></i> DATOS PERSONALES
                            </h6>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Nombre -->
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">
                                Nombre(s) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('first_name') is-invalid @enderror" 
                                       id="first_name" 
                                       name="first_name" 
                                       value="{{ old('first_name') }}" 
                                       placeholder="Ej: Juan"
                                       required 
                                       autofocus>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Apellido -->
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">
                                Apellido(s) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('last_name') is-invalid @enderror" 
                                       id="last_name" 
                                       name="last_name" 
                                       value="{{ old('last_name') }}" 
                                       placeholder="Ej: Pérez García"
                                       required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Teléfono -->
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">
                                Teléfono <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input type="tel" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}" 
                                       placeholder="Ej: 3312345678"
                                       pattern="[0-9]{10}"
                                       maxlength="10"
                                       required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">10 dígitos sin espacios</small>
                        </div>
                        
                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">
                                Email <small class="text-muted">(opcional)</small>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="cliente@ejemplo.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- DIRECCIÓN -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="text-muted border-bottom pb-2 mb-3">
                                <i class="fas fa-map-marker-alt"></i> DIRECCIÓN
                            </h6>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Calle Principal -->
                        <div class="col-md-6 mb-3">
                            <label for="street_1" class="form-label">
                                Calle Principal <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-road"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('street_1') is-invalid @enderror" 
                                       id="street_1" 
                                       name="street_1" 
                                       value="{{ old('street_1') }}" 
                                       placeholder="Ej: Av. Juárez #123"
                                       required>
                                @error('street_1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Calle Secundaria -->
                        <div class="col-md-6 mb-3">
                            <label for="street_2" class="form-label">
                                Calle Secundaria / Entre Calles <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-road"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('street_2') is-invalid @enderror" 
                                       id="street_2" 
                                       name="street_2" 
                                       value="{{ old('street_2') }}" 
                                       placeholder="Ej: Entre López Mateos y Hidalgo"
                                       required>
                                @error('street_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Colonia -->
                    <div class="mb-3">
                        <label for="neighborhood" class="form-label">
                            Colonia / Barrio <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-building"></i>
                            </span>
                            <input type="text" 
                                   class="form-control @error('neighborhood') is-invalid @enderror" 
                                   id="neighborhood" 
                                   name="neighborhood" 
                                   value="{{ old('neighborhood') }}" 
                                   placeholder="Ej: Centro, Americana, etc."
                                   required>
                            @error('neighborhood')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- CRÉDITO -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="text-muted border-bottom pb-2 mb-3">
                                <i class="fas fa-credit-card"></i> INFORMACIÓN DE CRÉDITO
                            </h6>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="credit_limit" class="form-label">
                                Límite de Crédito <small class="text-muted">(opcional)</small>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" 
                                       class="form-control @error('credit_limit') is-invalid @enderror" 
                                       id="credit_limit" 
                                       name="credit_limit" 
                                       step="0.01" 
                                       min="0" 
                                       value="{{ old('credit_limit', 0) }}"
                                       placeholder="0.00">
                                @error('credit_limit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                Monto máximo que puede deber el cliente. Si es 0, no se permite crédito.
                            </small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle"></i>
                                <strong>Nota:</strong> El cliente podrá comprar a crédito hasta el límite establecido.
                                La deuda actual será 0 al crear el cliente.
                            </div>
                        </div>
                    </div>
                    
                    <!-- BOTONES -->
                    <hr class="my-4">
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                        
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Guardar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Ayuda -->
        <div class="card mt-3">
            <div class="card-body bg-light">
                <h6 class="text-muted mb-2">
                    <i class="fas fa-question-circle"></i> Ayuda
                </h6>
                <ul class="mb-0 small">
                    <li>Los campos marcados con <span class="text-danger">*</span> son obligatorios</li>
                    <li>El teléfono debe tener exactamente 10 dígitos</li>
                    <li>El email es opcional pero recomendado para enviar recibos</li>
                    <li>El límite de crédito define cuánto puede deber el cliente</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Validación del teléfono en tiempo real
document.getElementById('phone').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});

// Previsualización del nombre completo
const firstName = document.getElementById('first_name');
const lastName = document.getElementById('last_name');

function updateFullName() {
    if (firstName.value || lastName.value) {
        console.log('Nombre completo:', firstName.value + ' ' + lastName.value);
    }
}

firstName.addEventListener('blur', updateFullName);
lastName.addEventListener('blur', updateFullName);
</script>
@endpush
@endsection