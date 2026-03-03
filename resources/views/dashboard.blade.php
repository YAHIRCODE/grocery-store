@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Vista General</h1>
        <div>
            @if(Auth::user()->role === 'Administrador')
                <a href="{{ route('pdf.ventas.diarias') }}" class="btn btn-sm btn-outline-danger shadow-sm me-2">
                    <i class="fas fa-file-pdf me-1"></i> Reporte Diario
                </a>
            @endif
            @if(Auth::user()->canManageSales())
                <a href="{{ route('sales.create') }}" class="btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-cart-plus me-1"></i> Nueva Venta
                </a>
            @endif
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 border-start border-primary border-4 h-100">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                        <i class="fas fa-calendar-day text-primary fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small fw-bold text-uppercase">Ventas Hoy</p>
                        <h4 class="fw-bold mb-0">${{ number_format($ventasHoyTotal, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 border-start border-success border-4 h-100">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                        <i class="fas fa-receipt text-success fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small fw-bold text-uppercase">Tickets</p>
                        <h4 class="fw-bold mb-0">{{ $ventasHoy }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 border-start border-danger border-4 h-100">
                <div class="d-flex align-items-center">
                    <div class="bg-danger bg-opacity-10 p-3 rounded me-3">
                        <i class="fas fa-boxes text-danger fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small fw-bold text-uppercase">Stock Bajo</p>
                        <h4 class="fw-bold mb-0 text-danger">{{ $productosConBajoStock }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 border-start border-warning border-4 h-100">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                        <i class="fas fa-hand-holding-usd text-warning fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small fw-bold text-uppercase">Por Cobrar</p>
                        <h4 class="fw-bold mb-0">${{ number_format($deudasPendientes, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Rendimiento Semanal</h5>
                    @if(Auth::user()->role === 'Administrador')
                        <a href="{{ route('reportes.ventas') }}" class="btn btn-link btn-sm text-decoration-none p-0">Detalles <i class="fas fa-chevron-right ms-1"></i></a>
                    @endif
                </div>
                <div id="revenue-chart"></div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-4">Stock por Categoría</h5>
                <div id="stock-donut-chart"></div>
                <div class="mt-auto pt-3 border-top">
                    <div class="d-flex justify-content-between align-items-center small">
                        <span class="text-muted">Total Productos:</span>
                        <span class="fw-bold text-dark">{{ $totalProductos }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fas fa-history me-2 text-muted"></i>Últimas Ventas</h6>
            @if(Auth::user()->role === 'Administrador')
                <a href="{{ route('reportes.ventas') }}" class="btn btn-sm btn-light">Ver todas</a>
            @endif
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4">FOLIO</th>
                            <th>CLIENTE</th>
                            <th>TOTAL</th>
                            <th>VENDEDOR</th>
                            <th class="pe-4 text-end">FECHA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimasVentas as $venta)
                        <tr>
                            <td class="ps-4 fw-bold">#{{ str_pad($venta->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $venta->client->name ?? 'Público General' }}</td>
                            <td><span class="badge bg-success bg-opacity-10 text-success fw-bold p-2">${{ number_format($venta->total_price, 2) }}</span></td>
                            <td><small>{{ $venta->employee->first_name ?? 'Sistema' }}</small></td>
                            <td class="pe-4 text-end text-muted small">{{ $venta->created_at->format('H:i') }} ({{ $venta->created_at->diffForHumans() }})</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted italic">No hay actividad registrada el día de hoy.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfica de Ganancias vs Gastos
        var revenueOptions = {
            series: [{
                name: 'Ingresos',
                data: {!! json_encode($gananciasData) !!}
            }, {
                name: 'Gastos',
                data: {!! json_encode($gastosData) !!}
            }],
            chart: { height: 350, type: 'area', toolbar: { show: false }, zoom: { enabled: false } },
            colors: ['#0d6efd', '#fd7e14'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            fill: { type: 'gradient', gradient: { opacityFrom: 0.4, opacityTo: 0.1 } },
            xaxis: { categories: {!! json_encode($diasLabels) !!} },
            tooltip: { y: { formatter: (val) => "$ " + val.toLocaleString() } }
        };
        new ApexCharts(document.querySelector("#revenue-chart"), revenueOptions).render();

        // Gráfica de Stock (Dona)
        var stockOptions = {
            series: {!! json_encode($conteoProductos) !!},
            labels: {!! json_encode($labelsCategorias) !!},
            chart: { type: 'donut', height: 300 },
            colors: ['#0d6efd', '#198754', '#0dcaf0', '#ffc107', '#dc3545'],
            legend: { position: 'bottom' },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Inventario',
                                formatter: () => {{ $totalProductos }}
                            }
                        }
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#stock-donut-chart"), stockOptions).render();
    });
</script>
@endsection