@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header"><h3> {{ $product->product }}</h3></div>
                    <br/>
                    <div class="card-body">

                        <a href="{{ url('/'.$controller) }}" title="Atrás"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atrás</button></a>
                        <a href="{{ url('/'.$controller.'/' . $product->id . '/edit') }}" title="Editar"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>

                        <form method="POST" action="{{ url('/'.$controller . '/' . $product->id) }}" accept-charset="UTF-8" style="display:inline">
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
                                        <th>ID</th><td>{{ $product->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> Código </th>
                                        <td> {{ $product->code }} </td>
                                    </tr>
                                    <tr>
                                        <th> Producto </th>
                                        <td> {{ $product->product }} </td>
                                    </tr>
                                    <tr>
                                        <th> Descripción </th>
                                        <td> {{ $product->description }} </td>
                                    </tr>
                                    <tr>
                                        <th> Tipo </th>
                                        <td> {{ $product->producttype->producttype or '' }} </td>
                                    </tr>
                                    <tr>
                                        <th> Marca </th>
                                        <td> {{ $product->trademark->trademark or '' }} </td>
                                    </tr>
                                    <tr>
                                        <th> Tipo iva </th>
                                        <td> {{ $product->ivatype->ivatype or '' }} </td>
                                    </tr>
                                    <tr>
                                        <th> Posición </th>
                                        <td> {{ $product->position or '' }} </td>
                                    </tr>
                                    <tr>
                                        <th> Unidad </th>
                                        <td> {{ $product->unittype->unittype or  '' }} </td>
                                    </tr>
                                    <tr>
                                        <th> Stock </th>
                                        <td> {{ $product->stock }} </td>
                                    </tr>
                                    <tr>
                                        <th> Costo </th>
                                        <td> {{ number_format($product->cost,2,",",".") }} </td>
                                    </tr>
                                    <tr>
                                        <th> Precio </th>
                                        <td> {{ number_format($product->price,2,",",".") }} </td>
                                    </tr>
                                    <tr>
                                        <th> Último Precio </th>
                                        <td> {{ number_format($product->last_price,2,",",".") }} </td>
                                    </tr>
                                    <tr>
                                        <th> Costo </th>
                                        <td> {{ number_format($product->cost,2,",",".") }} </td>
                                    </tr>
                                    <tr>
                                        <th> Último Costo </th>
                                        <td> {{ number_format($product->last_cost,2,",",".") }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
