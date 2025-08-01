@extends('layouts.app')

@section('content')
<h3>Nuevo Producto</h3>
<form action="{{ route('products.store') }}" method="POST" class="card p-4 shadow bg-white">
    @csrf
    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Categoría</label>
        <select name="category" id="category" class="form-control" required>
            <option value="">Seleccionar categoría</option>
            <option value="extintores">Extintores</option>
            <option value="carteleria">Cartelería</option>
            <option value="indumentaria">Indumentaria</option>
            <option value="equipos">Equipos</option>
            <option value="herramientas">Herramientas</option>
            <option value="otros">Otros</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Descripción</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>Precio</label>
        <input type="number" step="0.01" name="price" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Stock</label>
        <input type="number" name="stock" class="form-control" required>
    </div>
    <button class="btn btn-success" style="background:#2A8D6C;">Guardar</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
