@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Crear requisicion</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'requisiciones']) !!}
				    	@include('requisiciones.form_2017', ['submitButtonText' => 'Crear Requisicion'])
				    {!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
 <script>
$('#regularizar').click(function () {
    $('#reg').toggle(this.checked);
});
 </script>
@endsection