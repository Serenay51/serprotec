@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Clientes</h3>
    <div>
        <a href="{{ route('clients.create') }}" class="btn btn-success" style="background:#2A8D6C;">+ Nuevo Cliente</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Formulario de importación -->
<div class="card p-3 mb-3 shadow-sm">
    <form action="{{ route('clients.import') }}" method="POST" enctype="multipart/form-data" class="d-flex">
        @csrf
        <input type="file" name="file" class="form-control me-2" required>
        <button class="btn btn-primary">Importar Excel</button>
    </form>
    <small class="text-muted mt-2">Formato: columnas (name, email, phone, address, cuit)</small>
</div>

<table class="table table-bordered bg-white shadow-sm">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>CUIT</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($clients as $client)
        <tr>
            <td>{{ $client->id }}</td>
            <td>{{ $client->name }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ $client->phone }}</td>
            <td>{{ $client->cuit }}</td>
            <td>
                <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-primary">Editar</a>
                <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Eliminar</button>
                </form>
                <a href="https://api.whatsapp.com/send?phone={{ $client->phone }}" class="btn btn-sm btn-success" target="_blank">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center">No hay clientes cargados.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $clients->links() }}
@endsection
