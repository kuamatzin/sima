@if(Auth::user()->isAnalista() || Auth::user()->isAnalistaUnidad())
<div class="form-group">
{!! Form::hidden('dependencia_id', Auth::user()->dependencia->id) !!}
</div>
@else
<div class="form-group @if($errors->first('dependecia_id')) has-error @endif">
    {!! Form::label('dependencia_id', 'Dependencia') !!}
    {!! Form::select('dependencia_id', $dependencias, null, ['id' => 'dependecia_id', 'class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('dependecia_id') }}</small>
</div>
@endif

<div class="form-group @if($errors->first('presupuesto_total_anual')) has-error @endif">
    {!! Form::label('presupuesto_total_anual', 'Presupuesto Total Anual') !!}
    {!! Form::text('presupuesto_total_anual', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('presupuesto_total_anual') }}</small>
</div>

<div class="form-group @if($errors->first('domicilio')) has-error @endif">
    {!! Form::label('domicilio', 'Domicilio') !!}
    {!! Form::text('domicilio', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('domicilio') }}</small>
</div>

<div class="form-group @if($errors->first('telefono')) has-error @endif">
    {!! Form::label('telefono', 'Teléfono') !!}
    {!! Form::text('telefono', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('telefono') }}</small>
</div>

<div class="form-group @if($errors->first('programa')) has-error @endif">
    {!! Form::label('programa', 'Programa') !!}
    {!! Form::text('programa', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('programa') }}</small>
</div>

<div class="form-group @if($errors->first('subprograma')) has-error @endif">
    {!! Form::label('subprograma', 'Subprograma') !!}
    {!! Form::text('subprograma', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('subprograma') }}</small>
</div>

<div class="form-group @if($errors->first('fuente_financiamiento')) has-error @endif">
    {!! Form::label('fuente_financiamiento', 'Fuente de Financiamiento') !!}
    {!! Form::select('fuente_financiamiento', ['' => 'Origen de recursos', '1' => 'Estatales', '2' => 'Propios', '3' => 'Federales'], $programa_anual->getOriginal('fuente_financiamiento'), ['id' => 'fuente_financiamiento', 'class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('fuente_financiamiento') }}</small>
</div>

<button type="submit" class="btn btn-primary">{{$submitButtonText}}</button>