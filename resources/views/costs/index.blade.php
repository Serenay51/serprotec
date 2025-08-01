@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Listas de Precios</h3>
    <a href="{{ route('costs.create') }}" class="btn btn-success" style="background:#2A8D6C;">+ Nueva Lista</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered bg-white shadow-sm">
    <thead class="table-light">
        <tr>
            <th>Proveedor</th>
            <th>Archivo</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($costs as $c)
        <tr>
            <td>{{ $c->provider->name }}</td>
            <td>{{ $c->filename }}</td>
            <td>{{ $c->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('costs.download', $c) }}" class="btn btn-sm btn-primary">Descargar</a>
                <form action="{{ route('costs.destroy', $c) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="4" class="text-center">No hay listas cargadas.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $costs->links() }}
@endsection
