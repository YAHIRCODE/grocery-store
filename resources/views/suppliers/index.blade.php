@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Proveedores</h1>
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-truck me-1"></i> Nuevo Proveedor
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4">EMPRESA</th>
                            <th>REPRESENTANTE</th>
                            <th>TELÉFONO</th>
                            <th>EMAIL</th>
                            <th class="text-end pe-4">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded me-3 text-primary">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <span class="fw-bold text-dark">{{ $supplier->company_name }}</span>
                                </div>
                            </td>
                            <td>{{ $supplier->contact_name }}</td>
                            <td>{{ $supplier->phone ?? 'N/A' }}</td>
                            <td>{{ $supplier->email ?? 'N/A' }}</td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-sm btn-white text-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-white text-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-white text-danger" onclick="return confirm('¿Eliminar proveedor?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No hay proveedores registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection