@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('employees.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Cancelar edición
        </a>
        <h1 class="h3 mb-0 text-gray-800 fw-bold mt-2 text-warning">Editar Perfil de Empleado</h1>
        <p class="text-muted">Modificando registro de: <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong></p>
    </div>

    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <ul class="nav nav-tabs card-header-tabs" id="editTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active fw-bold text-dark" id="personal-tab" data-bs-toggle="tab" href="#personal" role="tab">Datos Personales</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold text-dark" id="work-tab" data-bs-toggle="tab" href="#work" role="tab">Laboral y Pagos</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content" id="editTabContent">
                            <div class="tab-pane fade show active" id="personal" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Nombre(s)</label>
                                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $employee->first_name) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Apellido(s)</label>
                                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $employee->last_name) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Email (No recomendado cambiar)</label>
                                        <input type="email" name="email" class="form-control bg-light text-muted" value="{{ old('email', $employee->email) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Teléfono Móvil</label>
                                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $employee->phone) }}" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted">Domicilio</label>
                                        <textarea name="full_address" class="form-control" rows="2" required>{{ old('full_address', $employee->full_address) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="work" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">ID de Nómina (Payroll)</label>
                                        <input type="text" name="payroll_id" class="form-control" value="{{ old('payroll_id', $employee->payroll_id) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Asignar Nuevo Rol</label>
                                        <select name="role_id" class="form-select" required>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ $employee->role_id == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Sueldo por Hora</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" name="hourly_rate" class="form-control" value="{{ old('hourly_rate', $employee->hourly_rate) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Número de Cuenta/Tarjeta</label>
                                        <input type="text" name="card_number" class="form-control" value="{{ old('card_number', $employee->card_number) }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light border-0 p-4">
                        <button type="submit" class="btn btn-warning px-5 fw-bold shadow-sm">
                            <i class="fas fa-sync-alt me-1"></i> Actualizar Información
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm p-3 text-center mb-4">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-user-edit fa-2x text-warning"></i>
                    </div>
                    <h6 class="fw-bold mb-0">Estado: Activo</h6>
                    <p class="small text-muted mt-2">Registrado desde:<br>{{ $employee->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection