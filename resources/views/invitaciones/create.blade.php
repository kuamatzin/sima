@extends('invitacion')

@section('content')
    @if (Session::has('message'))
        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>{{ Session::get('message') }}</strong> 
        </div>
    @endif

    <div class="alert alert-info">
        <strong style="font-size: 18px">Información</strong>
        <hr>
        <strong>1. El sistema permite enviar su cotización llenando el siguiente formulario </strong> <br>
        <strong>2. El sistema le ayuda con el calculo del importe total, sin embargo usted es libre de cambiar los valores que genera el sistema </strong><br>
        <strong>3. Para poder enviar la cotización es necesario generar el documento de la cotización, debe llenar todo el formulario para generarlo y dar click en "Generar Documento" </strong><br>
        <strong>4. Para enviar su cotización final debe imprimir su cotización, firmarlo, escanearlo y adjuntar ese archivo para mandar su cotización final dando click en "Guardar Cotización"</strong> <br>
        <strong>5. Verifique que todos los datos antes de enviar la cotización final</strong>
    </div>

    <h2>{{$invitacion->proveedor->nombre}}</h2>
    
    <h3>{{$invitacion->procedimiento->requisiciones[0]->descripcion}}</h3>

    <br>

    <div class="panel panel-default">
        <div class="panel-body">
            <p><strong>Requisitos Técnicos</strong></p>
            @if($invitacion->procedimiento->requisiciones[0]->lista_requisitos)
            <ul>
                @foreach($invitacion->procedimiento->requisiciones[0]->lista_requisitos as $key => $requisito)
                    <li>{{$requisito}}</li>
                @endforeach
            </ul>
            @endif
            <p>
                {{$invitacion->procedimiento->requisiciones[0]->requisitos_tecnicos}}
            </p>
            <hr>
            <p><strong>Requisitos Económicos</strong></p>
            <p>
                {{$invitacion->procedimiento->requisiciones[0]->requisitos_economicos}}
            </p>
            <hr>
            <p><strong>Requisitos Informativos</strong></p>
            <p>
                {{$invitacion->procedimiento->requisiciones[0]->requisitos_informativos}}
            </p>
            <p>
                Vigencia de contrato: {{$invitacion->procedimiento->requisiciones[0]->getVigencia()}}
            </p>
            <hr>
            <p><strong>Condiciones de Pago</strong></p>
            <p>
                {{$invitacion->procedimiento->requisiciones[0]->condiciones_pago}}
            </p>
            <p>ANTICIPO: {{$invitacion->procedimiento->requisiciones[0]->anticipo}}</p>
            <hr>
            <p><strong>Lugar de Entrega</strong></p>
            <p>
                {{$invitacion->procedimiento->requisiciones[0]->lugar_entrega}}
            </p>
            <hr>
            <p><strong>Tiempo de Entrega</strong></p>
            <p>
                {{$invitacion->procedimiento->requisiciones[0]->tiempo_entrega}}
            </p>
            <p>
                DIAS DE ENTREGA: {{$invitacion->procedimiento->requisiciones[0]->dias_entrega_lunes_viernes}}
            </p>
            <p>
                HORARIO DE ENTREGA: DE {{$invitacion->procedimiento->requisiciones[0]->hora_entrega_inicial}} A {{$invitacion->procedimiento->requisiciones[0]->hora_entrega_final}}
            </p>
            <hr>
            <p><strong>Datos de Facturación</strong></p>
            <p>
                {{$invitacion->procedimiento->requisiciones[0]->datos_facturacion}}
            </p>
            <hr>
        </div>
    </div>

    <hr>
    <input type="hidden" class="form-control" id="numPartidas" value="{{$partidas->count()}}" v-model="numeroPartidas">
    {!! Form::open(['url' => 'cotizacion/' .  $invitacion->url, 'files' => true]) !!}
        @foreach($partidas as $key => $partida)
        <div class="panel panel-success">
            <div class="panel-heading">
                @if($pagina == 1)
                <h3 class="panel-title">Partida {{$key+1}} . {{$partida->descripcion}} <span class="pull-right">Unidad de medida: {{$partida->unidad_medida}}</span></h3>
                @else
                <h3 class="panel-title">Partida {{$pagina + ($key+1)}} . {{$partida->descripcion}} <span class="pull-right">Unidad de medida: {{$partida->unidad_medida}}</span></h3>
                @endif
            </div>
            <!-- Si ya existe una oferta capturada -->
            @if($ofertas_proveedor->where('partida_id', $partida->id)->first())
                <div class="panel-body">
                    <div class="row">
                        <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif" id="{{$partida->id}}">
                            {!! Form::label($partida->id, 'Cantidad') !!}
                            {!! Form::text($partida->id . '_cantidad', $ofertas_proveedor->where('partida_id', $partida->id)->first()->cantidad, ['class' => 'form-control', 'required' => 'required', 'id' => $key . '_cantidad', 'readonly']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                            {!! Form::label($partida->id, 'Precio Unitario') !!}
                            {!! Form::text($partida->id . '_precio_unitario', $ofertas_proveedor->where('partida_id', $partida->id)->first()->precio_unitario, ['class' => 'form-control', 'required' => 'required', 'id' => $key . '_precio_unitario']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                            {!! Form::label($partida->id, 'Importe sin IVA') !!}
                            {!! Form::text($partida->id . '_importe_sin_iva', $ofertas_proveedor->where('partida_id', $partida->id)->first()->importe_sin_iva, ['class' => 'form-control', 'required' => 'required', 'id' => $key . '_importe_sin_iva', 'readonly']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        <div class="form-group col-md-1 @if($errors->first($partida->id)) has-error @endif">
                            {!! Form::label($partida->id, 'IVA') !!}
                            {!! Form::text($partida->id . '_iva', $ofertas_proveedor->where('partida_id', $partida->id)->first()->iva, ['class' => 'form-control', 'required' => 'required', 'id' => $key . '_iva']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                            {!! Form::label($partida->id, 'Importe con IVA') !!}
                            {!! Form::text($partida->id . '_importe_con_iva', $ofertas_proveedor->where('partida_id', $partida->id)->first()->importe_con_iva, ['class' => 'form-control', 'required' => 'required', 'id' => $key . '_importe_con_iva', 'readonly']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                            {!! Form::label($partida->id, 'Total') !!}
                            {!! Form::text($partida->id . '_monto_total', $ofertas_proveedor->where('partida_id', $partida->id)->first()->monto_total, ['class' => 'form-control', 'required' => 'required', 'id' => $key . '_monto_total', 'readonly']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        @if($partida->marca == '')
                        <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                            {!! Form::label($partida->id, 'Marca') !!}
                            {!! Form::text($partida->id . '_marca', $ofertas_proveedor->where('partida_id', $partida->id)->first()->marca, ['class' => 'form-control', 'id' => $key . '_marca']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        @else
                        <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                            {!! Form::label($partida->id, 'Marca') !!}
                            {!! Form::text($partida->id . '_marca', $ofertas_proveedor->where('partida_id', $partida->id)->first()->marca, ['class' => 'form-control', 'required' => 'required', 'id' => $key . '_marca', 'readonly']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        @endif

                        @if($partida->clave == '')
                        <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                            {!! Form::label($partida->id, 'Clave o Modelo') !!}
                            {!! Form::text($partida->id . '_clave', $ofertas_proveedor->where('partida_id', $partida->id)->first()->clave, ['class' => 'form-control', 'id' => $key . '_clave']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        @else
                        <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                            {!! Form::label($partida->id, 'Clave o Modelo') !!}
                            {!! Form::text($partida->id . '_clave', $ofertas_proveedor->where('partida_id', $partida->id)->first()->clave, ['class' => 'form-control', 'required' => 'required', 'id' => $key . '_clave', 'readonly']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        @endif

                        <div class="form-group col-md-6 @if($errors->first('descripcion')) has-error @endif">
                            {!! Form::label('descripcion', 'Descripcion Técnica') !!}
                            {!! Form::text($partida->id . '_descripcion', null, ['class' => 'form-control', 'id' => $key . '_descripcion']) !!}
                            <small class="text-danger">{{ $errors->first('descripcion') }}</small>
                        </div>
                    </div>
                </div>
            @else
                <div class="panel-body">
                    <div class="row">
                        <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif" id="{{$partida->id}}">
                            {!! Form::label($partida->id, 'Cantidad') !!}
                            {!! Form::text($partida->id . '_cantidad', $partida->cantidad_minima, ['class' => 'form-control', 'required' => 'required', 'id' => $key . '_cantidad', 'readonly']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                            {!! Form::label($partida->id, 'Precio Unitario') !!}
                            {!! Form::text($partida->id . '_precio_unitario', null, ['class' => 'form-control', 'required' => 'required', 'id' => $key . '_precio_unitario']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                            {!! Form::label($partida->id, 'Importe sin IVA') !!}
                            {!! Form::text($partida->id . '_importe_sin_iva', null, ['class' => 'form-control', 'required' => 'required', 'id' => $key . '_importe_sin_iva', 'readonly']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        <div class="form-group col-md-1 @if($errors->first($partida->id)) has-error @endif">
                            {!! Form::label($partida->id, 'IVA') !!}
                            {!! Form::text($partida->id . '_iva', 16, ['class' => 'form-control', 'required' => 'required', 'id' => $key . '_iva']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                            {!! Form::label($partida->id, 'Importe con IVA') !!}
                            {!! Form::text($partida->id . '_importe_con_iva', null, ['class' => 'form-control', 'required' => 'required', 'id' => $key . '_importe_con_iva', 'readonly']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                            {!! Form::label($partida->id, 'Total') !!}
                            {!! Form::text($partida->id . '_monto_total', null, ['class' => 'form-control', 'required' => 'required', 'id' => $key . '_monto_total', 'readonly']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        @if($partida->marca == '')
                        <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                            {!! Form::label($partida->id, 'Marca') !!}
                            {!! Form::text($partida->id . '_marca', $partida->marca, ['class' => 'form-control', 'id' => $key . '_marca']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        @else
                        <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                            {!! Form::label($partida->id, 'Marca') !!}
                            {!! Form::text($partida->id . '_marca', $partida->marca, ['class' => 'form-control', 'required' => 'required', 'id' => $key . '_marca', 'readonly']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>
                        @endif

                        <div class="form-group col-md-2 @if($errors->first($partida->id)) has-error @endif">
                            {!! Form::label($partida->id, 'Clave/Modelo') !!}
                            {!! Form::text($partida->id . '_clave', $partida->clave, ['class' => 'form-control', 'id' => $key . '_clave']) !!}
                            <small class="text-danger">{{ $errors->first($partida->id) }}</small>
                        </div>

                        <div class="form-group col-md-6 @if($errors->first('descripcion')) has-error @endif">
                            {!! Form::label('descripcion', 'Descripcion Técnica') !!}
                            {!! Form::text($partida->id . '_descripcion', null, ['class' => 'form-control', 'id' => $key . '_descripcion']) !!}
                            <small class="text-danger">{{ $errors->first('descripcion') }}</small>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @endforeach
        <hr>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                {!! $partidas->render() !!}
            </div>
        </div>
        <hr>
        @if($pagina == 1 || $pagina == 0)
        <div class="row">
            <div class="col-md-4">
                <button type="submit" class="btn btn-success" name="documento" value="true">Generar Documento</button>
            </div>
            <div class="col-md-4">
                <div class="form-group" @if($errors->first('formato')) has-error @endif>
                    {!! Form::label('formato', 'Subir Formato') !!}
                    {!! Form::file('formato', []) !!}
                    <small class="text-danger">{{ $errors->first('formato') }}</small>
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-warning" name="guardar" value="true">Guardar Cotizacion</button>
            </div>
        </div>
        @endif
        
    {!! Form::close() !!}
       
@endsection

@section('scripts')
<script>
    $('a').click(function(event){
        event.preventDefault();

        var query_string = "";
        var ruta = this.href;
        var numeroPartidas = $('#numPartidas').val();
        for (var i = 0; i < numeroPartidas; i++) {
            var cantidad = $("#" + i + "_cantidad").val();
            var precio_unitario = $("#" + i + "_precio_unitario").val();
            var importe_sin_iva = $("#" + i + "_importe_sin_iva").val();
            var iva = $("#" + i + "_iva").val();
            var importe_con_iva = $("#" + i + "_importe_con_iva").val();
            var monto_total = $("#" + i + "_monto_total").val();
            var marca = $("#" + i + "_marca").val();
            var partida_id = $("#" + i + "_cantidad").closest("div").attr("id");
            query_string = query_string + "&" + i + "partida[]=" + partida_id + "&" + i + "partida[]=" + cantidad + "&" + i + "partida[]=" + precio_unitario + "&" + i + "partida[]=" + importe_sin_iva + "&" + i + "partida[]=" + iva + "&" + i + "partida[]=" + importe_con_iva + "&" + i + "partida[]=" + monto_total + "&" + i + "partida[]=" + marca;
        }
        
        window.location = ruta + query_string;
    })
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
                //console.log(seccion)
                cantidad_minima = $("[name='" + id + "_cantidad']").val();
                if (seccion == "cantidad") {
                    $(selectedInput).on('input', function() {
                        precio_unitario = $(this).val();
                        iva = $("[name='" + id + "_iva']").val();
                        $("[name='" + id + "_importe_sin_iva']").val(precio_unitario*cantidad_minima)
                        $("[name='" + id + "_importe_con_iva']").val(precio_unitario*cantidad_minima + precio_unitario*cantidad_minima*(iva/100))
                        $("[name='" + id + "_monto_total']").val(precio_unitario*cantidad_minima + precio_unitario*cantidad_minima*(iva/100))
                    });
                }
                //console.log(cantidad_minima)
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
                        //console.log(iva);
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