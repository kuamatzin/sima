<div class="form-group col-md-6">
    {!! Form::label('id_dependencia', 'Dependencia') !!}
    {!! Form::select('id_dependencia', $dependencias, null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('id_dependencia') }}</small>
</div>

@if($edit)
    <div class="form-group">
        {!! Form::label('status', 'Status') !!}
        {!! Form::select('status', ['' => 'Selecciona', '1' => 'Previa', '2' => 'Definitiva', '3' => 'Cancelada'], $requisicion->getOriginal("status"), ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('status') }}</small>
    </div>

    <div class="form-group">
        {!! Form::label('tipo_requisicion', 'Tipo de Requisición') !!}
        {!! Form::select('tipo_requisicion', ['' => 'Selecciona', '1' => 'Bien', '2' => 'Servicio'], $requisicion->getOriginal("tipo_requisicion"), ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('tipo_requisicion') }}</small>
    </div>
@else
    <div class="form-group col-md-6">
        {!! Form::label('status', 'Status') !!}
        {!! Form::select('status', ['' => 'Selecciona', '1' => 'Previa', '2' => 'Definitiva', '3' => 'Cancelada'], null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('status') }}</small>
    </div>
@endif

<div class="form-group">
    {!! Form::label('descripcion', 'Descripción') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('descripcion') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('programa')) has-error @endif">
    {!! Form::label('programa', 'Programa') !!}
    {!! Form::text('programa', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('programa') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('subprograma')) has-error @endif">
    {!! Form::label('subprograma', 'Subprograma') !!}
    {!! Form::text('subprograma', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('subprograma') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('partida_presupuestal', 'Partida Presupuestal') !!}
    {!! Form::text('partida_presupuestal', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('partida_presupuestal') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('codificacion', 'Codificación') !!}
    {!! Form::text('codificacion', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('codificacion') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('presupuesto', 'Presupuesto Total Anual') !!}
    {!! Form::text('presupuesto', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('presupuesto') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('origen_recursos', 'Origen de recursos') !!}
    {!! Form::select('origen_recursos', ['' => 'Origen de recursos', '1' => 'Estatales', '2' => 'Propios', '3' => 'Federales'], null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('origen_recursos') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('telefono', 'Teléfono') !!}
    {!! Form::text('telefono', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('telefono') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('domicilio')) has-error @endif">
    {!! Form::label('domicilio', 'Domicilio') !!}
    {!! Form::text('domicilio', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('domicilio') }}</small>
</div>

<div class="form-group" style="display:none" id="reg">
    {!! Form::label('published_at', 'Publicar en') !!}
    {!! Form::input('datetime-local', 'published_at', date("Y-m-d\TH:i"), ['class' => '', 'placeholder' => 'Publicado en']) !!}
    <small class="text-danger">{{ $errors->first('published_at') }}</small>
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
</div>