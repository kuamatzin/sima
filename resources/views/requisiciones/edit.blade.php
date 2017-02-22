@extends('app')
@section ('content')
  <div class="main">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Editar requisicion: {{$requisicion->descripcion}}</div>
          <div class="panel-body">
            {!! Form::model($requisicion, ['method' => 'PATCH', 'url' => 'requisiciones/' . $requisicion->id]) !!}
              @if($requisicion->anio == '2016')
                @include('requisiciones.form', ['submitButtonText' => 'Guardar'])
              @else
                @include('requisiciones.form_2017', ['submitButtonText' => 'Guardar'])
              @endif
            {!! Form::close() !!}
          </div>
        </div>
      </div>
      <div class="col-md-5">
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