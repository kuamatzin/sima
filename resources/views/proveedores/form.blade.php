<div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
    {!! Form::label('nombre', 'Nombre') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('nombre') }}</small>
</div>

<div class="form-group{{ $errors->has('representante') ? ' has-error' : '' }}">
    {!! Form::label('representante', 'Representante') !!}
    {!! Form::text('representante', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('representante') }}</small>
</div>

<div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
    {!! Form::label('telefono', 'Teléfono') !!}
    {!! Form::text('telefono', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('telefono') }}</small>
</div>

<div class="form-group{{ $errors->has('telefono2') ? ' has-error' : '' }}">
    {!! Form::label('telefono2', 'Teléfono 2') !!}
    {!! Form::text('telefono2', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('telefono2') }}</small>
</div>

<div class="form-group{{ $errors->has('telefono3') ? ' has-error' : '' }}">
    {!! Form::label('telefono3', 'Teléfono 3') !!}
    {!! Form::text('telefono3', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('telefono3') }}</small>
</div>

<div class="form-group{{ $errors->has('telefono4') ? ' has-error' : '' }}">
    {!! Form::label('telefono4', 'Teléfono 4') !!}
    {!! Form::text('telefono4', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('telefono4') }}</small>
</div>

<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    {!! Form::label('email', 'Email') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('email') }}</small>
</div>

<div class="form-group{{ $errors->has('email2') ? ' has-error' : '' }}">
    {!! Form::label('email2', 'Email 2') !!}
    {!! Form::text('email2', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('email2') }}</small>
</div>

<div class="form-group{{ $errors->has('email3') ? ' has-error' : '' }}">
    {!! Form::label('email3', 'Email 3') !!}
    {!! Form::text('email3', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('email3') }}</small>
</div>

<div class="form-group{{ $errors->has('email4') ? ' has-error' : '' }}">
    {!! Form::label('email 4', 'Email 4') !!}
    {!! Form::text('email 4', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('email 4') }}</small>
</div>

<div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
    {!! Form::label('direccion', 'Dirección') !!}
    {!! Form::text('direccion', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('direccion') }}</small>
</div>

<div class="form-group{{ $errors->has('rfc') ? ' has-error' : '' }}">
    {!! Form::label('rfc', 'RFC') !!}
    {!! Form::text('rfc', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('rfc') }}</small>
</div>

<div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
    {!! Form::label('status', 'Status') !!}
    {!! Form::select('status', ['' => 'Status', 'Libre' => 'Libre', 'Vetado' => 'Vetado'], null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('status') }}</small>
</div>

<div class="form-group{{ $errors->has('pagina_web') ? ' has-error' : '' }}">
    {!! Form::label('pagina_web', 'Pagina Web') !!}
    {!! Form::text('pagina_web', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('pagina_web') }}</small>
</div>

<div class="form-group{{ $errors->has('folio') ? ' has-error' : '' }}">
    {!! Form::label('folio', 'Folio') !!}
    {!! Form::text('folio', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('folio') }}</small>
</div>

<div class="form-group{{ $errors->has('actividad') ? ' has-error' : '' }}">
    {!! Form::label('actividad', 'Actividad') !!}
    {!! Form::text('actividad', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('actividad') }}</small>
</div>

<div class="form-group{{ $errors->has('estado') ? ' has-error' : '' }}">
    {!! Form::label('estado', 'Estado') !!}
    {!! Form::text('estado', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('estado') }}</small>
</div>

<div class="form-group{{ $errors->has('clabe') ? ' has-error' : '' }}">
    {!! Form::label('clabe', 'Clabe') !!}
    {!! Form::text('clabe', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('clabe') }}</small>
</div>

<div class="form-group">
    <div class="checkbox{{ $errors->has('temporal') ? ' has-error' : '' }}">
        <label for="temporal">
            {!! Form::checkbox('temporal', '1', null, ['id' => 'temporal']) !!} Proveedor Temporal
        </label>
    </div>
    <small class="text-danger">{{ $errors->first('temporal') }}</small>
</div>

<div class="form-group{{ $errors->has('fecha_alta') ? ' has-error' : '' }}">
    {!! Form::label('fecha_alta', 'Fecha Alta') !!}
    {!! Form::text('fecha_alta', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('fecha_alta') }}</small>
</div>

<div class="form-group{{ $errors->has('fecha_recibido_alta') ? ' has-error' : '' }}">
    {!! Form::label('fecha_recibido_alta', 'Fecha Recibido Alta') !!}
    {!! Form::text('fecha_recibido_alta', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('fecha_recibido_alta') }}</small>
</div>

<div class="form-group{{ $errors->has('fecha_renovacion') ? ' has-error' : '' }}">
    {!! Form::label('fecha_renovacion', 'Fecha de renovación') !!}
    {!! Form::text('fecha_renovacion', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('fecha_renovacion') }}</small>
</div>

<div class="form-group{{ $errors->has('fecha_recibido_renovacion') ? ' has-error' : '' }}">
    {!! Form::label('fecha_recibido_renovacion', 'Fecha Recibido Renovación') !!}
    {!! Form::text('fecha_recibido_renovacion', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('fecha_recibido_renovacion') }}</small>
</div>



{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}