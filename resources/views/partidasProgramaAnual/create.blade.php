@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<a href="/programa_anual/{{$partida_presupuestal->programa_anual->id}}">
				<button type="button" class="btn btn-primary">Regresar</button>
			</a>
			<br><br>
			<div class="panel panel-default">
				@if($requisicion_view)
				<div class="panel-heading">Crear partida para la requisición: {{$requisicion->descripcion}}</div>
				<div class="panel-body">
				    {!! Form::open(['action' => ['PartidasController@store', $requisicion->id]]) !!}
				    	@include('partidas.form', ['submitButtonText' => 'Crear Partida'])
				    {!! Form::close() !!}
				</div>
				@else
				<div class="panel-heading">Crear partida para: <strong>{{$partida_presupuestal->programa_anual->programa}}</strong>, Partida Presupuestal: <strong>{{$partida_presupuestal->concepto}}</strong></div>
				<div class="panel-body">
					{!! Form::open(['action' => ['PartidaProgramaAnualController@store', $partida_presupuestal->id]]) !!}
				    	@include('partidasProgramaAnual.form', ['submitButtonText' => 'Crear Partida'])
				    {!! Form::close() !!}
				</div>
				@endif
				
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script>
$('#precio_unitario').on('input', function() {
    var precio_unitario = $('#precio_unitario').val();
    var cantidad_minima = $('#cantidad_minima').val();
    var total = precio_unitario * cantidad_minima;
    $('#presupuesto_total_articulo').val(total);
});

$('#cantidad_minima').on('input', function() {
    var precio_unitario = $('#precio_unitario').val();
    var cantidad_minima = $('#cantidad_minima').val();
    var total = precio_unitario * cantidad_minima;
    $('#presupuesto_total_articulo').val(total);
});

$('#cantidad_articulos_trimestre_1').on('input', function() {
    var precio_unitario = $('#precio_unitario').val();
    var cantidad_primer_trimestre = $('#cantidad_articulos_trimestre_1').val();
    var total_primer_trimestre = precio_unitario * cantidad_primer_trimestre;
    $('#presupuesto_primer_trimestre').val(total_primer_trimestre);
});

$('#cantidad_articulos_trimestre_2').on('input', function() {
    var precio_unitario = $('#precio_unitario').val();
    var cantidad_segundo_trimestre = $('#cantidad_articulos_trimestre_2').val();
    var total_segundo_trimestre = precio_unitario * cantidad_segundo_trimestre;
    $('#presupuesto_segundo_trimestre').val(total_segundo_trimestre);
});

$('#cantidad_articulos_trimestre_3').on('input', function() {
    var precio_unitario = $('#precio_unitario').val();
    var cantidad_tercer_trimestre = $('#cantidad_articulos_trimestre_3').val();
    var total_tercer_trimestre = precio_unitario * cantidad_tercer_trimestre;
    $('#presupuesto_tercer_trimestre').val(total_tercer_trimestre);
});

$('#cantidad_articulos_trimestre_4').on('input', function() {
    var precio_unitario = $('#precio_unitario').val();
    var cantidad_cuarto_trimestre = $('#cantidad_articulos_trimestre_4').val();
    var total_cuarto_trimestre = precio_unitario * cantidad_cuarto_trimestre;
    $('#presupuesto_cuarto_trimestre').val(total_cuarto_trimestre);
});
</script>
@endsection
