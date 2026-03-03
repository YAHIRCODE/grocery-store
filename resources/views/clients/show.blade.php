@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <a href="{{ route('clients.index') }}" class="text-decoration-none small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm btn-outline-warning">
            <i class="fas fa-user-edit me-1"></i> Editar Perfil
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 text-center">
                <div class="bg-primary bg-opacity-10 p-4 rounded-circle d-inline-block mx-auto mb-3 text-primary">
                    <i class="fas fa-user fa-4x"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $client->first_name }} {{ $client->last_name }}</h4>
                <p class="text-muted small">ID Cliente: #CLI-{{ str_pad($client->id, 4, '0', STR_PAD_LEFT) }}</p>
                <hr>
                <div class="text-start">
                    <div class="mb-3">
                        <small class="text-muted d-block">Contacto:</small>
                        <span class="fw-bold small"><i class="fas fa-phone me-2"></i>{{ $client->phone }}</span><br>
                        <span class="fw-bold small"><i class="fas fa-envelope me-2"></i>{{ $client->email }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Ubicación:</small>
                        <span class="fw-bold small">{{ $client->street_1 }}</span><br>
                        <span class="small">{{ $client->neighborhood }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-hand-holding-usd me-2 text-warning"></i>Historial de Crédito</h5>
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead class="text-muted small">
                            <tr>
                                <th>FECHA</th>
                                <th>MONTO</th>
                                <th>ESTADO</th>
                                <th>TOTAL PAGADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($client->debts as $debt)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($debt->start_date)->format('d/m/Y') }}</td>
                                <td class="fw-bold text-dark">${{ number_format($debt->balance_due, 2) }}</td>
                                <td>
                                    @php
                                        $color = $debt->status == 'paid' ? 'success' : ($debt->status == 'overdue' ? 'danger' : 'warning');
                                    @endphp
                                    <span class="badge rounded-pill bg-{{ $color }} bg-opacity-10 text-{{ $color }} px-3">
                                        {{ strtoupper($debt->status) }}
                                    </span>
                                </td>
                                <td>${{ $debt->status == 'paid' ? number_format($debt->balance_due, 2) : '0.00' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted small">Este cliente no tiene historial de deudas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection