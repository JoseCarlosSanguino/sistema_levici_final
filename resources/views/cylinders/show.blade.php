@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header"><h3> {{ $cylinder->cylinder }}</h3></div>
                    <br/>
                    <div class="card-body">

                        <a href="{{ url('/'.$controller) }}" title="Atrás"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atrás</button></a>
                        <a href="{{ url('/'.$controller.'/' . $cylinder->id . '/edit') }}" title="Editar"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>

                        <form method="POST" action="{{ url('/'.$controller . '/' . $cylinder->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm(&quot;Cofirmar eliminación?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $cylinder->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> Código </th>
                                        <td> {{ $cylinder->code }} </td>
                                    </tr>
                                    <tr>
                                        <th> Código externo </th>
                                        <td> {{ $cylinder->external_code }} </td>
                                    </tr>
                                    <tr>
                                        <th> Observaciones </th>
                                        <td> {{ $cylinder->observation }} </td>
                                    </tr>
                                    <tr>
                                        <th> Tipo </th>
                                        <td> {{ $cylinder->cylindertype->cylindertype or '' }} </td>
                                    </tr>
                                    <tr>
                                        <th> Capacidad </th>
                                        <td> {{ $cylinder->cylindertype->capacity or '' }} </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            <h4>Movimientos</h4>
                            <div class="table-responsive">     
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Movimiento</th>
                                            <th>Cliente / Proveedor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cylinder->moves as $move)
                                            <tr>
                                                <td>{{$move->date_of}}</td>
                                                <td>{{$move->movetype->movetype}}</td>
                                                <td>{{$move->customer->name or $move->provider->name}}</td>
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
