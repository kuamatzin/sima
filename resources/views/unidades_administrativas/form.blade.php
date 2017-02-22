<div class="form-group col-md-6 @if($errors->first('nombre')) has-error @endif">
    {!! Form::label('nombre', 'Nombre') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('nombre') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('calle')) has-error @endif">
    {!! Form::label('calle', 'Calle') !!}
    {!! Form::text('calle', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('calle') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('numero_exterior')) has-error @endif">
    {!! Form::label('numero_exterior', 'Número Exterior') !!}
    {!! Form::text('numero_exterior', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('numero_exterior') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('numero_interior')) has-error @endif">
    {!! Form::label('numero_interior', 'Número Interior') !!}
    {!! Form::text('numero_interior', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('numero_interior') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('colonia')) has-error @endif">
    {!! Form::label('colonia', 'Colonia') !!}
    {!! Form::text('colonia', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('colonia') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('municipio')) has-error @endif">
    {!! Form::label('municipio', 'Municipio') !!}
    {!! Form::text('municipio', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('municipio') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('lada')) has-error @endif">
    {!! Form::label('lada', 'Lada') !!}
    {!! Form::text('lada', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('lada') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('telefono')) has-error @endif">
    {!! Form::label('telefono', 'Telefono') !!}
    {!! Form::text('telefono', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('telefono') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('siglas')) has-error @endif">
    {!! Form::label('siglas', 'Siglas') !!}
    {!! Form::text('siglas', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('siglas') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('titular')) has-error @endif">
    {!! Form::label('titular', 'TItular') !!}
    {!! Form::text('titular', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('titular') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('cargo_titular')) has-error @endif">
    {!! Form::label('cargo_titular', 'Cargo Titular') !!}
    {!! Form::text('cargo_titular', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('cargo_titular') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('autoriza')) has-error @endif">
    {!! Form::label('autoriza', 'Autoriza') !!}
    {!! Form::text('autoriza', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('autoriza') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('cargo_autoriza')) has-error @endif">
    {!! Form::label('cargo_autoriza', 'Cargo Autoriza') !!}
    {!! Form::text('cargo_autoriza', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('cargo_autoriza') }}</small>
</div>

<div class="form-group col-md-6 @if($errors->first('valida')) has-error @endif">
    {!! Form::label('valida', 'Valida') !!}
    {!! Form::text('valida', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('valida') }}</small>
</div>

<div class="form-group col-md-12 @if($errors->first('cargo_valida')) has-error @endif">
    {!! Form::label('cargo_valida', 'Cargo Valida') !!}
    {!! Form::text('cargo_valida', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('cargo_valida') }}</small>
</div>
<br><br>
{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary pull-right']) !!}






