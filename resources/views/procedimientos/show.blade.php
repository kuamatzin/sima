@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">{{$procedimiento->descripcion}}</div>
				<div class="panel-body">
					<p>Asesor: {{$procedimiento->analista->name}}</p>
					<table class="table table bordered table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Descripcion</th>
								<th>Observaciones</th>
								<th>Carga Económica</th>
								<th>Ver Partidas</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($procedimiento->requisiciones as $key => $requisicion)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$requisicion->descripcion}}</td>
									<td>{{$requisicion->observaciones}}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<h3>Proveedores concursando:</h3>
				@foreach ($procedimiento->proveedores as $key => $proveedor)
					<p>{{$proveedor->nombre}}</p>
				@endforeach
		</div>
	</div>
</div>
@endsection