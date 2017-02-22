@extends('app')

@section('content')
<p><a href="/procedimientos">Procedimientos</a> > <a href="/procedimientos/{{$procedimiento->id}}">{{ $procedimiento->requisiciones[0]->descripcion }}</a> > <a href="/licitantes/{{$procedimiento->id}}">Proveedores</a></p>
<h3>Proveedores Seleccionados</h3>

<table class="table table-hover" id="proveedores_seleccionados">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Representante</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>RFC</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($procedimiento->proveedores as $key => $proveedor)
        <tr id="seleccionado_{{$proveedor->id}}">
            <td>{{$proveedor->nombre}}</td>
            <td>{{$proveedor->representante}}</td>
            <td>{{$proveedor->telefono}}</td>
            <td>{{$proveedor->email}}</td>
            <td>{{$proveedor->rfc}}</td>
            <td>
                <button type="button" class="btn btn-danger" id="{{$proveedor->id}}">Eliminar</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>Agregar Proveedores</h3>

{!! Form::open(['method' => 'POST', 'url' => 'licitantes/' . $procedimiento->id, 'class' => 'form-horizontal']) !!}
    <input type="text" name="search" id="search" class="form-control" placeholder="Fitrar Proveedores">
    <br>
    <table class="table table-bordered table-hover" id="table">
        <thead>
            <tr>
                <th>Selecciona</th>
                <th>Nombre</th>
                <th>Representante</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>RFC</th>
                <th>Cotización Enviada</th>
                <th>Archivo cotización</th>
                <th>Reabrir cotización</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proveedores as $key => $proveedor)
                <tr id="searchable" name="{{$proveedor->id}}">
                    <td>
                        @if($proveedor_array == "create")
                        {!! Form::checkbox('proveedor[]', $proveedor->id, null, ['class' => 'field']) !!}
                        @else
                        {!! Form::checkbox('proveedor[]', $proveedor->id, $proveedor->checkId($proveedor_array), ['class' => 'field', 'id' => 'proveedor_' . $proveedor->id]) !!}
                        @endif
                    </td>
                    <td>
                        {{$proveedor->nombre}}
                    </td>
                    <td>
                        {{$proveedor->representante}}
                    </td>
                    <td>
                        {{$proveedor->telefono}}
                    </td>
                    <td>
                        {{$proveedor->email}}
                    </td>
                    <td>
                        {{$proveedor->rfc}}
                    </td>
                    <td>
                        @if($proveedor->cotizacion_enviada)
                            <button type="button" class="btn btn-success center-block">
                                <i class="fa fa-check"></i>
                            </button>
                        @else
                            <button type="button" class="btn btn-danger center-block">
                                <i class="fa fa-times-circle"></i>
                            </button>
                        @endif
                    </td>
                    <td>
                        @if($proveedor->cotizacion_enviada)
                            <a href="/cotizacionesEnviadas/{{$proveedor->archivo_cotizacion}}" target="_blank">
                                <button type="button" class="btn btn-primary center-block">
                                    <i class="fa fa-download"></i>
                                </button>
                            </a>
                        @endif
                    </td>
                    <td>
                        @if($proveedor->cotizacion_enviada)
                            <a href="/reabrirCotizacion/{{$proveedor->estaInvitacion_id}}">
                                <button type="button" class="btn btn-primary center-block">
                                    Reabrir Cotización
                                </button>
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {!! Form::submit('Guardar' , ['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}
@endsection

@section('scripts')
<script>
    var $rows = $('#table #searchable');
    $('#search').keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
        
        $rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });

    $("#proveedores_seleccionados").delegate("td:nth-child(6)", "click", function() {
        var id = $(this).closest("tr").attr('id');
        id = id.replace("seleccionado_", "");
        var o = $('#proveedor_' + id).prop('checked', false);
        $(this).closest("tr").hide();
    });
</script>
@endsection