@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('client_debts.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Regresar al listado
        </a>
        <h1 class="h3 mb-0 text-gray-800 fw-bold mt-2">Registrar Deuda de Cliente</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4">
                <form action="{{ route('client_debts.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12 mb-2">
                            <label class="form-label small fw-bold">Cliente</label>
                            <select name="client_id" class="form-select @error('client_id') is-invalid @enderror" required>
                                <option value="" selected disabled>Buscar cliente...</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Fecha de Inicio</label>
                            <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Fecha de Vencimiento</label>
                            <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Monto Pendiente</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">$</span>
                                <input type="number" step="0.01" name="balance_due" class="form-control" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Estado del Crédito</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" selected>Pendiente</option>
                                <option value="paid">Pagado</option>
                                <option value="overdue">Vencido</option>
                            </select>
                        </div>

                        <div class="col-12 mt-4 pt-3 border-top text-end">
                            <button type="submit" class="btn btn-primary px-5 shadow-sm fw-bold">
                                <i class="fas fa-save me-1"></i> Registrar Deuda
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection