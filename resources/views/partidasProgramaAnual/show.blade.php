@extends('app')
@section ('content')
	<div class="row">
	  <div class="col-md-12">
	    <h1>Requisición: {{$partida->requisicion->descripcion}}</h1>
	    <hr>
		<h2>Partida</h2>
		<p><strong>Descripción: </strong>{{$partida->descripcion}}</p>
		<p><strong>Cantidad Mínima: </strong>{{$partida->cantidad_minima}}</p>
		<p><strong>Unidad de Medida: </strong>{{$partida->unidad_medida}}</p>
		<p><strong>Marca: </strong>{{$partida->marca}}</p>
	  </div>
	</div>
@endsection
