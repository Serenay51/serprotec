@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Ventas</h3>
    <a href="{{ route('sales.create') }}" class="btn btn-success" style="background:#2A8D6C;"><i class="fa fa-shopping-cart"></i> Nueva Venta</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

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
