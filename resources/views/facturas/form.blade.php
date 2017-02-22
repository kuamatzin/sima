<div class="form-group{{ $errors->has('numero_factura') ? ' has-error' : '' }}">
    {!! Form::label('numero_factura', 'Número de Factura') !!}
    {!! Form::text('numero_factura', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('numero_factura') }}</small>
</div>
<div class="form-group{{ $errors->has('monto') ? ' has-error' : '' }}">
    {!! Form::label('monto', 'Monto') !!}
    {!! Form::text('monto', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('monto') }}</small>
</div>
<div class="form-group{{ $errors->has('numero_orden') ? ' has-error' : '' }}">
    {!! Form::label('numero_orden', 'Número de oficio de trámite de pago') !!}
    {!! Form::text('numero_orden', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('numero_orden') }}</small>
</div>
<div class="form-group{{ $errors->has('fecha_pedido') ? ' has-error' : '' }}">
    {!! Form::label('fecha_pedido', 'Fecha de pedido') !!}
    {!! Form::input('date', 'fecha_pedido', date("Y-m-d"), ['class' => '', 'placeholder' => 'Publicado en']) !!}
    <small class="text-danger">{{ $errors->first('fecha_pedido') }}</small>
</div>
<div class="form-group{{ $errors->has('fecha_factura') ? ' has-error' : '' }}">
    {!! Form::label('fecha_factura', 'Fecha de factura') !!}
    {!! Form::input('date', 'fecha_factura', date("Y-m-d"), ['class' => '', 'placeholder' => 'Publicado en']) !!}
    <small class="text-danger">{{ $errors->first('fecha_factura') }}</small>
</div>
<div class="form-group{{ $errors->has('fecha_tramite_pago') ? ' has-error' : '' }}">
    {!! Form::label('fecha_tramite_pago', 'Fecha de trámite de pago') !!}
    {!! Form::input('date', 'fecha_tramite_pago', date("Y-m-d"), ['class' => '', 'placeholder' => 'Publicado en']) !!}
    <small class="text-danger">{{ $errors->first('fecha_tramite_pago') }}</small>
</div>

<button type="submit" class="btn btn-success">{{$submitButtonText}}</button>