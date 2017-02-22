@extends('app')
@section ('content')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <h1>Editar partida</h1>
      <div class="form-group">
        {!! Form::model($partida, ['method' => 'PATCH', 'url' => 'partidas/' . $partida->requisicion->id . '/' . $partida->id]) !!}
          @include('partidas.form', ['submitButtonText' => 'Guardar'])
        {!! Form::close() !!}
      </div>  
    </div>
  </div>
@endsection