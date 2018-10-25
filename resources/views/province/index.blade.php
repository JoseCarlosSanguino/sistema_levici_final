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
                        <th colspan="2">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    @foreach($provinces as $province)
                    @php
                        $date=date('Y-m-d', $province['date']);
                        @endphp
                    <tr>
                        <td>{{$province['id']}}</td>
                        <td>{{$province['province']}}</td>
                        
                        <td><a href="{{action('ProvinceController@edit', $province['id'])}}" class="btn btn-warning">Edit</a></td>
                        <td>
                            <form action="{{action('ProvinceController@destroy', $province['id'])}}" method="post">
                                {{csrf_field()}}
                                <input name="_method" type="hidden" value="DELETE">
                                <button class="btn btn-danger btn-xs" type="submit"><span class="glyphicon glyphicon-trash"></span></button>
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