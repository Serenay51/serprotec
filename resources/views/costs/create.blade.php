@extends('layouts.app')

@section('content')
<h3>Nueva Lista de Costos</h3>
<form action="{{ route('costs.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow bg-white">
    @csrf
    <div class="mb-3">
        <label for="provider_id" class="form-label">Proveedor</label>
        <select name="provider_id" class="form-select" required>
            <option value="">Seleccionar...</option>
            @foreach($providers as $provider)
                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="file" class="form-label">Archivo (Excel o PDF)</label>
        <input type="file" name="file" class="form-control" required>
    </div>
    <button class="btn btn-success" style="background:#2A8D6C;">Subir</button>
    <a href="{{ route('costs.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
