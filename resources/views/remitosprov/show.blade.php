@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header"><h3> {{ $remito->provider->name }}</h3></div>
                    <br/>
                    <div class="card-body">

                        <a href="{{ url('/'.$controller) }}" title="Atrás"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atrás</button></a>
                        <br>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Número</th><td>{{ $remito->operation->number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Fecha</th><td>{{ $remito->operation->date_of }}</td>
                                    </tr>
                                    <tr>
                                        <th> Proveedor </th>
                                        <td> {{ $remito->provider->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> Observaciones </th>
                                        <td> {{ $remito->operation->observation }} </td>
                                    </tr>
                                    <tr>
                                        <th> Orden de retiro </th>
                                        <td> {{ $remito->operation->order_number or '' }} </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            <h4>Cilindros</h4>
                            <div class="table-responsive">     
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Código itnerno</th>
                                            <th>Código externo</th>
                                            <th>Tipo</th>
                                            <th>Capacidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($remito->operation->cylinders as $cyl)
                                            <tr>
                                                <td>{{$cyl->code or ''}}</td>
                                                <td>{{$cyl->external_code or ''}}</td>
                                                <td>{{$cyl->cylindertype->cylindertype or ''}}</td>
                                                <td>{{$cyl->cylindertype->capacity or ''}}</td>
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
