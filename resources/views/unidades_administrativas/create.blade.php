@extends('app')
@section ('content')
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <h1>{{$dependencia->nombre}}</h1>
      <h2>Crear Unidad Administrativa</h2>
      <div class="form-group">
        {!! Form::open(['url' => ['unidades_administrativas/' . $dependencia->id]]) !!}
          @include('unidades_administrativas.form', ['submitButtonText' => 'Guardar'])
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection