@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>{{$title}}</h3></div>
                    <br/>
                    <div class="card-body">
                    

                        {!! Form::open(['method' => 'GET', 'url' => 'ctacte' , 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                        
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
                                        <th>#</th><th>Razón social</th><th>Cuit</th><th>Facturas adeudadas</th><th>Monto adeudado</th><th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($rows as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->name }}</td><td>{{ $item->cuit }}</td><td>{{ $item->cant }}</td><td>${{ $item->monto }}</td>
                                        <td>
                                            <a href="{{ url('/'.$controller.'/detallectacte/' . $item->customer_id) }}" title="Ver {{$modelName}}"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Ver</button></a>
                                            <a href="{{ url('/'.$controller.'/ctactepdf/' . $item->customer_id) }}" target="_blank" title="Ver {{$modelName}}"><button class="btn btn-info btn-sm"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button></a>

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
    </div>
@endsection