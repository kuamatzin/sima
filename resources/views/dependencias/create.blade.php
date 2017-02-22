@extends('app')
@section ('content')
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <h1>Crear dependencia</h1>
      {!! Form::open(['url' => 'dependencias']) !!}
        @include('dependencias.form', ['submitButtonText' => 'Crear Dependencia'])
      {!! Form::close() !!}
    </div>
  </div>
@endsection
