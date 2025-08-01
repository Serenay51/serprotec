@extends('layouts.app')

@section('content')
<h3>Nuevo Proveedor</h3>
<form action="{{ route('providers.store') }}" method="POST" class="card p-4 shadow bg-white">
    @csrf
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Teléfono</label>
        <input type="text" name="phone" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Dirección</label>
        <input type="text" name="address" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">CUIT</label>
        <input type="text" name="cuit" class="form-control">
    </div>
    <button class="btn btn-success" style="background:#2A8D6C;">Guardar</button>
    <a href="{{ route('providers.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
