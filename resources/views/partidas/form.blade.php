<div class="form-group col-md-2">
    {!! Form::label('unidad_medida', 'Unidad de Medida') !!}
    {!! Form::select('unidad_medida', ['METRO CÚBICO' => 'METRO CÚBICO', 'PZ' => 'PZ', 'MT' => 'MT', 'LT' => 'LT', 'CAJA' => 'CAJA', 'PAQUETE' => 'PAQUETE', 'GALÓN' => 'GALÓN', 'PAR' => 'PAR', 'MILLAR' => 'MILLAR', 'CIENTO' => 'CIENTO', 'BOLSA' => 'BOLSA', 'BOTE' => 'BOTE', 'GARRAFÓN' => 'GARRAFÓN', 'KILO' => 'KILO', 'ROLLO' => 'ROLLO', 'BLOC' => 'BLOC', 'PLIEGO' => 'PLIEGO', 'COLCHÓN' => 'COLCHÓN', 'FRASCO' => 'FRASCO', 'TORRE' => 'TORRE', 'SERVICIO' => 'SERVICIO', 'TONELADA' => 'TONELADA', 'DIETA' => 'DIETA', 'VALES' => 'VALES', 'MANOJO' => 'MANOJO', 'DIETA' => 'DIETA', 'DIETA' => 'DIETA', 'DIETA' => 'DIETA', 'VALES' => 'VALES', 'MANOJO' => 'MANOJO', 'MILILITRO' => 'MILILITRO', 'UI' => 'UI', 'PESOS' => 'PESOS', 'COSTAL/BULTO' => 'COSTAL/BULTO', 'MILIGRAMOS' => 'MILIGRAMOS', 'MICROGRAMOS' => 'MICROGRAMOS'], null, ['class' => 'form-control']) !!}
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
    {!! Form::label('marca', 'Marca') !!}
    {!! Form::text('marca', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('marca') }}</small>
</div>

<div class="form-group col-md-2">
    {!! Form::label('clave', 'Clave o Modelo') !!}
    {!! Form::text('clave', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('clave') }}</small>
</div>

<div class="form-group col-md-12 @if($errors->first('descripcion')) has-error @endif">
    {!! Form::label('descripcion', 'Descripción') !!}
    {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('descripcion') }}</small>
</div>

<div class="form-group col-md-12">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
</div>