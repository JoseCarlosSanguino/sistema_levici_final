<h1 style="text-align: center">Detalle de Compra</h1>
<h3 style="text-align: right">Número de Compra:  {{ $purchase->id }}</h3>
<h3 style="text-align: right">Fecha de Compra:  {{ $purchase->operation->date_of }}</h3>
<h3 style="text-align: left">Proveedor: {{ $purchase->provider->name }}</h3>
<table style="width: 100%; align-content: center; border: 1px solid black;" >
    <thead>
    <tr style="text-align: center">
        <th>Código</th>
        <th>Producto</th>
        <th>Precio</th>
        <th>Cantidad</th>
    </tr>
    </thead>
    <tbody style="text-align: center">
    @foreach($purchase->operation->products as $prod)
        <tr>
            <td>{{ $prod->code }}</td>
            <td>{{ $prod->product }}</td>
            <td>{{ $prod->pivot->price }}</td>
            <td>{{ $prod->pivot->quantity }}</td>
        </tr>

        @endforeach
    </tbody>
    </table>
