@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('employees.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Volver al listado
        </a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4 h-100">
                <div class="bg-light-primary rounded-circle p-4 d-inline-block mx-auto mb-3">
                    <i class="fas fa-user-tie fa-4x text-primary"></i>
                </div>
                <h4 class="fw-bold mb-0">{{ $employee->first_name }} {{ $employee->last_name }}</h4>
                <p class="badge bg-primary bg-opacity-10 text-primary px-4 mt-2">{{ $employee->role->name }}</p>
                <hr>
                <div class="text-start mt-3">
                    <label class="text-muted small d-block">ID Nómina</label>
                    <p class="fw-bold">{{ $employee->payroll_id }}</p>
                    
                    <label class="text-muted small d-block">Sueldo Base</label>
                    <p class="fw-bold text-success">${{ number_format($employee->hourly_rate, 2) }} <small class="text-muted">/ hora</small></p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-4">Información Detallada</h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Correo Electrónico</label>
                        <p class="fw-bold border-bottom pb-2">{{ $employee->email }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Teléfono de Contacto</label>
                        <p class="fw-bold border-bottom pb-2">{{ $employee->phone }}</p>
                    </div>
                    <div class="col-12">
                        <label class="text-muted small d-block">Dirección de Vivienda</label>
                        <p class="fw-bold border-bottom pb-2">{{ $employee->full_address }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Método de Pago (Tarjeta)</label>
                        <p class="fw-bold border-bottom pb-2">**** **** **** {{ substr($employee->card_number, -4) }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Fecha de Registro</label>
                        <p class="fw-bold border-bottom pb-2">{{ $employee->created_at->format('d \d\e M, Y') }}</p>
                    </div>
                </div>
                
                <div class="mt-auto pt-4 d-flex">
                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning px-4 shadow-sm me-2">
                        <i class="fas fa-edit me-1"></i> Editar Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-light-primary { background-color: #f0f3ff; width: 120px; height: 120px; display: flex; align-items: center; justify-content: center; }
</style>
@endsection