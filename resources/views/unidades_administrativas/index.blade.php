@extends('app')
@section('content')
    @foreach($unidades_administrativas as $key => $unidad)
        {{$unidad->nombre}}
    @endforeach
@endsection