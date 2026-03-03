@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4 text-muted small">
        <a href="{{ route('categories.index') }}" class="text-decoration-none text-muted">
            <i class="fas fa-arrow-left me-1"></i> Cancelar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-warning bg-opacity-10 p-3 rounded me-3 text-warning">
                        <i class="fas fa-folder-plus fa-lg"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">Editar Categoría</h4>
                        <p class="text-muted small mb-0">{{ $category->name }}</p>
                    </div>
                </div>

                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Nombre</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Descripción</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-warning px-5 fw-bold shadow-sm text-dark">
                            <i class="fas fa-sync-alt me-1"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection