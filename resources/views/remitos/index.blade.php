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
                                    <th>#</th>
                                    <th>Número</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Importe</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($operations as $sale)
                                <tr>
                                    <td>{{ $itinerator->loop or $sale->id }}</td>
                                    <td>{{ $sale->operation->FullNumber or ''}}</td>
                                    <td>{{ $sale->operation->date_of }}</td>
                                    <td>{{ $sale->customer->name or '' }}</td>
                                    <td>{{ number_format($sale->operation->amount,2,",",".") }}</td>
                                    <td>{{ $sale->operation->status->status or '' }}</td>
                                    <td>
                                        @if($sale->operation->status_id != 27)
                                        <a href="{{ url('/remitopdf/' . $sale->id) }}" target="_blank" title="Imprimir {{$modelName}}"><button class="btn btn-info btn-sm"><i class="fa fa-print" aria-hidden="true"></i>Imprimir</button></a>
                                        @if($sale->operation->status_id == 14)
                                            <a href="{{ url('/facturar/' . $sale->id) }}" title="Facturar {{$modelName}}"><button class="btn btn-info btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Facturar</button></a>
                                                <a href="{{ url('/remito_anular/' . $sale->id) }}" title="Anular {{$modelName}}"><button class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i>Anular</button></a>
                                        @endif

                                            @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $operations->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
@endsection