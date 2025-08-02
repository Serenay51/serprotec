@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Venta #{{ $sale->number }}</h1>
    <p><strong>Cliente:</strong> {{ $sale->client->name }}</p>
    <p><strong>Teléfono:</strong> {{ $sale->client->phone }}</p>
    <p><strong>Email:</strong> {{ $sale->client->email }}</p>
    <p><strong>Dirección:</strong> {{ $sale->client->address }}</p>
    <br>
    <p><strong>Fecha:</strong> {{ $sale->date->format('d/m/Y') }}</p>
    <p><strong>Total:</strong> ${{ number_format($sale->total, 2) }}</p>

    <h3>Detalles</h3>
    <table class="table table-bordered bg-white shadow-sm">
        <thead class="table-light">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
                <th>Vencimiento</th>
            </tr>
        </thead>
        <tbody>
        @foreach($sale->saleItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>${{ number_format($item->subtotal, 2) }}</td>
                <td>
                    @if($item->product->category === 'extintores')
                        <span class="badge bg-warning text-black">Vencimiento: ({{ $sale->date->addYear()->format('d/m/Y') }})</span>
                    @elseif($item->product->category === 'indumentaria')
                        <span class="badge bg-warning text-black">Vencimiento: ({{ $sale->date->addMonths(6)->format('d/m/Y') }})</span>
                    @else
                        Sin vencimiento
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Volver a Ventas</a>
    </div>
@endsection