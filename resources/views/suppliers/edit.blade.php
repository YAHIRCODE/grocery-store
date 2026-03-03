@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('suppliers.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Cancelar
        </a>
        <h1 class="h3 mb-0 text-gray-800 fw-bold mt-2">Editar Proveedor</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4">
                <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="mb-4 text-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block text-warning mb-2">
                            <i class="fas fa-edit fa-2x"></i>
                        </div>
                        <p class="text-muted small">Editando: <strong>{{ $supplier->company_name }}</strong></p>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Nombre de la Empresa</label>
                        <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name', $supplier->company_name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Nombre del Contacto</label>
                        <input type="text" name="contact_name" class="form-control @error('contact_name') is-invalid @enderror" value="{{ old('contact_name', $supplier->contact_name) }}" required>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Teléfono</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $supplier->phone) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $supplier->email) }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning w-100 py-2 fw-bold shadow-sm">
                        <i class="fas fa-sync-alt me-1"></i> Actualizar Información
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection