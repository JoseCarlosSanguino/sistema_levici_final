@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="panel-header"><h3>Descontar {{$modelName}} {{$paycheck->number}}</h3> </div>
            <a href="{{ url('/'.$controller) }}" title="Atrás"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atrás</button></a>
            <br />
            <br />
            <div class="col-md-10">
                <div class="panel panel-default col-md-10">
                
                    <br />
                    <div class="panel-body">
            
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/'.$controller .'/'. $paycheck->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <br/>
                            <div class="form-group">
                                <div class="col-xs-2">
                                    {!! Form::label('bank','Banco:'); !!}
                                </div>
                                <div class="col-xs-4">
                                    {!! Form::text('bank_discount', '',['class'=>'form-control']); !!}
                                    {!! Form::hidden('status_id', 22 ,['class'=>'form-control']); !!}
                                    {!! Form::hidden('action','descontar' ,['class'=>'form-control']); !!}
                                </div>

                            </div>

                            @if(!isset($operationtype_id))
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" value="Actualizar">
                            </div>
                            @endif

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



                            