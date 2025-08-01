@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Presupuesto #{{ $quotation->number }}</h1>
    <p><strong>Cliente:</strong> {{ $quotation->client->name }}</p>
    <p><strong>Fecha:</strong> {{ $quotation->date }}</p>
    <p><strong>Total:</strong> ${{ number_format($quotation->total, 2) }}</p>

    <h3>Detalles</h3>
    <table class="table table-bordered bg-white shadow-sm">
        <thead class="table-light">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>${{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <a href="{{ route('quotations.index') }}" class="btn btn-secondary">Volver a Presupuestos</a>
    </div>
</div>
@endsection