@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>{{$title}} de <b>{{$operations[0]->customer->name}}</b></h3></div>
                <br/>
                <div class="card-body">
                    <a href="{{ url('ctacte') }}" title="Atrás"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atrás</button></a>
                        
                    <br/>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th><th>Número</th><th>Fecha</th><th>Importe</th><th>Pendiente</th><th>Estado</th><th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
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


                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration or $sale->id }}</td>
                                    <td>{{ $sale->operation->operationtype->groupoperationtype->abrev .'-' . $sale->operation->operationtype->letter . $sale->operation->FullNumber}}</td>
                                    <td>{{ $sale->operation->date_of }}</td>
                                    <td>{{ ($sale->operation->operationtype_id == 15 || $sale->operation->operationtype_id == 16)?$sale->operation->amount*-1:$sale->operation->amount }}</td>
                                    <td>{{ ($sale->operation->operationtype_id == 15 || $sale->operation->operationtype_id == 16)?$amount*-1:$amount }}</td>
                                    <td>{{ $sale->operation->status->status or '' }}</td>
                                    <td>
                                        <a href="{{ url('/facturapdf/' . $sale->id) }}" target="_blank" title="Ver {{$modelName}}"><button class="btn btn-info btn-sm"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        
                    </div>


                </div>
            </div>
        </div>

    </div>
@endsection