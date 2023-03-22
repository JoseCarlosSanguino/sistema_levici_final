@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>{{$title}}</h3></div>
                <br/>
                <div class="card-body">

                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{!! \Session::get('flash_message') !!}</li>
                            </ul>
                        </div>
                    @endif
                        
                    <br/>

                    {!! Form::open(['id' => 'searchForm', 'method' => 'GET', 'url' => "increase" , 'class' => 'form-horizontal my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                    
                        <div class="form-group">
                            <div class="col-xs-1">
                                {!! Form::label('proveedor','Proveedor:'); !!}
                            </div>
                            <div class="col-xs-4">
                                {!! Form::select('provider_id', $providers,old('provider_id',null),['id' => 'provider_id', 'class'=>'form-control', 'placeholder'=>'Proveedor']); !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-1">
                                {!! Form::label('tipo','Tipo:'); !!}
                            </div>
                            <div class="col-xs-4">
                                {!! Form::select('producttype_id', $producttypes,old('producttype_id',null),['id' => 'producttype_id', 'class'=>'form-control', 'placeholder'=>'Tipo']); !!}
                            </div>

                        </div>
                    {!! Form::close() !!}

                    {!! Form::open(['method' => 'POST', 'url' => "storeIncrease" , 'class' => 'form-horizontal my-2 my-lg-0 float-right'])  !!}
                        <div class="form-group">
                            <div class="col-xs-1" >
                                {!! Form::label('percent','Porncetaje:'); !!}
                            </div>
                            <div class="col-xs-2"  >
                                {!! Form::number('percent', '',[ 'id' => 'percent', 'class'=>'form-control','step' => '0.1', 'min' => '0']); !!}
                                {!! Form::hidden('provider_id', isset($provider_id)?$provider_id:null) !!}
                                {!! Form::hidden('producttype_id', isset($producttype_id)?$producttype_id:null) !!}
                            </div>
                            <div class="col-xs-1" style="width:5%">
                                <input id="btnCrear" class="btn btn-primary" type="submit" value="Aplicar">
                                </input>
                            </div>
                        </div>

                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Código</th><th>Marca</th><th>Producto</th><th>Tipo</th><th>Stock</th><th>Precio</th><th>Actualizar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->code }}</td><td>{{ $item->trademark->trademark or '' }}</td><td>{{ $item->product }}</td><td>{{ $item->producttype->producttype or '' }}</td><td>{{ $item->stock }}</td><td>{{ number_format($item->price,2,",",".") }}</td>
                                        <td>
                                            {!! Form::checkBox('product_id[]', $item->id, true, ['id' => $item->id]); !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if(count($products)>0)
                            <div class="pagination-wrapper"> {!! $products->appends(['provider_id' => Request::get('provider_id'), 'producttype_id' => Request::get('producttype_id')])->render() !!} </div>
                            @endif
                        </div>

                    {!! Form::close() !!}   

                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
    

        $("#provider_id").change(function(e){
            $("#searchForm").submit();
        });

        $("#producttype_id").change(function(e){
            $("#searchForm").submit();
        });

    </script>  
@endsection

