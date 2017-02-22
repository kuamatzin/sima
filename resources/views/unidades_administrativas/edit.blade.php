@extends('app')

@section('content')
<h1>{{$unidad_administrativa->nombre}}</h1>
<div class="form-group">
    {!! Form::model($unidad_administrativa, ['method' => 'PATCH', 'url' => 'unidades_administrativas/' . $unidad_administrativa->id]) !!}
      @include('unidades_administrativas.form', ['submitButtonText' => 'Guardar'])
    {!! Form::close() !!}
  </div>
@endsection