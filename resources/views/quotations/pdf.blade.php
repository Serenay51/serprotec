<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
.header { display:flex; justify-content:space-between; }
.logo { width:150px; }
.table { width:100%; border-collapse:collapse; margin-top:20px;}
.table th, .table td { border:1px solid #ccc; padding:8px; }
.text-right { text-align:right; }
</style>
</head>
<body>
<div class="header">
    <div>
        <h2>SERPROTEC</h2>
        <p>Venta de Extintores y Seguridad Industrial</p>
    </div>
    <div>
        <strong>Presupuesto: {{ $quotation->number }}</strong><br>
        Fecha: {{ $quotation->date }}
    </div>
</div>
<hr>
<p><strong>Cliente:</strong> {{ $quotation->client->name }}<br>
<strong>Email:</strong> {{ $quotation->client->email }}<br>
<strong>Tel:</strong> {{ $quotation->client->phone }}</p>

<table class="table">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cant.</th>
            <th>Precio</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($quotation->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>${{ number_format($item->price,2) }}</td>
            <td>${{ number_format($item->subtotal,2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3 class="text-right">Total: ${{ number_format($quotation->total,2) }}</h3>
</body>
</html>
