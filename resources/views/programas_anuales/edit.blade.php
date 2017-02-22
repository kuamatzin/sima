@extends('app')

@section('content')
{!! Form::model($programa_anual, ['action' => ['ProgramaAnualController@update', $programa_anual->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

    @include('programas_anuales.form', ['submitButtonText' => 'Guardar'])

{!! Form::close() !!}
@endsection

@section('scripts')

@endsection