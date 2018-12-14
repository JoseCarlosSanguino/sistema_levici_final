@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel-header"><h3>Editar {{$modelName}}: {{$trademark->trademark}}</h3> </div>
            <br />
            <a href="{{ url('/'.$controller) }}" title="Atrás"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atrás</button></a>
            <br />
            <br />
            <div class="col-md-10">
                <div class="panel panel-default col-md-8">
                    
                    
                    <div class="panel-body">
                        

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/'.$controller .'/'. $trademark->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            @include ('trademarks.form', ['formMode' => 'edit'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
