@extends('app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3>Agregar Usuario a {{$dependencia->nombre}}</h3>
        {!! Form::open(['url' => 'usuarios_dependecia/' . $dependencia->id]) !!}
            @include('usuarios.dependencia_form', ['submitButtonText' => 'Guardar'])
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('scripts')

@endsection