@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            {!! Form::label('proveedor_id', 'Proveedor') !!}
            {!! Form::select('proveedor_id', $proveedores, null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('proveedor_id') }}</small>
            <br>
            <a id="buscar_por_proveedor" href="/carga_economica/{{$procedimiento->id}}?proveedor_id={{$proveedores_ids[0]->id}}">
                <button type="button" class="btn btn-warning pull-right">Seleccionar</button>
            </a>
            <br><br>
            <br>
            @if($ofertas)
                {!! Form::open(['method' => 'POST', 'url' => 'carga_economica/ ' . $procedimiento->id, 'class' => 'form', 'id' => 'form-carga']) !!}
                @foreach($ofertas as $keyOferta => $oferta)
                    <table class="table table-hover" id="{{$oferta->proveedor_id}}_{{$oferta->id}}">
                        <thead>
                            <tr>
                                <th width="3%">Partida</th>
                                <th width="10%">Descripcion</th>
                                <th width="3%">Cantidad</th>
                                <th width="10%">Precio Unitario</th>
                                <th width="10%">Importe sin IVA</th>
                                <th width="10%">IVA</th>
                                <th width="10%">Importe con IVA</th>
                                <th width="10%">Total</th>
                                <th width="10%">Marca</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$oferta->partida->id}}</td>
                                <td>{{$oferta->partida->descripcion}}</td>
                                <td name="{{$oferta->id}}[cantidad_minima]">{{$oferta->partida->cantidad_minima}}</td>
                                <td>
                                    <div class="form-group">
                                        {!! Form::text('' . $oferta->id . '[precio_unitario]', $oferta->getOriginal('precio_unitario'), ['class' => 'form-control', 'required' => 'required']) !!}
                                        <small class="text-danger">{{ $errors->first('precio_unitario') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        {!! Form::text('' . $oferta->id . '[importe_sin_iva]', $oferta->importe_sin_iva, ['class' => 'form-control', 'required' => 'required']) !!}
                                        <small class="text-danger">{{ $errors->first('importe_sin_iva') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        {!! Form::text('' . $oferta->id . '[iva]', $oferta->iva, ['class' => 'form-control', 'required' => 'required']) !!}
                                        <small class="text-danger">{{ $errors->first('iva') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        {!! Form::text('' . $oferta->id . '[importe_con_iva]', $oferta->importe_con_iva, ['class' => 'form-control', 'required' => 'required']) !!}
                                        <small class="text-danger">{{ $errors->first('importe_con_iva') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        {!! Form::text('' . $oferta->id . '[monto_total]', $oferta->getOriginal('monto_total'), ['class' => 'form-control', 'required' => 'required']) !!}
                                        <small class="text-danger">{{ $errors->first('monto_total') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        {!! Form::text('' . $oferta->id . '[marca]', $oferta->marca, ['class' => 'form-control', 'required' => 'required']) !!}
                                        <small class="text-danger">{{ $errors->first('monto_total') }}</small>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endforeach
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        {!! $ofertas->render() !!}
                    </div>
                </div>
                {!! Form::submit("Guardar", ['class' => 'btn btn-success']) !!}
                {!! Form::close() !!}
            @endif 
            <br><br><br>
            {!! Form::open(['url' => 'carga_economica_finalizar/' . $procedimiento->id]) !!}
                <button type="submit" class="btn btn-info">Finalizar carga económica</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        };

        $('li > a').click(function(event){
            event.preventDefault();
            var ruta = this.href;
            var proveedor_id = getUrlParameter('proveedor_id');
            window.location = ruta + '&proveedor_id=' + proveedor_id;
        })

        var selectedInput = null;
        $(function() {
            var proveedor_id = getUrlParameter('proveedor_id');
            if (proveedor_id) {
                $("#proveedor_id").val(proveedor_id);
            }
            $('input, textarea, select').focus(function() {
                selectedInput = this;
                var name = $(selectedInput).attr("name");
                var splitName = name.split("[");
                var id = splitName[0];
                var seccion = splitName[1];
                cantidad_minima = $("[name='" + id + "[cantidad_minima]']").html();
                console.log(seccion);
                if (seccion == "precio_unitario]") {
                    $(selectedInput).on('input', function() {
                        precio_unitario = $(this).val();
                        iva = $("[name='" + id + "[iva]']").val(); 
                        $("[name='" + id + "[importe_sin_iva]']").val(precio_unitario*cantidad_minima)
                        $("[name='" + id + "[importe_con_iva]']").val(precio_unitario*cantidad_minima + precio_unitario*cantidad_minima*(iva/100))
                        $("[name='" + id + "[monto_total]']").val(precio_unitario*cantidad_minima + precio_unitario*cantidad_minima*(iva/100))
                    });
                }
                if (seccion == "iva]") {
                    $(selectedInput).on('input', function() {
                        iva = $(this).val();
                        precio_unitario = $("[name='" + id + "[precio_unitario]']").val();
                        console.log(iva);
                        $("[name='" + id + "[importe_con_iva]']").val(precio_unitario*cantidad_minima + precio_unitario*cantidad_minima*(iva/100))
                        $("[name='" + id + "[monto_total]']").val(precio_unitario*cantidad_minima + precio_unitario*cantidad_minima*(iva/100))
                    });
                }
            }).blur(function(){
                selectedInput = null;
            });
        });
        
        //SOLO FUNCIONA CUANDO UN PROCEDIMIENTO TIENE UNA REQUISICIÓN
        var sel = $( "#proveedor_id" ).val();
        var val = $('*[id^="' + sel + '_"]');
        for (var i = val.length - 1; i >= 0; i--) {
            $(val[i]).show('slow/400/fast');
        };
        /*
        $("#proveedor_id").change(function() {
            for (var i = val.length - 1; i >= 0; i--) {
                $(val[i]).hide('slow/400/fast');
            };
            var sel = $(this).val();
            var val2 = $('*[id^="' + sel + '_"]');
            for (var i = val2.length - 1; i >= 0; i--) {
                $(val2[i]).show('slow/400/fast');
            };
            val = val2;
        });*/
        $("#proveedor_id").change(function() {
            var liga = $('#buscar_por_proveedor').attr('href');
            liga = liga.substring(0, liga.indexOf('=')) + "=" + $(this).val();
            $('#buscar_por_proveedor').attr('href', liga);
        });
    </script>
@endsection
