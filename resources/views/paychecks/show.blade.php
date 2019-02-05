@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header"><h3> {{ $paycheck->paycheck }}</h3></div>
                    <br/>
                    <div class="card-body">

                        <a href="{{ url('/'.$controller) }}" title="Atrás"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atrás</button></a>
                        @if($paycheck->status_id == 16)
                        <a href="{{ url('/'.$controller.'/' . $paycheck->id . '/edit') }}" title="Editar"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>

                        <form method="POST" action="{{ url('/'.$controller.'' . '/' . $paycheck->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Depositar {{$modelName}}" onclick="return confirm(&quot;Confirmar deposito del cheque?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Depositar</button>
                        </form>
                        @endif
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Numero</th><td>{{ $paycheck->number }}</td>
                                    </tr>
                                    <tr>
                                        <th> Monto </th>
                                        <td> ${{ $paycheck->amount or ''}} </td>
                                    </tr>
                                    <tr>
                                        <th> Tipo </th>
                                        <td> {{ $paycheck->type  or ''}} </td>
                                    </tr>
                                    <tr>
                                        <th> Estado </th>
                                        <td> {{ $paycheck->status->status or '' }} </td>
                                    </tr>
                                    <tr>
                                        <th> Fecha de pago </th>
                                        <td> {{ $paycheck->paymentdate or '' }} </td>
                                    </tr>
                                    <tr>
                                        <th> Fecha de vencimiento </th>
                                        <td> {{ $paycheck->expiration or '' }} </td>
                                    </tr>
                                    <tr>
                                        <th> Banco </th>
                                        <td> {{ $paycheck->bank->banck or '' }} </td>
                                    </tr>
                                    <tr>
                                        <th> Propietario </th>
                                        <td> {{ $paycheck->owner_name or '' }} {{ $paycheck->owner_cuit or ''}} </td> 
                                    </tr>
                                    <tr>
                                        <th> Observaciones </th>
                                        <td> {{ $paycheck->observation or  '' }} </td> 
                                    </tr>
                                    
                                    
                                </tbody>
                            </table>
                            
                            <h4>Movimientos</h4>
                            <div class="table-responsive">     
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Tipo de movimiento</th>
                                            <th>Movimiento</th>
                                            <th>Cliente / Proveedor</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($paycheck->operations as $operation)
                                            <tr>
                                                <td>{{$operation->date_of  or ''}}</td>
                                                <td>{{$operation->operationtype->operationtype or ''}}</td>
                                                <td>{{$operation->fullnumber or ''}}</td>
                                                @if($operation->operationtype_id == 19)
                                                    <td>{{$operation->observation}}</td>
                                                @else
                                                    <td>{{$operation->payment->customer->name  or $operation->payment->provider->name}}</td>
                                                @endif  
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>     
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
