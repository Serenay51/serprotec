@extends('layouts.app')

@section('content')

<div class="container">
    <!-- Mensaje de bienvenida -->
    <div class="alert alert-info" role="alert"
        style="text-align: center; font-size: 1.2em; margin-top: 20px;">
        Bienvenido al panel de control. Aquí puedes ver un resumen de las ventas, clientes y productos.
    </div>
    <!-- Resumen de ventas -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm text-center p-3">
                <h5 class="text-muted">Ventas del mes</h5>
                <h2 class="text-success">${{ number_format($monthSales, 2) }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h5 class="text-muted">Balance del mes</h5>
                <h2 class="text-success">${{ number_format($monthSales - $monthCosts, 2) }}</h2>
            </div>
        </div>

        <div class="mt-5 col-md-4">
            <canvas id="salesChart" width="200" height="200"></canvas>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx = document.getElementById('salesChart').getContext('2d');
                var salesChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Mes anterior', 'Mes actual'],
                        datasets: [
                            {
                                label: 'Ventas',
                                data: [{{ $lastMonthSales }}, {{ $monthSales }}],
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(75, 192, 192, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(75, 192, 192, 1)'
                                ],
                                borderWidth: 1
                            },
                            {
                                label: 'Clientes',
                                data: [{{ $lastMonthClients }}, {{ $monthClients }}],
                                backgroundColor: [
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        }
                    }
                });
            </script>
        </div>

    <!-- Total Clientes -->
    <div class="mt-5 col-md-2">
        <div class="card shadow-sm text-center p-3">
            <h5 class="text-muted">Clientes</h5>
            <h2>{{ $totalClients }}</h2>
        </div>
    </div>

    <!-- Total Productos -->
    <div class="mt-5 col-md-2">
        <div class="card shadow-sm text-center p-3">
            <h5 class="text-muted">Productos</h5>
            <h2>{{ $totalProducts }}</h2>
        </div>
    </div>

    <!-- Total Proveedores -->
    <div class="mt-5 col-md-2">
        <div class="card shadow-sm text-center p-3">
            <h5 class="text-muted">Proveedores</h5>
            <h2>{{ $totalProviders }}</h2>
        </div>
    </div>
</div>


<!-- Ventas recientes -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">Ventas recientes</h5>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th>N° Venta</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentSales as $sale)
                <tr>
                    <td>{{ $sale->number }}</td>
                    <td>{{ $sale->client->name }}</td>
                    <td>{{ $sale->date->format('d/m/Y') }}</td>
                    <td>${{ number_format($sale->total, 2) }}</td>
                    <td>
                        <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-primary">Ver</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center p-3">No hay ventas recientes.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Vencimientos del día -->

<div class="card shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0">Vencimientos de hoy</h5>
    </div>
    <div class="card-body">
        @if($vencimientos->isEmpty())
            <p class="text-muted mb-0">No hay vencimientos.</p>
        @else
            <ul class="list-group">
                @foreach($vencimientos as $prod)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold">{{ $prod->name }}</span>
                            <br>
                            <small class="text-muted">Venta: {{ $prod->sale_number }}</small>
                            <br>
                            <small class="text-muted">Cliente: {{ $prod->client_name }}</small>
                            <br>
                            <small class="text-muted">Teléfono: {{ $prod->client_phone }}</small>
                            <br>
                        </div>
                        
                        <div>
                            <a href="{{ route('sales.show', $prod->sale_id) }}" class="btn btn-sm btn-primary">
                                Ver venta
                            </a>
                            <a href="https://api.whatsapp.com/send?phone={{ $prod->client_phone }}" class="btn btn-sm btn-success" target="_blank">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
