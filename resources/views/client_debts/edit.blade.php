@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('client_debts.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Descartar cambios
        </a>
        <h1 class="h3 mb-0 text-gray-800 fw-bold mt-2 text-warning">Editar Cobro Pendiente</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4">
                <form action="{{ route('client_debts.update', $debt->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Cliente</label>
                            <select name="client_id" class="form-select" required>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ $debt->client_id == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Fecha Inicio</label>
                            <input type="date" name="start_date" class="form-control" value="{{ $debt->start_date }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Fecha Vencimiento</label>
                            <input type="date" name="due_date" class="form-control" value="{{ $debt->due_date }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Monto a Cobrar</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" name="balance_due" class="form-control fw-bold" value="{{ $debt->balance_due }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Actualizar Estado</label>
                            <select name="status" class="form-select fw-bold">
                                <option value="pending" {{ $debt->status == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="paid" {{ $debt->status == 'paid' ? 'selected' : '' }}>Pagado</option>
                                <option value="overdue" {{ $debt->status == 'overdue' ? 'selected' : '' }}>Vencido</option>
                            </select>
                        </div>

                        <div class="col-12 mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-warning w-100 fw-bold shadow-sm py-2">
                                <i class="fas fa-sync-alt me-1"></i> Guardar Cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection