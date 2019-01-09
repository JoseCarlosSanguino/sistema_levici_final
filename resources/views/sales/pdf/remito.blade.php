<html>
    <head>
        <style>
            .header{
                background:#eee;
                color:#444;
                border-bottom:1px solid #ddd;
                overflow: hidden;
                width: 100%;
                text-align: center;
            }

            .headerCenter{
                --border-style: solid;
                width: 150px;
                height: 40px;
                font-size: 25;
                font-weight: bold;
                margin-left: auto;
                margin-right: auto;
                display:inline-block;
            }

            .headerIzquierda{
                float:left;
            }
            .headerDerecha{
                float:right;
            }

            .client-detail{background:#ddd;padding:10px;}
            .client-detail th{text-align:left;}

            .items{border-spacing:0;}
            .items thead{background:#ddd;}
            .items tbody{background:#eee;}
            .items tfoot{background:#ddd;}
            .items th{padding:10px;}
            .items td{padding:10px;}

            h1 small{display:block;font-size:16px;color:#888;}

            table{width:100%;}
            .text-right{text-align:right;}
        </style>
    </head>
    <body>

    <div class="header">

        <div id="headerCenter" align="center" class="headerCenter">
            REMITO
        </div>
        <br>
        
        <div id="hedaerDerecha" align="right" class="headerDerecha">
            <table>
                <tr>
                    <th style="width:100px;">
                        Fecha:
                    </th>
                    <td>{{ $sale->operation->date_of }}</td>
                </tr>
                <tr>
                <th style="width:100px;">
                        Número:
                    </th>
                    <td>{{ $sale->operation->fullNumber }}</td>
                </tr>
            </table>
        </div>
        </br>
        <br>
        <br>
        <div style="">
            Documento no valido como factura
        </div>
        
    </div>
    <table class="client-detail">
        <tr>
            <th style="width:100px;">
                Cliente:
            </th>
            <td>{{ $sale->customer->name }}</td>
        </tr>
        <tr>
            <th>CUIT:</th>
            <td>{{ $sale->customer->cuit }}</td>
        </tr>
        <tr>
            <th>Dirección:</th>
            <td>{{ $sale->customer->address }}</td>
        </tr>
    </table>

    <hr />

    <table class="items">
        <thead>
            <tr>
                <th class="text-left" style="width:100px;">Código</th>
                <th class="text-left">Producto</th>
                <th class="text-right" style="width:100px;">Cantidad</th>
                <th class="text-right" style="width:100px;">P.U</th>
                <th class="text-right" style="width:100px;">Total</th>
            </tr>
        </thead>
        <tbody>
        @foreach($sale->operation->products as $p)
            <tr>
                <td class="text-left" style="width:100px;">{{$p->code}}</td>
                <td>{{$p->product}}</td>
                <td class="text-right">{{$p->pivot->quantity}}</td>
                <td class="text-right">$ {{number_format($p->pivot->price, 2)}}</td>
                <td class="text-right">$ {{number_format(($p->pivot->quantity * $p->pivot->price), 2)}}</td>
            </tr>
        @endforeach

        @foreach($sale->operation->cylinders as $c)
            <tr>
                <td class="text-left" style="width:100px;">Cilindro</td>
                <td>{{$c->cylindertype->cylindertype}} Código: {{$c->code}} Código externo: {{$c->external_code}}</td>
                <td class="text-right">1</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
    <!--
        <tr>
            <td colspan="4" class="text-right"><b>IVA</b></td>
            <td class="text-right">$ {{ number_format($sale->operation->amount, 2) }}</td>
        </tr>
        <tr>
            <td colspan="4" class="text-right"><b>Sub Total</b></td>
            <td class="text-right">$ {{ number_format($sale->operation->amount, 2) }}</td>
        </tr>
    -->
        <tr>
            <td colspan="4" class="text-right"><b>Total</b></td>
            <td class="text-right">$ {{ number_format($sale->operation->amount, 2) }}</td>
        </tr>
        </tfoot>
    </table>
    </body>
</html>