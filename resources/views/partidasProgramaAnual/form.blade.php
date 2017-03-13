<div class="form-group col-md-2">
    {!! Form::label('unidad_medida', 'Unidad de Medida') !!}
    {!! Form::select('unidad_medida', ['METRO CÚBICO' => 'METRO CÚBICO', 'PZ' => 'PZ', 'MT' => 'MT', 'LT' => 'LT', 'CAJA' => 'CAJA', 'PAQUETE' => 'PAQUETE', 'GALÓN' => 'GALÓN', 'PAR' => 'PAR', 'MILLAR' => 'MILLAR', 'CIENTO' => 'CIENTO', 'BOLSA' => 'BOLSA', 'BOTE' => 'BOTE', 'GARRAFÓN' => 'GARRAFÓN', 'KILO' => 'KILO', 'ROLLO' => 'ROLLO', 'BLOC' => 'BLOC', 'PLIEGO' => 'PLIEGO', 'COLCHÓN' => 'COLCHÓN', 'FRASCO' => 'FRASCO', 'TORRE' => 'TORRE', 'SERVICIO' => 'SERVICIO', 'TONELADA' => 'TONELADA', 'DIETA' => 'DIETA', 'VALES' => 'VALES', 'MANOJO' => 'MANOJO', 'MILILITRO' => 'MILILITRO', 'UI' => 'UI', 'PESOS' => 'PESOS', 'COSTAL/BULTO' => 'COSTAL/BULTO', 'MILIGRAMOS' => 'MILIGRAMOS', 'MICROGRAMOS' => 'MICROGRAMOS'], null, ['class' => 'form-control']) !!}
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
<h3>Presupuesto Trimestral</h3>
<hr>
<p>Primer Trimestre</p>
<div class="form-group col-md-6 @if($errors->first('cantidad1')) has-error @endif">
    {!! Form::label('cantidad1', 'Cantidad de Artículos') !!}
    {!! Form::text('cantidades[]', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'cantidad_articulos_trimestre_1']) !!}
    <small class="text-danger">{{ $errors->first('cantidad1') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('presupuesto1')) has-error @endif">
    {!! Form::label('presupuesto1', 'Presupuesto') !!}
    {!! Form::text('presupuestos[]', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'presupuesto_primer_trimestre']) !!}
    <small class="text-danger">{{ $errors->first('presupuesto1') }}</small>
</div>
<hr>
<p>Segundo Trimestre</p>
<div class="form-group col-md-6 @if($errors->first('cantidad2')) has-error @endif">
    {!! Form::label('cantidad2', 'Cantidad de Artículos') !!}
    {!! Form::text('cantidades[]', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'cantidad_articulos_trimestre_2']) !!}
    <small class="text-danger">{{ $errors->first('cantidad2') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('presupuesto2')) has-error @endif">
    {!! Form::label('presupuesto2', 'Presupuesto') !!}
    {!! Form::text('presupuestos[]', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'presupuesto_segundo_trimestre']) !!}
    <small class="text-danger">{{ $errors->first('presupuesto2') }}</small>
</div>
<hr>
<p>Tercer Trimestre</p>
<div class="form-group col-md-6 @if($errors->first('cantidad3')) has-error @endif">
    {!! Form::label('cantidad3', 'Cantidad de Artículos') !!}
    {!! Form::text('cantidades[]', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'cantidad_articulos_trimestre_3']) !!}
    <small class="text-danger">{{ $errors->first('cantidad3') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('presupuesto3')) has-error @endif">
    {!! Form::label('presupuesto3', 'Presupuesto') !!}
    {!! Form::text('presupuestos[]', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'presupuesto_tercer_trimestre']) !!}
    <small class="text-danger">{{ $errors->first('presupuesto3') }}</small>
</div>
<hr>
<p>Cuarto Trimestre</p>
<div class="form-group col-md-6 @if($errors->first('cantidad4')) has-error @endif">
    {!! Form::label('cantidad4', 'Cantidad de Artículos') !!}
    {!! Form::text('cantidades[]', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'cantidad_articulos_trimestre_4']) !!}
    <small class="text-danger">{{ $errors->first('cantidad4') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('presupuesto4')) has-error @endif">
    {!! Form::label('presupuesto4', 'Presupuesto') !!}
    {!! Form::text('presupuestos[]', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'presupuesto_cuarto_trimestre']) !!}
    <small class="text-danger">{{ $errors->first('presupuesto4') }}</small>
</div>
<hr>
@else

@endif

<div class="form-group col-md-12">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
</div>