@extends('app')
@section ('content')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <h1>Crear proveedor</h1>
      <div class="form-group">
        {!! Form::open(['url' => 'proveedores']) !!}
          @include('proveedores.form', ['submitButtonText' => 'Crear proveedor'])
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection