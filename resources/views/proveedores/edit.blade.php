@extends('app')
@section ('content')
  <div class="main">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <h1>Editar proveedor: {{$proveedor->nombre}}</h1>
        <div class="form-group">
          {!! Form::model($proveedor, ['method' => 'PATCH', 'url' => 'proveedores/' . $proveedor->id]) !!}
            @include('proveedores.form', ['submitButtonText' => 'Guardar'])
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection