<h1>Partidas</h1>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <td>No</td>
            <th>Descripcion</th>
            <th>Cantidad</th>
            <th>Marca o Modelo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($procedimiento->requisiciones[0]->partidas as $key => $partida)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$partida->descripcion}}</td>
                <td>{{$partida->cantidad_minima}}</td>
                <td>{{$partida->marca}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<h3>Proveedores</h3>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Selecciona</th>
            <th>Nombre</th>
            <th>Representante</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>RFC</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($proveedores as $key => $proveedor)
            <tr>
                <td>
                    @if($proveedor_array == "create")
                    {!! Form::checkbox('proveedor[]', $proveedor->id, null, ['class' => 'field']) !!}
                    @else
                    {!! Form::checkbox('proveedor[]', $proveedor->id, $proveedor->checkId($proveedor_array), ['class' => 'field']) !!}
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
            </tr>
        @endforeach
    </tbody>
</table>
<hr>
<h3>Datos Generales</h3>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('evneto', 'Evento') !!}
            {!! Form::text('evneto', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('evneto') }}</small>
        </div>
        <div class="form-group">
            {!! Form::label('fecha_inicial', 'Fecha Inicial') !!}
            {!! Form::input('date', 'fecha_inicial', date('Y-m-d'),  array('class'=>'form-control')) !!}
            <small class="text-danger">{{ $errors->first('date') }}</small>
        </div>
        <div class="form-group">
            {!! Form::label('fecha_final', 'Fecha Final') !!}
            {!! Form::input('date', 'fecha_final', date('Y-m-d'),  array('class'=>'form-control')) !!}
            <small class="text-danger">{{ $errors->first('fecha_final') }}</small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('pedido', 'Pedido') !!}
            {!! Form::text('pedido', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('pedido') }}</small>
        </div>

        <div class="form-group">
            {!! Form::label('fecha_conclusion', 'Fecha Conclusión') !!}
            {!! Form::input('date', 'fecha_conclusion', date('Y-m-d'),  array('class'=>'form-control')) !!}
            <small class="text-danger">{{ $errors->first('fecha_conclusion') }}</small>
        </div>

        <div class="form-group">
            {!! Form::label('numero_factura', 'Número de Factura') !!}
            {!! Form::text('numero_factura', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('numero_factura') }}</small>
        </div>

        <div class="form-group">
            {!! Form::label('fecha_factura', 'Fecha de Factura') !!}
            {!! Form::input('date', 'fecha_factura', date('Y-m-d'),  array('class'=>'form-control')) !!}
            <small class="text-danger">{{ $errors->first('fecha_factura') }}</small>
        </div>

        <div class="form-group">
            {!! Form::label('tramite_pago', 'Trámite de Pago') !!}
            {!! Form::text('tramite_pago', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('tramite_pago') }}</small>
        </div>
    </div>
</div>