@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Presupuestos</h3>
    <a href="{{ route('quotations.create') }}" class="btn btn-success" style="background:#2A8D6C;">+ Nuevo</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered bg-white shadow-sm">
    <thead class="table-light">
        <tr>
            <th>N° Presupuesto</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($quotations as $q)
        <tr>
            <td>{{ $q->number }}</td>
            <td>{{ $q->client->name }}</td>
            <td>{{ $q->date->format('d/m/Y') }}</td>
            <td>${{ number_format($q->total,2) }}</td>
            <td>
                <a href="{{ route('quotations.pdf',$q) }}" class="btn btn-sm btn-primary">Descargar</a>
                <a href="{{ route('quotations.show', $q) }}" class="btn btn-sm btn-info">Ver</a>
                <form action="{{ route('quotations.destroy', $q) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $q->id }}, '{{ $q->number }}')">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center">No hay presupuestos.</td></tr>
        @endforelse
    </tbody>
</table>
{{ $quotations->links() }}
@endsection
