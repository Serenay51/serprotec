@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Proveedores</h3>
    <a href="{{ route('providers.create') }}" class="btn btn-success" style="background:#2A8D6C;"><i class="fa fa-truck"></i> Nuevo Proveedor</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered bg-white shadow-sm">
    <thead class="table-light text-center">
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>CUIT</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @forelse($providers as $p)
        <tr>
            <td>{{ $p->name }}</td>
            <td>{{ $p->email }}</td>
            <td>{{ $p->phone }}</td>
            <td>{{ $p->address }}</td>
            <td>{{ $p->cuit }}</td>
            <td>
                <a href="{{ route('providers.edit', $p) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                <form action="{{ route('providers.destroy', $p) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar proveedor?')"><i class="fa fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center">No hay proveedores cargados.</td></tr>
        @endforelse
    </tbody>
</table>
{{ $providers->links() }}
@endsection
