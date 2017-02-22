<div class="form-group">
    {!! Form::label('name', 'Nombre y Apellidos') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('name') }}</small>
</div>

<div class="form-group">
    {!! Form::label('email', 'Email') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'eg: foo@bar.com']) !!}
    <small class="text-danger">{{ $errors->first('email') }}</small>
</div>

<div class="form-group">
    {!! Form::label('privilegios', 'Tipo de usuario') !!}
    {!! Form::select('privilegios', ['' => 'Tipo de usuario', '1' => 'Administrador', '2' => 'Monitor', '3' => 'Analista'], null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('privilegios') }}</small>
</div>

<div class="form-group">
    {!! Form::label('dependencia_id', 'Dependencia') !!}
    {!! Form::select('dependencia_id', $dependencias, null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('dependencia_id') }}</small>
</div>

<div class="form-group">
    {!! Form::label('password', 'Password') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('password') }}</small>
</div>

<div class="form-group">
    {!! Form::label('password_confirmation', 'Confirmar password') !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
</div>
