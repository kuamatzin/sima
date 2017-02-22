@extends('app')

@section('content')
<h2>Usuarios Procedimientos</h2>
<a href="/usuarios_procedimientos/create">
    <button type="button" class="btn btn-primary">Crear Usuario de Procedimiento</button>
</a>
<hr>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Editar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $key => $usuario)
            <tr>
                <td>{{$usuario->name}}</td>
                <td>{{$usuario->email}}</td>
                <td>
                    <a href="/usuarios_procedimientos/{{$usuario->id}}/edit">
                        <button type="button" class="btn btn-warning">Editar</button>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('scripts')

@endsection