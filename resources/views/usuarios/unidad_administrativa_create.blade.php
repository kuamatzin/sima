@extends('app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3>Agregar Usuario a {{$unidad_administrativa->nombre}}</h3>
        {!! Form::open(['url' => 'usuarios_unidad_administrativa/' . $unidad_administrativa->id]) !!}
            @include('usuarios.unidad_administrativa_form', ['submitButtonText' => 'Guardar'])
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('scripts')

@endsection