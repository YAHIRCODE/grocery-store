@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('clients.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Volver al listado
        </a>
        <h1 class="h3 mb-0 text-gray-800 fw-bold mt-2">Registrar Cliente</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4">
                <form action="{{ route('clients.store') }}" method="POST">
                    @csrf
                    <h5 class="fw-bold text-primary mb-4 border-bottom pb-2"><i class="fas fa-id-card me-2"></i>Información Personal</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nombre(s)</label>
                            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Apellido(s)</label>
                            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Teléfono</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                        </div>
                    </div>

                    <h5 class="fw-bold text-primary mb-4 border-bottom pb-2"><i class="fas fa-map-marker-alt me-2"></i>Domicilio</h5>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label small fw-bold">Calle y Número</label>
                            <input type="text" name="street_1" class="form-control @error('street_1') is-invalid @enderror" value="{{ old('street_1') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Colonia / Barrio</label>
                            <input type="text" name="neighborhood" class="form-control @error('neighborhood') is-invalid @enderror" value="{{ old('neighborhood') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Referencias adicionales (Opcional)</label>
                            <input type="text" name="street_2" class="form-control" value="{{ old('street_2') }}" placeholder="Entre calles, color de casa, etc.">
                        </div>
                    </div>

                    <div class="text-end mt-5">
                        <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Guardar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection