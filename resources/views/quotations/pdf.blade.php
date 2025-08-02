<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        margin: 30px 40px;
        color: #000;
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        border-bottom: 1px solid #0a6e4e;
        padding-bottom: 5px;
    }
    .header-left {
        font-weight: bold;
        font-size: 18px;
        color: #0a6e4e;
    }
    .header-right {
        font-size: 12px;
        text-align: right;
        font-weight: 600;
    }
    .logo {
        width: 120px;
        height: auto;
    }
    .title {
        text-align: center;
        font-weight: bold;
        font-size: 16px;
        margin: 15px 0 2px 0;
    }
    .subtitle {
        text-align: center;
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 15px;
        text-transform: uppercase;
    }
    .intro {
        font-size: 12px;
        margin-bottom: 15px;
        line-height: 1.3;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }
    table, th, td {
        border: 1px solid #999;
    }
    th, td {
        padding: 8px;
        vertical-align: middle;
    }
    th {
        background-color: #f2f2f2;
        font-weight: 700;
        text-align: center;
    }
    td:nth-child(2) {
        width: 55%;
    }
    td:nth-child(1), td:nth-child(3), td:nth-child(4) {
        width: 15%;
        text-align: right;
    }
    .total {
        text-align: right;
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 30px;
    }
    .note {
        font-size: 11px;
        line-height: 1.3;
        margin-bottom: 15px;
    }
    .note ul {
        margin: 5px 0 10px 20px;
    }
    .note ul li {
        margin-bottom: 4px;
    }
    .validity {
        font-size: 11px;
        color: #d90000;
        font-weight: bold;
        margin-bottom: 30px;
    }
    .signature {
        text-align: right;
        margin-top: 50px;
        font-size: 12px;
        font-weight: 600;
        font-family: 'DejaVu Sans', sans-serif;
    }
    .signature .name {
        font-weight: bold;
        margin-bottom: 2px;
    }
    .signature .mat {
        font-size: 10px;
        color: #000000;
    }
    .footer {
        position: fixed;
        bottom: 20px;
        left: 40px;
        right: 40px;
        font-size: 12px;
        text-align: center;
        color: #0a6e4e;
        border-top: 1px solid #0a6e4e;
        padding-top: 5px;
        font-weight: 700;
    }
</style>
</head>
<body>

<div class="header">
    <div class="header-left">
        <img src="{{ public_path('images/logo.png') }}" alt="SER PROTEC" class="logo"><br>
    </div>
    <div class="header-right">
        <div><strong>Presupuesto: {{ $quotation->number }}</strong></div>
        <div>Fecha: {{ $quotation->date->format('d/m/Y') }}</div>
    </div>
</div>

<div class="subtitle"> {{ $quotation->client->name }} </div>

<p class="intro text-bold">
    De acuerdo a lo solicitado ponemos a vuestra consideración el siguiente presupuesto.
</p>

<table class="table table-bordered bg-white shadow-sm">
    <thead>
        <tr>
            <th>Cantidad</th>
            <th>Descripción</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($quotation->items as $item)
        <tr>
            <td style="text-align:center;">{{ $item->quantity }}</td>
            <td>{{ $item->product->name }}<br><small>{{ $item->product->description ?? '' }}</small></td>
            <td style="text-align:center;">${{ number_format($item->price, 2, ',', '.') }}</td>
            <td style="text-align:center;">${{ number_format($item->subtotal, 2, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="total">Total: $ {{ number_format($quotation->total, 2, ',', '.') }}</div>

<!--<div class="note">
    <strong>El servicio incluye SIN CARGO:</strong>
    <ul>
        <li>Marbete</li>
        <li>Extintor Sustituto</li>
        <li>Retiro y entrega del extintor de su puesto designado</li>
    </ul>
</div>-->

<div class="validity">
    Este presupuesto tiene una validez de 7 (siete) días corridos.
</div>

<div class="signature">
    <img src="{{ public_path('images/signature.png') }}" alt="Firma" style="width: 150px; height: auto; margin-bottom: 5px;">
    <div class="name">Lic. Jonatán Regalini</div>
    <div class="mat">Mat.: LHS-001853 PBA</div>
</div>

<div class="footer">
    SERPROTEC - SEGURIDAD DE VANGUARDIA
</div>

</body>
</html>
