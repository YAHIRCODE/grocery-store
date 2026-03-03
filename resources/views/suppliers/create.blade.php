@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('suppliers.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Regresar
        </a>
        <h1 class="h3 mb-0 text-gray-800 fw-bold mt-2">Registrar Proveedor</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4">
                <form action="{{ route('suppliers.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Nombre de la Empresa</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-industry text-muted"></i></span>
                            <input type="text" name="company_name" class="form-control border-start-0 @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Nombre del Contacto / Vendedor</label>
                        <input type="text" name="contact_name" class="form-control @error('contact_name') is-invalid @enderror" value="{{ old('contact_name') }}" required>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Teléfono</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Guardar Proveedor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection