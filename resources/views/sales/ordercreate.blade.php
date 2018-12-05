@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-10 col-md-offset-1">
                <div class="card-body">
                    <a href="{{ url('/'.$controller) }}" title="Atrás"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atrás</button></a>
                    <br />
                    <br />

                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">ORDEN DE ENTREGA</div>
                    <div class="panel-body">
                        
                        <br/>
                        
                        <form method="POST" action="{{ url('/'.$controller) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <div class="col-xs-1">
                                    {!! Form::label('customer','Cliente:'); !!}
                                </div>
                                <div class="col-xs-4">
                                    {!! Form::select('customer_id', $customers, null ,['class'=>'form-control', 'placeholder'=>'Seleccione el cliente']); !!}
                                </div>
                            
                                <div class="col-xs-1 col-md-offset-2">
                                    {!! Form::label('product','Número:'); !!}
                                </div>
                                <div class="col-xs-1">
                                    {!! Form::text('product', is_null($number) ? 1 : explode('-',$number)[0],['class'=>'form-control', 'readonly' => 'readonly']); !!}
                                </div>
                                <div class="col-xs-2">
                                    {!! Form::text('product', is_null($number) ? 1 : explode('-',$number)[1],['class'=>'form-control', 'readonly' => 'readonly']); !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-1 col-md-offset-7">
                                    {!! Form::label('date_of','Fecha:'); !!}
                                </div>
                                <div class="col-xs-2">
                                    {!! Form::text('datepicker_dateof', date('d/m/Y',time()),['id'=>'datepicker_dateof', 'class'=>'form-control datepicker']); !!}
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="col-xs-1">
                                    {!! Form::label('observation', 'Observ:'); !!}
                                </div>
                                <div class="col-xs-10">
                                    {!! Form::text('observation', null,['class'=>'form-control']);!!}
                                </div>
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.datepicker').datepicker({
            language: "es",
            autoclose: true,
            todayHighlight: true
        });

    </script>
@endsection
