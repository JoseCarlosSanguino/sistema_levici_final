@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header"><h3> {{ $customer->name }}</h3></div>
                    <br/>
                    <div class="card-body">

                        <a href="{{ url('/'.$controller) }}" title="Atrás"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atrás</button></a>
                        <a href="{{ url('/'.$controller.'/' . $customer->id . '/edit') }}" title="Editar"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>

                        <form method="POST" action="{{ url('/'.$controller . '/' . $customer->id) }}" accept-charset="UTF-8" style="display:inline">
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
                                        <th>ID</th><td>{{ $customer->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> Razón social </th>
                                        <td> {{ $customer->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> Cuit </th>
                                        <td> {{ $customer->cuit }} </td>
                                    </tr>
                                    <tr>
                                        <th> Condición de IVA </th>
                                        <td> {{ $customer->ivacondition->ivacondition }} </td>
                                    </tr>
                                    <tr>
                                        <th> Telefono </th>
                                        <td> {{ $customer->telephone }} </td>
                                    </tr>
                                    <tr>
                                        <th> Dirección </th>
                                        <td> {{ $customer->address }} </td>
                                    </tr>
                                    <tr>
                                        <th> Provincia </th>
                                        <td> {{ $customer->province->province }} </td>
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
