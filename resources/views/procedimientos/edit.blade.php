@extends('app')
@section ('content')
  <div class="main">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <h1>Editar procedimiento</h1>
        <div class="form-group">
          {!! Form::model($procedimiento, ['method' => 'PATCH', 'url' => 'procedimientos/' . $procedimiento->id]) !!}
            @include('procedimientos.form', ['submitButtonText' => 'Guardar'])
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection