{!! Form::text('descripcion', Input::old('descripcion'),  ['class'=>'form-control', 'placeholder'=>'Descripcion']) !!}
<br>
{!! Form::select('tipo_procedimiento', ['' => 'Tipo de procedimiento', '1' => 'ADL', '2' => 'IL', '3' => 'LPN', '4' => 'INV', '5' => 'ADX'], null, ['class'=>'form-control']) !!}
<br>
{!! Form::text('partida_presupuestal', Input::old('partida_presupuestal'), ['class' => 'form-control', 'placeholder' => 'Partida Presupuesta']) !!}
<br>
{!! Form::select('analista_id', $analistas, null, ['class'=>'form-control']) !!}
<br>
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Selecciona</th>
			<th>No.</th>
			<th>Dependencia</th>
			<th>Descripción</th>
			<th>Estatus</th>
			<th>Observaciones</th>
			<th>Agregar</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($requisiciones as $key => $requisicion)
			<tr>
				<td>
					@if($requisicion_array == "create")
					{!! Form::checkbox('requisicion[]', $requisicion->id, null, ['class' => 'field']) !!}
					@else
					{!! Form::checkbox('requisicion[]', $requisicion->id, $requisicion->checkId($requisicion_array), ['class' => 'field']) !!}
					@endif
				</td>
				<td>
					{{$key+1}}
				</td>
				<td>
					{{$requisicion->dependencia->nombre}}
				</td>
				<td>
					{{$requisicion->descripcion}}
				</td>
				<td>
					{{$requisicion->status}}
				</td>
				<td>
					{{$requisicion->observaciones}}
				</td>
				<td>
					<button type="button" class="btn btn-primary">Agregar</button>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
<hr>
<h3>Datos Generales del Concurso</h3>
<div class="row">
	<div class="col-md-6">
		{!! Form::label('evento_label', 'Evento', array('class' => 'col-sm-4')) !!}
		{!! Form::text('evento', Input::old('evento'), ['class' => 'form-control', 'placeholder' => 'Evento']) !!}
		<br>
		{!! Form::label('fecha_inicial_label', 'Fecha Inicial', array('class' => 'col-sm-4')) !!}
		{!! Form::input('date', 'fecha_inicial', date('Y-m-d'),  array('class'=>'form-control')) !!}
		<br>
		{!! Form::label('fecha_final_label', 'Fecha Final', array('class' => 'col-sm-3')) !!}
		{!! Form::input('date', 'fecha_final', date('Y-m-d'),  array('class'=>'form-control')) !!}
	</div>
	<div class="col-md-6">
		{!! Form::label('pedido_label', 'Pedido', array('class' => 'col-sm-2')) !!}
		{!! Form::text('pedido', Input::old('pedido'), ['class' => 'form-control', 'placeholder' => 'Pedido']) !!}
		<br>
		{!! Form::label('fecha_conclusion_label', 'Fecha Conclusión', array('class' => 'col-sm-6')) !!}
		{!! Form::input('date', 'fecha_conclusion', date('Y-m-d'),  array('class'=>'form-control')) !!}
		<br>
		{!! Form::label('numero_factura_label', 'Número de Factura', array('class' => 'col-sm-6')) !!}
		{!! Form::text('numero_factura', Input::old('numero_factura'), ['class' => 'form-control', 'placeholder' => 'Número de Factura']) !!}
		<br>
		{!! Form::label('fecha_factura_label', 'Fecha de Factura', array('class' => 'col-sm-6')) !!}
		{!! Form::input('date', 'fecha_factura', date('Y-m-d'),  array('class'=>'form-control')) !!}
		<br>
		{!! Form::label('tramite_pago_label', 'Trámite de Pago', array('class' => 'col-sm-6')) !!}
		{!! Form::text('tramite_pago', Input::old('tramite_pago'), ['class' => 'form-control', 'placeholder' => 'Trámite de Pago']) !!}
	</div>
</div>


{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}