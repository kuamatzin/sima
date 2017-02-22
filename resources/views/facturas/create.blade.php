@extends('app')
@section('content')
<div class="col-md-8 col-md-offset-2">
    <h1>Registrar Factura</h1>
    {!! Form::open(['url' => 'facturas/' . $oferta->id]) !!}
    @include('facturas.form', ['submitButtonText' => 'Guardar'])
    {!! Form::close() !!}
</div>
@endsection