@extends('app')

@section('content')
    <h2>{{$invitacion->proveedor->nombre}}</h2>
    <hr>
    {!! Form::open(['url' => '/descargarCotizacionProveedor/' .  $invitacion->id]) !!}
        @foreach($invitacion->procedimiento->requisiciones[0]->partidas as $key => $partida)
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Cotización para la partida: {{$partida->descripcion}}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                        {!! Form::label($partida->id, 'Cantidad') !!}
                        {!! Form::text($partida->id . '_cantidad', $partida->cantidad_minima, ['class' => 'form-control', 'required' => 'required']) !!}
                        <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                    </div>
                    <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                        {!! Form::label($partida->id, 'Precio Unitario') !!}
                        {!! Form::text($partida->id . '_precio_unitario', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                    </div>
                    <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                        {!! Form::label($partida->id, 'Importe sin IVA') !!}
                        {!! Form::text($partida->id . '_importe_sin_iva', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                    </div>
                    <div class="form-group col-md-1 @if($errors->first($partida->id)) has-error @endif">
                        {!! Form::label($partida->id, 'IVA') !!}
                        {!! Form::text($partida->id . '_iva', 16, ['class' => 'form-control', 'required' => 'required']) !!}
                        <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                    </div>
                    <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                        {!! Form::label($partida->id, 'Importe con IVA') !!}
                        {!! Form::text($partida->id . '_importe_con_iva', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                    </div>
                    <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                        {!! Form::label($partida->id, 'Total') !!}
                        {!! Form::text($partida->id . '_monto_total', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                    </div>
                    <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                        {!! Form::label($partida->id, 'Marca') !!}
                        {!! Form::text($partida->id . '_marca', $partida->marca, ['class' => 'form-control', 'required' => 'required']) !!}
                        <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                    </div>

                    <div class="form-group col-md-6 @if($errors->first('descripcion')) has-error @endif">
                        {!! Form::label('descripcion', 'Descripcion Técnica') !!}
                        {!! Form::text('descripcion', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        <small class="text-danger">{{ $errors->first('descripcion') }}</small>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="row">
            <div class="col-md-4">
                <button type="submit" class="btn btn-success" name="documento" value="true">Generar Documento</button>
            </div>
            <div class="col-md-4">
                <div class="form-group" @if($errors->first('formato')) has-error @endif>
                    {!! Form::label('formato', 'Subir Formato') !!}
                    {!! Form::file('formato', ['required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('formato') }}</small>
                </div>
            </div>
            <div class="col-md-4">
                <button class="btn btn-warning" name="guardar" value="true">Guardar Cotizacion</button>
            </div>
        </div>
     {!! Form::close() !!}
       
@endsection

@section('scripts')
<script>
    var selectedInput = null;
        $(function() {
            $('input, textarea, select').focus(function() {
                selectedInput = this;
                var name = $(selectedInput).attr("name");

                var splitName = name.split("_");
                if (splitName.length == 3) {
                    var id = splitName[0];
                    var seccion1 = splitName[1];
                    var seccion2 = splitName[2];
                    var seccion = seccion1 + '_' + seccion2;
                }
                else {
                    var id = splitName[0];
                    var seccion = splitName[1];
                }
                console.log(seccion)
                cantidad_minima = $("[name='" + id + "_cantidad']").val();
                console.log(cantidad_minima)
                if (seccion == "precio_unitario") {
                    $(selectedInput).on('input', function() {
                        precio_unitario = $(this).val();
                        iva = $("[name='" + id + "_iva']").val();
                        $("[name='" + id + "_importe_sin_iva']").val(precio_unitario*cantidad_minima)
                        $("[name='" + id + "_importe_con_iva']").val(precio_unitario*cantidad_minima + precio_unitario*cantidad_minima*(iva/100))
                        $("[name='" + id + "_monto_total']").val(precio_unitario*cantidad_minima + precio_unitario*cantidad_minima*(iva/100))
                    });
                }
                if (seccion == "iva") {
                    $(selectedInput).on('input', function() {
                        iva = $(this).val();
                        precio_unitario = $("[name='" + id + "_precio_unitario']").val();
                        console.log(iva);
                        $("[name='" + id + "_importe_con_iva']").val(precio_unitario*cantidad_minima + precio_unitario*cantidad_minima*(iva/100))
                        $("[name='" + id + "_monto_total']").val(precio_unitario*cantidad_minima + precio_unitario*cantidad_minima*(iva/100))
                    });
                }
            }).blur(function(){
                selectedInput = null;
            });
        });
</script>
@endsection