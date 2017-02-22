@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<a href="">
				<button type="button" class="btn btn-primary">Regresar</button>
			</a>
			<br><br>
			<div class="panel panel-default">
				<div class="panel-heading">Crear partida para la requisición: {{$requisicion->descripcion}}</div>
				<div class="panel-body">
					{!! Form::open(['action' => ['PartidasController@store', $requisicion->id]]) !!}
				    	@include('partidas.form', ['submitButtonText' => 'Crear Partida'])
				    {!! Form::close() !!}
				</div>	
			</div>
		</div>
	</div>
</div>
@endsection
