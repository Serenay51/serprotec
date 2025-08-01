@extends('layouts.app')

@section('content')
<h3>Editar Cliente</h3>
<form action="{{ route('clients.update', $client) }}" method="POST" class="card p-4 shadow bg-white">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Nombre / Razón Social</label>
        <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $client->name) }}">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Correo</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $client->email) }}">
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Teléfono</label>
        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $client->phone) }}">
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Dirección</label>
        <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $client->address) }}">
    </div>
    <div class="mb-3">
        <label for="cuit" class="form-label">CUIT</label>
        <input type="text" name="cuit" id="cuit" class="form-control" value="{{ old('cuit', $client->cuit) }}">
    </div>
    <button class="btn btn-success" style="background:#2A8D6C;">Actualizar</button>
    <a href="{{ route('clients.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
