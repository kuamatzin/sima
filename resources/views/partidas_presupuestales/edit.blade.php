@extends('app')

@section('content')
{!! Form::model($partida_presupuestal, ['method' => 'PATCH', 'action' => ['PartidasPresupuestalesController@update', $partida_presupuestal->id]]) !!}
    
    @include('partidas_presupuestales.form', ['submitButtonText' => 'Editar']);

{!! Form::close() !!}
@endsection

@section('scripts')

@endsection