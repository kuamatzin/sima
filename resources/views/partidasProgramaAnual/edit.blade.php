@extends('app')
@section ('content')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      @if($requisicion_view)
      <h1>Editar partida: {{$partida->descripcion}}</h1>
      <div class="form-group">
        {!! Form::model($partida, ['method' => 'PATCH', 'url' => 'partidas/' . $partida->requisicion->id . '/' . $partida->id]) !!}
          @include('partidas.form', ['submitButtonText' => 'Guardar'])
        {!! Form::close() !!}
      </div>
      @else
      <h1>Editar partida: {{$partida->descripcion}}</h1>
      <div class="form-group">
        {!! Form::model($partida, ['method' => 'PATCH', 'url' => 'partidas_programa_anual/' . $partida->id]) !!}
          <div class="form-group col-md-2">
              {!! Form::label('unidad_medida', 'Unidad de Medida') !!}
              {!! Form::select('unidad_medida', ['PZ' => 'PZ', 'MT' => 'MT', 'LT' => 'LT', 'CAJA' => 'CAJA', 'PAQUETE' => 'PAQUETE', 'GALÓN' => 'GALÓN', 'PAR' => 'PAR', 'MILLAR' => 'MILLAR', 'CIENTO' => 'CIENTO', 'BOLSA' => 'BOLSA', 'BOTE' => 'BOTE', 'GARRAFÓN' => 'GARRAFÓN', 'KILO' => 'KILO', 'ROLLO' => 'ROLLO', 'BLOC' => 'BLOC', 'PLIEGO' => 'PLIEGO', 'COLCHÓN' => 'COLCHÓN', 'FRASCO' => 'FRASCO'], null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('unidad_medida') }}</small>
          </div>

          <div class="form-group col-md-2">
              {!! Form::label('cantidad_minima', 'Cantidad mínima') !!}
              {!! Form::text('cantidad_minima', null, ['class' => 'form-control', 'id' => 'cantidad_minima']) !!}
              <small class="text-danger">{{ $errors->first('cantidad_minima') }}</small>
          </div>

          <div class="form-group col-md-2">
              {!! Form::label('cantidad_maxima', 'Cantidad máxima') !!}
              {!! Form::text('cantidad_maxima', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('cantidad_maxima') }}</small>
          </div>

          <div class="form-group col-md-2">
              {!! Form::label('marca', 'Marca o Modelo') !!}
              {!! Form::text('marca', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('marca') }}</small>
          </div>

          @if(!$requisicion_view)
          <div class="form-group col-md-2 @if($errors->first('precio_unitario')) has-error @endif">
              {!! Form::label('precio_unitario', 'Precio Unitario') !!}
              {!! Form::text('precio_unitario', null, ['class' => 'form-control', 'required' => '', 'id' => 'precio_unitario']) !!}
              <small class="text-danger">{{ $errors->first('precio_unitario') }}</small>
          </div>

          <div class="form-group col-md-2 @if($errors->first('presupuesto_total_articulo')) has-error @endif">
              {!! Form::label('presupuesto_total_articulo', 'Presupuesto Total') !!}
              {!! Form::text('presupuesto_total_articulo', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'presupuesto_total_articulo']) !!}
              <small class="text-danger">{{ $errors->first('presupuesto_total_articulo') }}</small>
          </div>
          @else
          <div class="form-group col-md-2 col-md-offset-2">
          </div>
          @endif

          <div class="form-group col-md-12 @if($errors->first('descripcion')) has-error @endif">
              {!! Form::label('descripcion', 'Descripción') !!}
              {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('descripcion') }}</small>
          </div>

          @if(!$requisicion_view)
          @foreach($verificar as $key => $ver)
            <h3>{{$key + 1}}º Trimestre</h3>
            <hr>
            <div class="form-group col-md-6 @if($errors->first('cantidad1')) has-error @endif">
                {!! Form::label('cantidad1', 'Cantidad de Artículos') !!}
                {!! Form::text('cantidades[]', $ver[0], ['class' => 'form-control', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('cantidad1') }}</small>
            </div>

            <div class="form-group col-md-6 @if($errors->first('presupuesto1')) has-error @endif">
                {!! Form::label('presupuesto1', 'Presupuesto') !!}
                {!! Form::text('presupuestos[]', $ver[1], ['class' => 'form-control', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('presupuesto1') }}</small>
            </div>

            {!! Form::hidden('ids[]', $ver[2]) !!}
          @endforeach
          @else

          @endif

          <div class="form-group col-md-12">
              {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
          </div>
        {!! Form::close() !!}
      </div>
      @endif
      
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
</script>
@endsection