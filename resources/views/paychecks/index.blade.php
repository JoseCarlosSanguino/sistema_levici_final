@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>{{$title}}</h3></div>
                <br/>
                <div class="card-body">
                
                        
                    <a href="{{ url('/'. $controller . '/create') }}" class="btn btn-success btn-sm" title="Nuevo {{$modelName}}">
                        <i class="fa fa-plus" aria-hidden="true"></i> Nuevo 
                    </a>
                    <br/><br/>

                    {!! Form::open(['method' => 'GET', 'url' => $controller , 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                    
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                        <span class="input-group-btn">
                            <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search" aria-hidden="true">&nbsp;</i>
                            </button>
                        </span>
                    </div>
                    {!! Form::close() !!}
                
                    <br/>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th><th>Número</th><th>Monto</th><th>Banco</th><th>Tipo</th><th>Fecha de pago</th><th>Propietario</th><th>Estado</th></th><th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($paychecks as $item)
                                <tr>
                                    <td>{{ $loop->iteration or $item->id }}</td>
                                    <td>{{ $item->number }}</td>
                                    <td>{{ $item->amount}}</td>
                                    <td>{{ $item->bank->bank or '' }}</td>
                                    <td>{{ $item->type}}</td>
                                    <td>{{ $item->paymentdate }}</td>
                                    <td>{{ $item->owner_name or '' }}</td>
                                    <td>{{ $item->status->status}}</td>
                                    <td>
                                        <a href="{{ url('/'.$controller.'/' . $item->id) }}" title="Ver {{$modelName}}"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Ver</button></a>
                                        @if($item->status_id == 16)
                                        <a href="{{ url('/'.$controller.'/' . $item->id . '/edit') }}" title="Editar {{$modelName}}"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>

                                        <form method="POST" action="{{ url('/'.$controller.'' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm" title="Depositar {{$modelName}}" onclick="return confirm(&quot;Confirmar deposito del cheque?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Depositar</button>
                                        </form>
                                        @endif
                                        <!--
                                        <form method="POST" action="{{ url('/'.$controller.'' . '/' . $item->id) . '/cobrar' }}" accept-charset="UTF-8" style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm" title="Cobrar {{$modelName}}" onclick="return confirm(&quot;Confirmar cobro del cheque?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Cobrar</button>
                                        </form>
                                    -->
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $paychecks->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
@endsection