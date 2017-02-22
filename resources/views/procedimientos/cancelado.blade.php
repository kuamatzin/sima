@extends('app')

@section('content')
    <h1>{{$procedimiento->numeroProcedimiento()}} - {{$procedimiento->descripcion()}}</h1>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Número de procedimiento</th>
                    <th>Descripción</th>
                    <th>Oficio</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$procedimiento->numeroProcedimiento()}}</td>
                    <td>{{$procedimiento->descripcion()}}</td>
                    <td>{{$procedimiento->oficio_cancelar}}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection