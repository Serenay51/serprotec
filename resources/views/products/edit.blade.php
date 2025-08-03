@extends('layouts.app')

@section('content')
<h3>Editar Producto</h3>
<form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow bg-white">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
    </div>

    <div class="mb-3">
        <label>Categoría</label>
        <select name="category" id="category" class="form-control" required>
            <option value="">Seleccionar categoría</option>
            <option value="extintores" {{ $product->category == 'extintores' ? 'selected' : '' }}>Extintores</option>
            <option value="carteleria" {{ $product->category == 'carteleria' ? 'selected' : '' }}>Cartelería</option>
            <option value="indumentaria" {{ $product->category == 'indumentaria' ? 'selected' : '' }}>Indumentaria</option>
            <option value="equipos" {{ $product->category == 'equipos' ? 'selected' : '' }}>Equipos</option>
            <option value="herramientas" {{ $product->category == 'herramientas' ? 'selected' : '' }}>Herramientas</option>
            <option value="otros" {{ $product->category == 'otros' ? 'selected' : '' }}>Otros</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Descripción</label>
        <textarea name="description" class="form-control">{{ $product->description }}</textarea>
    </div>

    <div class="mb-3">
        <label>Precio</label>
        <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}" required>
    </div>

    <div class="mb-3">
        <label>Stock</label>
        <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
    </div>

    <div class="mb-3">
        <label>Imagen</label>
        @if($product->image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $product->image) }}" alt="Imagen del producto" style="max-width: 150px;">
            </div>
        @endif
        <input type="file" name="image" class="form-control" accept="image/*">
        <small class="text-muted">Dejar vacío para mantener la imagen actual.</small>
    </div>

    <button class="btn btn-success" style="background:#2A8D6C;">Actualizar</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
