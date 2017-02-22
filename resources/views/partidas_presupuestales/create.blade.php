@extends('app')

@section('content')
<h1>{{ $programa_anual->programa }}</h1>
<h3>Agregar Partida Presupuestal</h3>

{!! Form::open(['url' => "partidas_presupuestales/$programa_anual->id"]) !!}
    @include('partidas_presupuestales.form', ['submitButtonText' => 'Crear Partida Presupuestal'])
{!! Form::close() !!}
@endsection

@section('scripts')

@endsection