@extends('app')
@section ('content')
  <div class="main">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <h1>Editar dependencia: {{$dependencia->nombre}}</h1>
        <div class="form-group">
          {!! Form::model($dependencia, ['method' => 'PATCH', 'url' => 'dependencias/' . $dependencia->id]) !!}
            @include('dependencias.form', ['submitButtonText' => 'Guardar'])
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection