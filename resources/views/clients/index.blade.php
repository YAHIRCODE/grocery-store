@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Gestión de Clientes</h1>
        <a href="{{ route('clients.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-user-plus me-1"></i> Nuevo Cliente
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
                            <th class="ps-4">CLIENTE</th>
                            <th>CONTACTO</th>
                            <th>DIRECCIÓN</th>
                            <th class="text-end pe-4">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3 text-primary text-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="fw-bold text-dark">{{ $client->first_name }} {{ $client->last_name }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="small"><i class="fas fa-envelope me-1 text-muted"></i> {{ $client->email }}</div>
                                <div class="small"><i class="fas fa-phone me-1 text-muted"></i> {{ $client->phone }}</div>
                            </td>
                            <td>
                                <span class="small text-muted text-truncate d-block" style="max-width: 250px;">
                                    {{ $client->street_1 }}, {{ $client->neighborhood }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('clients.show', $client->id) }}" class="btn btn-sm btn-white text-primary" title="Ver Detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm btn-white text-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-white text-danger" onclick="return confirm('¿Seguro que desea eliminar a este cliente?')" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">No hay clientes registrados en la base de datos.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection