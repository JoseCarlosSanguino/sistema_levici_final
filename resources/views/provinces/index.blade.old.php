@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <br />
                    @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <p>{{ \Session::get('success') }}</p>
                    </div><br />
                    @endif
                    <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Provincia</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    @foreach($provinces as $item)
                    @php
                        $date=date('Y-m-d', $item['date']);
                        @endphp
                    <tr>
                        <td>{{$item['id']}}</td>
                        <td>{{$item['province']}}</td>
                        
                        <td>
                            <a href="{{ url('/'.$controller.'/' . $item->id) }}" title="Ver {{$modelName}}"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Ver</button></a>
                            <a href="{{ url('/'.$controller.'/' . $item->id . '/edit') }}" title="Editar {{$modelName}}"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>

                            <form method="POST" action="{{ url('/'.$controller.'' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar {{$modelName}}" onclick="return confirm(&quot;Confirmar Eliminación?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</button>
                            </form>
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