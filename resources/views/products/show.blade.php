@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Card de detalles del producto -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-box-seam me-2"></i> {{ $product->name }}
            </h4>
            @if (($product->stock) < 5 && ($product->stock) > 0)
                <span class="badge bg-danger text-white fs-6">
                    Stock Crítico: {{ $product->stock }}
                </span>  
            @elseif (($product->stock) === 0)
                <span class="badge bg-dark text-white fs-6">
                    Sin Stock
                </span>
            @else
                <span class="badge bg-light text-dark fs-6">
                    Stock: {{ $product->stock }}
                </span>
            @endif
        </div>
        <div class="card-body">
            <p class="fs-5"><strong>Descripción:</strong> {{ $product->description }}</p>
            <p class="fs-5"><strong>Precio:</strong> 
                <span class="text-success fw-bold">${{ number_format($product->price, 2) }}</span>
            </p>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Imagen del producto" width="120">
            @else
                <span class="text-muted">Sin imagen</span>
            @endif
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square me-1"></i> Editar
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver a Productos
            </a>
        </div>
    </div>
</div>

@endsection
