@extends('app')

@section('content2')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dictámen Técnico</div>
                <div class="panel-body carga-economica">
                    <p>Analista: {{$procedimiento->analista->name}}</p>
                    @foreach($procedimiento->requisiciones as $key => $requisicion)
                    <h3>{{$requisicion->descripcion}}</h3><br>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="col-md-1">Partida</th>
                                    <th class="col-md-1">Descripción</th>
                                    @foreach($proveedores as $key1 => $proveedor)
                                        <th class="col-md-1">{{$proveedor->nombre}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                {!! Form::open(['method' => 'POST', 'url' => 'dictamen_tecnico/ ' . $procedimiento->id, 'class' => 'form-horizontal']) !!}
                                    {!! Form::hidden('procedimiento', $procedimiento->id) !!}
                                    @foreach($requisicion->partidas as $key2 => $partida)
                                    <tr>
                                        <td>{{$key2+1}}</td>
                                        <td>{{$partida->descripcion}}</td>
                                        @foreach($proveedores as $key3 => $proveedor)
                                            <td>
                                                <div class="form-gr oup">
                                                {!! Form::select('partida_proveedor['.$partida->id . '_' . $proveedor->id.']', [1 => 'Aceptado', 2 => 'No Cumple', 5 => 'No Cotiza'], $partida_proveedor[$partida->id . "_" . $proveedor->id], ['class' => 'form-control', 'id' => $key2+1 . "_" . $proveedor->id]) !!}
                                                <small class="text-danger">{{ $errors->first('inputname') }}</small>
                                                <br>
                                                <div
                                                class="form-group" 
                                                id="partida_proveedor{{$partida->id}}_{{$proveedor->id}}"
                                                name="{{$key2+1 . "_" . $proveedor->id}}"
                                                @if($partida->motivo($proveedor->id) == '')
                                                    style="display:none"
                                                @endif
                                                >
                                                    {!! Form::label('motivo', 'Motivo') !!}
                                                    {!! Form::text('motivo_partida_proveedor['.$partida->id . '_' . $proveedor->id.']', $partida->motivo($proveedor->id), ['class' => 'form-control', 'name' => $key2+1 . "_" . $proveedor->id . "m"]) !!}
                                                    <small class="text-danger">{{ $errors->first('motivo') }}</small>
                                                </div>
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    @endforeach
                    </div>
                </div>
                <div class="btn-group pull-right">
                    <br><br>
                    {!! Form::submit("Guardar", ['class' => 'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
            <a href="/crear_dictamen_tecnico/{{$procedimiento->id}}">
                <button type="button" class="btn btn-primary">Dictamen Técnico</button>
            </a>
            <br><br><br>
            <h3>Operaciones Masivas</h3>
            <br>
            <div class="row">
                <div class="form-group col-md-3 @if($errors->first('proveedor_masiva')) has-error @endif">
                    {!! Form::label('proveedor_masiva', 'Proveedor') !!}
                    {!! Form::select('proveedor_masiva', $proveedores->pluck('nombre', 'id')->toArray(), null, ['id' => 'proveedor_masiva', 'class' => 'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('proveedor_masiva') }}</small>
                </div>
                <div class="form-group col-md-2 @if($errors->first('partidas-modificar')) has-error @endif">
                    {!! Form::label('partidas-modificar', 'Partidas a Modificar') !!}
                    {!! Form::text('partidas-modificar', null, ['class' => 'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('partidas-modificar') }}</small>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3 @if($errors->first('select-opcion')) has-error @endif">
                    {!! Form::label('select-opcion', 'Estatus') !!}
                    {!! Form::select('select-opcion', [ 1 => 'Aceptado', 2 => 'No Cumple', 5 => "No Cotiza"], null, ['id' => 'select-opcion', 'class' => 'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('select-opcion') }}</small>
                </div>
                <div class="form-group col-md-6 @if($errors->first('motivo-masivo')) has-error @endif">
                    {!! Form::label('motivo-masivo', 'Motivo') !!}
                    {!! Form::text('motivo-masivo', null, ['class' => 'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('motivo-masivo') }}</small>
                </div>
            </div>
            <br>
            <button type="button" id="carga-masiva-button" class="btn btn-warning">Aplicar</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(".carga-economica select").change(function() {
        var id = $(this).attr('name');
        id = id.replace('[', '');
        id = id.replace(']', '');
        cambiarSelect($(this).val(), '#' + id);
    }); 

    $("#carga-masiva-button").click(function(event) {
        var proveedor = $("#proveedor_masiva").val();
        var partidas = $("#partidas-modificar").val();
        var estatus = $("#select-opcion").val();
        var motivo = $("#motivo-masivo").val();

        if(partidas.indexOf('-') > -1) {
            var partidas = partidas.split("-");
            var partida_inicial = partidas[0];
            var partida_final = partidas[1];
            for(var i = partida_inicial; i <= partida_final; i++){
                cambiarDatos(i, proveedor, estatus, motivo);
            }
        }

        else if (partidas.indexOf(',') > -1) {
            var partidas = partidas.split(",");
            partidas.forEach(function(i, index){
                cambiarDatos(i, proveedor, estatus, motivo);
            });
        }

        else {
            cambiarDatos(partidas, proveedor, estatus, motivo);
        }
    });

    function cambiarDatos(partida, proveedor, estatus, motivo){
        var seleccionar = partida + "_" + proveedor;
        $("#"+seleccionar).val(estatus);
        cambiarSelect(estatus, '[name="'+seleccionar+'"]');
        $('[name="'+seleccionar+'m"]').val(motivo);
    }
    
    function cambiarSelect(estatus, seleccionar){
        if (estatus == 2 || estatus == 5) {
            $(seleccionar).show('slow/400/fast');
        }
        else {
            $(seleccionar).hide('slow/400/fast');
        }
    }
</script>
@endsection
