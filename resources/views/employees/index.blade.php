@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Gestión de Empleados</h1>
        <a href="{{ route('employees.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-user-plus me-1"></i> Registrar Empleado
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4">ID NÓMINA</th>
                            <th>NOMBRE COMPLETO</th>
                            <th>ROL / PUESTO</th>
                            <th>CONTACTO</th>
                            <th class="text-end pe-4">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">{{ $employee->payroll_id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-2 rounded-circle me-3">
                                        <i class="fas fa-user text-muted"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                                        <small class="text-muted">Tarifa: ${{ number_format($employee->hourly_rate, 2) }}/hr</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-info bg-opacity-10 text-info px-3">
                                    {{ $employee->role->name ?? 'Sin Rol' }}
                                </span>
                            </td>
                            <td>
                                <div class="small"><i class="fas fa-envelope me-1 text-muted"></i> {{ $employee->email }}</div>
                                <div class="small"><i class="fas fa-phone me-1 text-muted"></i> {{ $employee->phone }}</div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-white text-primary" title="Ver Detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-white text-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-white text-danger" title="Eliminar" 
                                            onclick="confirmDelete({{ $employee->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $employee->id }}" action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No hay empleados registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este empleado? Esto también podría eliminar su cuenta de usuario.')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endsection