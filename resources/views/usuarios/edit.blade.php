@extends('app')
@section ('content')
  <div class="main">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <h1>Editar usuarioss: {{$usuario->nombre}}</h1>
        <div class="form-group">
          {!! Form::model($usuario, ['method' => 'PATCH', 'url' => 'usuarios/' . $usuario->id]) !!}
            @include('usuarios.form', ['submitButtonText' => 'Guardar'])
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection