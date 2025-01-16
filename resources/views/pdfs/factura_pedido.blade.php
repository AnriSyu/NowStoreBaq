<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: left; }
        h1, h2 { margin-bottom: 0; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <h3>Factura #{{ $pedido->id }}</h3>
    <h5>Id Pedido: {{$pedido->id}}</h5>
    <h5>Cliente: {{ $pedido->persona->nombres }} {{ $pedido->persona->apellidos }}</h5>
    <p>Fecha de Ingreso: {{ $pedido->fecha_ingreso }}</p>
    <p>Fecha de Entrega: {{ $pedido->fecha_entregado }}</p>
    <p>Fecha de Cancelación: {{ $pedido->fecha_cancelado }}</p>

    <h4>Artículos</h4>
    <table>
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Descuento</th>
            <th>Subtotal</th>
            <th>Mitad de precio y recargo</th>
        </tr>
        </thead>
        <tbody>
        @foreach (json_decode($pedido->carrito) as $item)
            <tr>
                <td>{{ $item->nombre }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>{{ $item->precio_venta_con_simbolo }}</td>
                <td>${{ number_format($item->precio_venta * $item->descuento / 100,2) }}</td>
                <td>${{ number_format($item->precio_venta * $item->cantidad, 2) }}</td>
                <td>${{ number_format($item->precio_mitad,2)}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h4>Resumen</h4>
    <table>
        <tbody>
        <tr>
            <td>Subtotal</td>
            <td>${{ number_format($pedido->total, 2) }}</td>
        </tr>
        <tr>
            <td>Descuento</td>
            <td>${{ number_format($pedido->descuento, 2) }}</td>
        </tr>
        <tr>
            <td class="total">Total</td>
            <td class="total">${{ number_format($pedido->total - $pedido->descuento, 2) }}</td>
        </tr>
        <tr>
            <td class="total">Total productos y recargo</td>
            <td class="total">${{ number_format($pedido->mitad_total, 2) }}</td>
        </tr>
        </tbody>
    </table>
</body>
</html>
