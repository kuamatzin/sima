<h3>Requisiciones</h3>
<div class="table-responsive">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>No.</th>
				<th>Selecciona</th>
				<th>Codificacion</th>
				<th>Dependencia</th>
				<th>Descripción</th>
				<th>Estatus</th>
				<th>Tipo Procedimiento</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($requisiciones as $key => $requisicion)
			<tr>
				<td>
					{{$key+1}}
				</td>
				<td>
					@if($requisicion_array == "create")
					{!! Form::checkbox('requisicion[]', $requisicion->id, null, ['class' => 'field']) !!}
					@else
					{!! Form::checkbox('requisicion[]', $requisicion->id, $requisicion->checkId($requisicion_array), ['class' => 'field']) !!}
					@endif
				</td>
				<td>
					{{ $requisicion->mes }}_{{ $requisicion->consecutivo }}-{{ $requisicion->anio }}
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
					{{$requisicion->tipo_requisicion}}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<small class="text-danger">@if($errors->first('requisicion'))
		Solamente puedes seleccionar una requisición por procedimiento
	@endif</small>
</div>

<hr>
<div class="form-group">
	{!! Form::label('analista_id', 'Asignar analista') !!}
	{!! Form::select('analista_id', $analistas, null, ['class' => 'form-control']) !!}
	<small class="text-danger">{{ $errors->first('analista_id') }}</small>
</div>
{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary', 'id' => 'submitProcedimiento']) !!}