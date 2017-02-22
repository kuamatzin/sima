@if(Auth::user()->isAnalista())
<div class="form-group col-md-4">
{!! Form::hidden('dependencia_id', Auth::user()->dependencia->id) !!}
</div>
@elseif(Auth::user()->isAnalistaUnidad())
<div class="form-group col-md-4">
{!! Form::hidden('unidad_administrativa_id', Auth::user()->unidad_administrativa_id) !!}
</div>
@else
<div class="form-group col-md-4">
    {!! Form::label('dependencia_id', 'Dependencia') !!}
    {!! Form::select('dependencia_id', $dependencias, null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('dependencia_id') }}</small>
</div>
@endif

@if($edit)
    <div class="form-group col-md-4">
        {!! Form::label('status', 'Status') !!}
        {!! Form::select('status', ['' => 'Selecciona', '1' => 'Previa', '2' => 'Definitiva', '3' => 'Cancelada'], $requisicion->getOriginal("status"), ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('status') }}</small>
    </div>

    <div class="form-group col-md-4">
        {!! Form::label('tipo_requisicion', 'Tipo de Requisición') !!}
        {!! Form::select('tipo_requisicion', ['' => 'Selecciona', '1' => 'Bien', '2' => 'Servicio'], $requisicion->getOriginal("tipo_requisicion"), ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('tipo_requisicion') }}</small>
    </div>
@else
    <div class="form-group col-md-4">
        {!! Form::label('status', 'Status') !!}
        {!! Form::select('status', ['' => 'Selecciona', '1' => 'Previa', '2' => 'Definitiva', '3' => 'Cancelada'], null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('status') }}</small>
    </div>

    <div class="form-group col-md-4">
        {!! Form::label('tipo_requisicion', 'Tipo de Requisición') !!}
        {!! Form::select('tipo_requisicion', ['' => 'Selecciona', '1' => 'Bien', '2' => 'Servicio'], null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('tipo_requisicion') }}</small>
    </div>
@endif

<div class="form-group col-md-12">
    {!! Form::label('descripcion', 'Descripción') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('descripcion') }}</small>
</div>

<div class="form-group col-md-4">
    {!! Form::label('partida_presupuestal', 'Partida Presupuestal') !!}
    {!! Form::text('partida_presupuestal', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('partida_presupuestal') }}</small>
</div>

<div class="form-group col-md-4">
    {!! Form::label('codificacion', 'Codificación') !!}
    {!! Form::text('codificacion', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('codificacion') }}</small>
</div>

@if($edit)
<div class="form-group col-md-4">
    {!! Form::label('presupuesto', 'Presupuesto') !!}
    {!! Form::text('presupuesto', $requisicion->getOriginal("presupuesto"), ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('presupuesto') }}</small>
</div>
@else
<div class="form-group col-md-4">
    {!! Form::label('presupuesto', 'Presupuesto') !!}
    {!! Form::text('presupuesto', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('presupuesto') }}</small>
</div>
@endif

<div class="form-group col-md-6">
    {!! Form::label('origen_recursos', 'Origen de recursos') !!}
    {!! Form::select('origen_recursos', ['' => 'Origen de recursos', '1' => 'Estatales', '2' => 'Propios', '3' => 'Federales'], null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('origen_recursos') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('procedimiento_adjudicacion', 'Procedimiento de adjudicación') !!}
    {!! Form::select('procedimiento_adjudicacion', ['' => 'Procedimiento de adjudicación', '1' => 'Adjudicación Directa', '2' => 'Invitación a cuando menos tres', '3' => 'Licitación Pública'], null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('procedimiento_adjudicacion') }}</small>
</div>

<div class="form-group col-md-4">
    {!! Form::label('tiempo_entrega', 'Tiempo de entrega') !!}
    {!! Form::text('tiempo_entrega', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('tiempo_entrega') }}</small>
</div>

<div class="form-group col-md-4">
    {!! Form::label('lugar_entrega', 'Lugar de entrega') !!}
    {!! Form::text('lugar_entrega', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('lugar_entrega') }}</small>
</div>

<div class="form-group col-md-4">
    {!! Form::label('garantia', 'Garantía') !!}
    {!! Form::text('garantia', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('garantia') }}</small>
</div>

<div class="form-group col-md-4">
    {!! Form::label('asesor', 'Asesor') !!}
    {!! Form::text('asesor', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('asesor') }}</small>
</div>

<div class="form-group col-md-4">
    {!! Form::label('cargo_asesor', 'Cargo del asesor') !!}
    {!! Form::text('cargo_asesor', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('cargo_asesor') }}</small>
</div>

<div class="form-group col-md-4">
    {!! Form::label('email_asesor', 'Email') !!}
    {!! Form::text('email_asesor', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('email_asesor') }}</small>
</div>

<div class="form-group col-md-4">
    {!! Form::label('dias_pago', 'Dias de pago') !!}
    {!! Form::text('dias_pago', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('dias_pago') }}</small>
</div>

<div class="form-group col-md-4">
    {!! Form::label('observaciones', 'Observaciones') !!}
    {!! Form::text('observaciones', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('observaciones') }}</small>
</div>

<div class="form-group col-md-4">
    {!! Form::label('requisitos_tecnicos', 'Requisitos técnicos') !!}
    {!! Form::text('requisitos_tecnicos', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('requisitos_tecnicos') }}</small>
</div>

<div class="form-group col-md-12">
    {!! Form::label('requisitos_economicos', 'Requisitos económicos') !!}
    {!! Form::text('requisitos_economicos', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('requisitos_economicos') }}</small>
</div>

<div class="form-group col-md-12">
    {!! Form::label('requisitos_informativos', 'Requisitos informativos') !!}
    {!! Form::text('requisitos_informativos', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('requisitos_informativos') }}</small>
</div>

<div class="form-group col-md-12">
    {!! Form::label('condiciones_pago', 'Condiciones de pago') !!}
    {!! Form::text('condiciones_pago', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('condiciones_pago') }}</small>
</div>

<div class="form-group col-md-12">
    {!! Form::label('datos_facturacion', 'Datos de facturación') !!}
    {!! Form::text('datos_facturacion', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('datos_facturacion') }}</small>
</div>

<div class="form-group col-md-12">
    <div class="checkbox">
        <label for="regularizar">
            {!! Form::checkbox('regularizar', null, null, ['id' => 'regularizar']) !!} Regularizar
        </label>
    </div>
    <small class="text-danger">{{ $errors->first('regularizar') }}</small>
</div>

<div class="form-group" style="display:none" id="reg">
    {!! Form::label('fecha_regularizacion', 'Publicar en') !!}
    {!! Form::input('datetime-local', 'fecha_regularizacion', date("Y-m-d"), ['class' => '', 'placeholder' => 'Publicado en']) !!}
    <small class="text-danger">{{ $errors->first('fecha_regularizacion') }}</small>
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
</div>