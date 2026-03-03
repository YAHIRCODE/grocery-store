@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('employees.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Volver al listado
        </a>
        <h1 class="h3 mb-0 text-gray-800 fw-bold mt-2">Registrar Nuevo Empleado</h1>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle me-2"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employees.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold text-primary mb-4"><i class="fas fa-id-card me-2"></i>Información Personal</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nombre(s)</label>
                            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" placeholder="Ej. Juan Carlos" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Apellido(s)</label>
                            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" placeholder="Ej. Pérez García" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="correo@ejemplo.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Teléfono</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="33 1234 5678" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Dirección Completa</label>
                            <input type="text" name="full_address" class="form-control @error('full_address') is-invalid @enderror" value="{{ old('full_address') }}" placeholder="Calle, Número, Colonia, Municipio" required>
                        </div>
                    </div>

                    <h5 class="fw-bold text-primary mb-4"><i class="fas fa-briefcase me-2"></i>Datos Laborales</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">ID Nómina</label>
                            <input type="text" name="payroll_id" class="form-control @error('payroll_id') is-invalid @enderror" value="{{ old('payroll_id') }}" placeholder="ID-00X" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Rol en el Sistema</label>
                            <select name="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                                <option value="" selected disabled>Seleccionar...</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Pago por Hora</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">$</span>
                                <input type="number" step="0.01" name="hourly_rate" class="form-control @error('hourly_rate') is-invalid @enderror" value="{{ old('hourly_rate') }}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Número de Tarjeta / Cuenta Depósito</label>
                            <input type="text" name="card_number" class="form-control @error('card_number') is-invalid @enderror" value="{{ old('card_number') }}" placeholder="Número de 16 dígitos" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 mb-4 bg-light">
                    <h6 class="fw-bold text-dark"><i class="fas fa-shield-alt me-2"></i>Cuenta de Usuario</h6>
                    <p class="small text-muted">Al guardar, se creará un acceso para este empleado usando su <strong>correo</strong> como usuario y la clave <strong>password</strong> por defecto.</p>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-3 shadow-sm fw-bold">
                    <i class="fas fa-check-circle me-2"></i> Finalizar Registro
                </button>
                <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary w-100 mt-2 border-0">Cancelar</a>
            </div>
        </div>
    </form>
</div>
@endsection