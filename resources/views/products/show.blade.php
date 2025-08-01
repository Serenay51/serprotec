@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $product->name }}</h1>
    <p><strong>Descripción:</strong> {{ $product->description }}</p>
    <p><strong>Precio:</strong> ${{ number_format($product->price, 2) }}</p>
    <p><strong>Stock:</strong> {{ $product->stock }}</p>

    <div class="mt-4">
        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">Editar</a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Volver a Productos</a>
    </div>
</div>

<!-- Toast de detalles del producto -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="productToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Detalles del producto</strong>
            <button type="button" class="btn-close btn-close-white ms-2 mb-1" data-bs-dismiss="toast" aria-label="Cerrar"></button>
        </div>
        <div class="toast-body">
            <ul class="mb-0">
                <li><strong>Nombre:</strong> {{ $product->name }}</li>
                <li><strong>Descripción:</strong> {{ $product->description }}</li>
                <li><strong>Precio:</strong> ${{ number_format($product->price, 2) }}</li>
                <li><strong>Stock:</strong> {{ $product->stock }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    window.addEventListener('DOMContentLoaded', function () {
        var toastEl = document.getElementById('productToast');
        var toast = new bootstrap.Toast(toastEl, { delay: 7000 });
        toast.show();
    });
</script>
@endsection