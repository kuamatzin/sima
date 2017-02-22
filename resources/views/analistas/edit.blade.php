  @extends('app')
@section ('content')
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <h1>Administrar procedimiento: {{$procedimiento->requisiciones[0]->descripcion}}</h1>
      <div class="form-group">
        {!! Form::model($procedimiento, ['method' => 'PATCH', 'url' => 'partidas/' . $procedimiento->id]) !!}
          @include('analistas.form', ['submitButtonText' => 'Guardar'])
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection
