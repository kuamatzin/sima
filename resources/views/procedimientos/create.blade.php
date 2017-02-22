@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Crear procedimiento</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'procedimientos']) !!}
						@include('procedimientos.form', ['ListCheck' => null, 'submitButtonText' => 'Crear Procedimiento'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
