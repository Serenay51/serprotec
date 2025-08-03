@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Ventas</h3>
    <a href="{{ route('sales.create') }}" class="btn btn-success" style="background:#2A8D6C;"><i class="fa fa-shopping-cart"></i> Nueva Venta</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="GET" action="{{ route('sales.index') }}" class="mb-4">
    <div class="row g-2 align-items-end">
        <div class="col-md-4">
            <label for="search" class="form-label">Cliente o Número</label>
            <input
                type="text"
                name="search"
                id="search"
                value="{{ request('search') }}"
                class="form-control"
                placeholder="Buscar por cliente o número"
                autocomplete="off"
            />
        </div>

        <div class="col-md-3">
            <label for="date_from" class="form-label">Fecha desde</label>
            <input
                type="date"
                name="date_from"
                id="date_from"
                value="{{ request('date_from') }}"
                class="form-control"
            />
        </div>

        <div class="col-md-3">
            <label for="date_to" class="form-label">Fecha hasta</label>
            <input
                type="date"
                name="date_to"
                id="date_to"
                value="{{ request('date_to') }}"
                class="form-control"
            />
        </div>

        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-primary w-100" type="submit">
                <i class="fa fa-search"></i> Buscar
            </button>

            <a href="{{ route('sales.index') }}" class="btn btn-secondary w-100">
                <i class="fa fa-undo"></i> Resetear
            </a>
        </div>
    </div>
</form>


<table class="table table-bordered bg-white shadow-sm">
    <thead class="table-light text-center align-middle fw-bold">
        <tr>
            <th>N° Venta</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @forelse($sales as $s)
        <tr>
            <td>{{ $s->number }}</td>
            <td>{{ $s->client->name }}</td>
            <td>{{ $s->date->format('d/m/Y') }}</td>
            <td>${{ number_format($s->total,2) }}</td>
            <td>
                <a href="{{ route('sales.show', $s) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                <form action="{{ route('sales.destroy', $s) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta venta?')"><i class="fa fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="4" class="text-center">No hay ventas registradas.</td></tr>
        @endforelse
    </tbody>
</table>
{{ $sales->links() }}
@endsection
