<div class="form-group col-md-6">
    {!! Form::label('nombre', 'Nombre') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('nombre') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('calle', 'Calle') !!}
    {!! Form::text('calle', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('calle') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('numero_exterior', 'Número Exterior') !!}
    {!! Form::text('numero_exterior', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('numero_exterior') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('numero_interior', 'Número Interior') !!}
    {!! Form::text('numero_interior', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('numero_interior') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('colonia', 'Colonia') !!}
    {!! Form::text('colonia', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('colonia') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('lada', 'LADA') !!}
    {!! Form::text('lada', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('lada') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('telefono', 'Teléfono') !!}
    {!! Form::text('telefono', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('telefono') }}</small>
</div>  

<div class="form-group col-md-6">
    {!! Form::label('municipio', 'Municipio') !!}
    {!! Form::text('municipio', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('municipio') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('extension', 'Extensión') !!}
    {!! Form::text('extension', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('extension') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('siglas', 'Siglas') !!}
    {!! Form::text('siglas', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('siglas') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('titular', 'Titular') !!}
    {!! Form::text('titular', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('titular') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('cargo_titular', 'Cargo de Titular') !!}
    {!! Form::text('cargo_titular', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('cargo_titular') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('autoriza', 'Autoriza') !!}
    {!! Form::text('autoriza', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('autoriza') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('cargo_autoriza', 'Cargo Autoriza') !!}
    {!! Form::text('cargo_autoriza', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('cargo_autoriza') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('valida', 'Valida') !!}
    {!! Form::text('valida', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('valida') }}</small>
</div>

<div class="form-group col-md-6">
    {!! Form::label('cargo_valida', 'Cargo Valida') !!}
    {!! Form::text('cargo_valida', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('cargo_valida') }}</small>
</div>

<div class="form-group col-md-12">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
</div>