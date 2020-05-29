<h1 style="text-align: center">Detalle de Cuenta Corriente</h1>
<h3 style="text-align: left">Cliente: {{ $operations[0]->customer->name }}</h3>
<table style="width: 100%; align-content: center; border: 1px solid black;" >
    <thead>
    <tr style="text-align: center">
        <th>Total</th>
        <th>Número</th>
        <th>Fecha</th>
        <th>Importe</th>
        <th>Pendiente</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody style="text-align: center; font-size: 10px">
    @php $pendiente = 0; @endphp
    @foreach($operations as $sale)
        @php

            if($sale->operation->status_id == 2)
            {
                $amount = $sale->payments[count($sale->payments)-1]->pivot->residue;
            }
            else
            {
                $amount = $sale->operation->amount;
            }

            $pendiente += ($sale->operation->operationtype_id == 15 || $sale->operation->operationtype_id == 16)?$amount*-1:$amount;
        @endphp
        <tr>
            <td>{{ $loop->iteration or $sale->id }}</td>
            <td>{{ $sale->operation->operationtype->groupoperationtype->abrev .'-' . $sale->operation->operationtype->letter . $sale->operation->FullNumber}}</td>
            <td>{{ $sale->operation->date_of }}</td>
            <td>{{ ($sale->operation->operationtype_id == 15 || $sale->operation->operationtype_id == 16)?$sale->operation->amount*-1:$sale->operation->amount }}</td>
            <td>{{ ($sale->operation->operationtype_id == 15 || $sale->operation->operationtype_id == 16)?$amount*-1:$amount }}</td>
            <td>{{ $sale->operation->status->status or '' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<table style="width: 100%; align-content: center; border: 1px solid black; margin-top: 3px" >
    <thead>
    <tr>
        <th>Total Pendiente: </th>
        <th>{{ $pendiente }}</th>
    </tr>
    </thead>
</table>

