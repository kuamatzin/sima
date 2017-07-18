@extends('app')

@section('content')
<div id="app">
    <!--<form action="/reportes/busqueda" method="GET" role="form">-->
        <legend>Reportes</legend>
        <div class="row">
            <div class="form-group col-md-4">
            {!! Form::open(['url' => '/reportes/descargar', 'method' => 'GET']) !!}
                <div class="form-group{{ $errors->has('tipo_procedimiento') ? ' has-error' : '' }}">
                    {!! Form::label('tipo_procedimiento', 'Tipo de Procedimiento') !!}
                    {!! Form::select('tipo_procedimiento', [0 => 'Indiferente', 1 => 'Adjudicación Directa', 2 => 'Invitación a cuando menos 3', 3 => 'Licitación Pública' ], 0, ['id' => 'tipo_procedimiento', 'class' => 'form-control', 'v-model' => 'tipo_procedimiento']) !!}
                    <small class="text-danger">{{ $errors->first('tipo_procedimiento') }}</small>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label for="">Dependencia</label>
                {!! Form::select('dependencia_id', $dependencias, null, ['class' => 'form-control', 'v-model' => 'dependencia_id']) !!}
                </select>
            </div>
            <div class="form-group col-md-4">
                <div class="form-group{{ $errors->has('ejercicio_fiscal') ? ' has-error' : '' }}">
                    {!! Form::label('ejercicio_fiscal', 'Ejercicio Fiscal') !!}
                    {!! Form::select('ejercicio_fiscal',[2016 => '2016', 2017 => '2017'],2016, ['id' => 'ejercicio_fiscal', 'class' => 'form-control', 'v-model' => 'ejercicio_fiscal']) !!}
                    <small class="text-danger">{{ $errors->first('ejercicio_fiscal') }}</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Usuario</label>
                {!! Form::select('usuario_id', $usuarios, null, ['class' => 'form-control', 'v-model' => 'usuario_id']) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('status', 'Status') !!}
                {!! Form::select('status', ['' => 'Indiferente', 0 => 'Status pendiente', 1 => 'Creado', 2 => 'En cotización', 3 => 'Dictamen Técnico', 4 => 'Carga Económica', 5 => 'Analisis Comparativo', 6 => 'Pedido', 7 => 'Factura', 8 => 'Cancelado'], null, ['id' => 'status', 'class' => 'form-control', 'v-model' => 'status']) !!}
                <small class="text-danger">{{ $errors->first('status') }}</small>
            </div>
            <div class="form-group col-md-4 {{ $errors->has('proveedor') ? ' has-error' : '' }}">
                {!! Form::label('proveedor', 'Proveedor') !!}
                {!! Form::select('proveedor', $proveedores, null, ['id' => 'proveedor', 'class' => 'form-control', 'v-model' => 'proveedor']) !!}
                <small class="text-danger">{{ $errors->first('proveedor') }}</small>
            </div>
        </div>
        <button type="submit" class="btn btn-success pull-right">Descargar</button>
        {!! Form::close() !!}
        <a class="btn btn-primary" v-on:click="busqueda">Buscar</a>
        <a class="btn btn-warning" href="/ganadores">Ver Proveedores Adjudicados</a>
    <hr>
    <legend>Busqueda por Codificacion</legend>
    <div class="row">
        <div class="form-group col-md-4">
            <div class="form-group{{ $errors->has('procedimiento') ? ' has-error' : '' }}">
                {!! Form::label('procedimiento', 'Procedimiento') !!}
                {!! Form::text('procedimiento', null, ['class' => 'form-control', 'v-model' => 'codificacion']) !!}
                <small class="text-danger">{{ $errors->first('procedimiento') }}</small>
            </div>
            <button type="button" class="btn btn-primary" v-on:click="buscar_por_procedimiento">Buscar</button>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <img width="130px" src="http://intuitglobal.intuit.com/delivery/cms/prod/sites/default/intuit.ca/images/quickbooks-sui-images/loader.gif" alt="" class="center-block" v-if="loading">
            <h1>Resultados</h1>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Procedimiento</th>
                            <th>Techo Presupuestal</th>
                            <th>Dependencia</th>
                            <th>Nombre</th>
                            <th>Estatus</th>
                            <th>Tipo Procedimiento</th>
                            <th>Analista</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="procedimiento in procedimientos">
                            <td>@{{$index + 1}}</td>
                            <td>@{{procedimiento.mes}}_@{{procedimiento.consecutivo}}-@{{procedimiento.anio}}</td>
                            <td>$@{{procedimiento.presupuesto}}</td>
                            <td>@{{procedimiento.value_dependencia}}</td>
                            <td>@{{procedimiento.descripcion}}</td>
                            <td>@{{procedimiento.value_status}}</td>
                            <td>@{{procedimiento.value_procedimiento_adjudicacion}}</td>
                            <td>@{{procedimiento.value_analista}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var vm = new Vue({
        el: "#app",
        data: {
            procedimientos: '',
            loading: false
        },
        ready: function(){

        },
        methods: {
            busqueda: function(){
                var that = this;
                this.loading = true;
                this.$http.get('/reportes/busqueda' + '?tipo_procedimiento=' + this.tipo_procedimiento + '&usuario_id=' + this.usuario_id + '&ejercicio_fiscal=' + this.ejercicio_fiscal + '&dependencia_id=' + this.dependencia_id + '&status=' + this.status + '&proveedor=' + this.proveedor ).then(function(requisiciones){
                    that.loading = false;
                    that.procedimientos = requisiciones.data;
                }, function(error){
                    console.log(error)
                });
            },
            buscar_por_procedimiento: function(){
                var that = this;
                this.loading = true;
                this.$http.get('/reportes/busqueda_por_procedimiento' + '?codificacion=' + this.codificacion).then(function(procedimiento){
                    console.log(procedimiento.data)
                    that.loading = false;
                    that.procedimientos = procedimiento.data;
                }, function(error){
                    console.log(error)
                });
            }
        }
    })
</script>
@endsection