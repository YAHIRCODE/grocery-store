@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('clients.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Cancelar
        </a>
        <h1 class="h3 mb-0 text-gray-800 fw-bold mt-2 text-warning">Editar Perfil de Cliente</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4">
                <form action="{{ route('clients.update', $client->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nombre</label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $client->first_name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Apellido</label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $client->last_name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $client->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Teléfono</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $client->phone) }}" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-bold">Calle y Número</label>
                            <input type="text" name="street_1" class="form-control" value="{{ old('street_1', $client->street_1) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Colonia</label>
                            <input type="text" name="neighborhood" class="form-control" value="{{ old('neighborhood', $client->neighborhood) }}" required>
                        </div>
                    </div>

                    <div class="text-end mt-5 pt-3 border-top">
                        <button type="submit" class="btn btn-warning px-5 fw-bold shadow-sm">
                            <i class="fas fa-sync-alt me-1"></i> Actualizar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection