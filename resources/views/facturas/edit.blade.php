@extends('app')
@section('content')
<div class="form-group">
    {!! Form::model($factura, ['method' => 'PATCH', 'url' => 'facturas/' . $factura->id]) !!}
    @include('facturas.form', ['submitButtonText' => 'Guardar'])
    {!! Form::close() !!}
</div>
@endsection