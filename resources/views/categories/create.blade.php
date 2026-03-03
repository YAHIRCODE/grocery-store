@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('categories.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Regresar
        </a>
        <h1 class="h3 mb-0 text-gray-800 fw-bold mt-2">Crear Categoría</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-4">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Nombre de la Categoría</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Ej. Lácteos, Panadería..." required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Descripción (Opcional)</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Breve descripción del tipo de productos...">{{ old('description') }}</textarea>
                    </div>

                    <div class="text-end pt-3">
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Registrar Categoría
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection