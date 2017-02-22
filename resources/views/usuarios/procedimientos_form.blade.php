<div class="form-group @if($errors->first('name')) has-error @endif">
    {!! Form::label('name', 'Nombre y Apellidos') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('name') }}</small>
</div>

<div class="form-group @if($errors->first('email')) has-error @endif">
    {!! Form::label('email', 'Email') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'required' => '', 'placeholder' => 'eg: foo@bar.com']) !!}
    <small class="text-danger">{{ $errors->first('email') }}</small>
</div>

<div class="form-group @if($errors->first('privilegios')) has-error @endif">
    {!! Form::label('privilegios', 'Tipo de Usuario') !!}
    {!! Form::select('privilegios', [0 => 'Tipo de Usuario', 5 => 'Analista Procedimiento'], null, ['id' => 'privilegios', 'class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('privilegios') }}</small>
</div>

<div class="form-group @if($errors->first('password')) has-error @endif">
    {!! Form::label('password', 'Password') !!}
    {!! Form::password('password', ['class' => 'form-control', 'required' => '']) !!}
    <small class="text-danger">{{ $errors->first('password') }}</small>
</div>

<div class="form-group @if($errors->first('password_confirmation')) has-error @endif">
    {!! Form::label('password_confirmation', 'Password') !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
</div>

<button type="submit" class="btn btn-success pull-right">{{$submitButtonText}}</button>