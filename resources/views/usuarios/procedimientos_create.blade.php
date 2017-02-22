@extends('app')

@section('content')
{!! Form::open(['url' => 'usuarios_procedimientos']) !!}
    @include('usuarios.procedimientos_form', ['submitButtonText' => 'Crear Usuario'])
{!! Form::close() !!}
@endsection

@section('scripts')

@endsection