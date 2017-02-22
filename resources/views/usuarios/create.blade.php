@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Registrar usuario</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'usuarios']) !!}
						@include('usuarios.form', ['submitButtonText' => 'Crear Usuario'])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
