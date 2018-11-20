@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{$title}}</div>
                <div class="card-body">
                    <a href="{{ url('/'. $controller . '/create') }}" class="btn btn-success btn-sm" title="Nuevo {{$modelName}}">
                        <i class="fa fa-plus" aria-hidden="true"></i> Nuevo 
                    </a>

                    {!! Form::open(['method' => 'GET', 'url' => '/index', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                        <span class="input-group-append">
                            <button class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                    {!! Form::close() !!}
                    <br/>
                    <br/>

                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>#</th>%%formHeadingHtml%%<th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($providers as $item)
                                <tr>
                                    <td>{{ $loop->iteration or $item->id }}</td>
                                    %%formBodyHtml%%
                                    <td>
                                        <a href="{{ url('/'.$controller . '/' . $item->id ) }}" title="Ver {{$modelName}}"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                        <a href="{{ url('/'.$controller . '/' . $item->id . '/edit') }}" title="Editar {{$modelName}}"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                        {!! Form::open([
                                            'method' => 'DELETE',
                                            'url' => ['/' . $controller , $item->id],
                                            'style' => 'display:inline'
                                        ]) !!}
                                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                                                    'type' => 'submit',
                                                    'class' => 'btn btn-danger btn-sm',
                                                    'title' => 'Borrar ' .$modelName,
                                                    'onclick'=>'return confirm("Seguro desea eliminar?")'
                                            )) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $providers->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
@endsection