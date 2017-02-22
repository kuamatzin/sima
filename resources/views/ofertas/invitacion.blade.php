@extends('app')
@section('content2')
<div id="busqueda" class="col-md-10 col-md-offset-1">
  <input type="hidden" id="token" value="{{ csrf_token() }}">
  <input type="hidden" id="procedimiento_id" value="{{$procedimiento->id}}">
  <div class="panel panel-default">
    <div class="panel-body">
      <h3>Agregar Proveedores a Invitación</h3>
      <div class="row">
        <div class="col-md-4">
          <label for="input-id" class="col-sm-2">Nombre</label>
          <input type="text" name="" id="input" class="form-control" v-model="nombre">
        </div>
        <div class="col-md-4">
          <label for="input-id" class="col-sm-2">RFC</label>
          <input type="text" name="" id="input" class="form-control" v-model="rfc">
        </div>
        <div class="col-md-4">
          <label for="input-id" class="col-sm-2">Actividad</label>
          <input type="text" name="" id="input" class="form-control" v-model="actividad">
        </div>
      </div>
      <br>
      <button type="button" class="btn btn-primary pull-right" v-on:click="getProveedores">Buscar</button>
    </div>
  </div>
  <!-- <pre>@{{$data | json}}</pre> -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Resultados</h3>
    </div>
    <div class="panel-body">
      <div v-show="proveedores_show">
        <h3 class="text-center">Buscando proveedores...</h3>
        <img src="/images/loader.gif" width="30%" class="img-responsive center-block">
      </div>
      <div class="table-responsive">
        <table class="table default-table table-hover">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Estado</th>
              <th>Mail</th>
              <th>Actividad</th>
              <th>RFC</th>
              <th>Agregar</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="proveedor in proveedores">
              <td>@{{proveedor.nombre}}</td>
              <td>@{{proveedor.estado}}</td>
              <td>@{{proveedor.email}}</td>
              <td>@{{proveedor.actividad}}</td>
              <td>@{{proveedor.rfc}}</td>
              <td>
                <button type="button" class="btn btn-success" v-on:click="addProveedor(proveedor)"><i class="fa fa-plus-circle"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <hr>
  <!-- Proveedores Seleccionados para Invitacion -->
  <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Proveedores seleccionados para invitación</h3>
      </div>
      <div class="panel-body">
        <table class="table success-table table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>RFC</th>
            <th>Mail</th>
            <th>Quitar</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="proveedor in proveedores_seleccionados">
            <td>@{{proveedor.id}}</td>
            <td>@{{proveedor.nombre}}</td>
            <td>@{{proveedor.rfc}}</td>
            <td>@{{proveedor.email}}</td>
            <td>
              <button type="button" class="btn btn-danger" v-on:click="removeProveedor(index)"><i class="fa fa-times"></i></button>
            </td>
          </tr>
        </tbody>
      </table>

      <button type="button" class="btn btn-warning pull-left" v-show="proveedores_seleccionados.length > 0" v-on:click="enviarInvitacion(0)">Agregar proveedores sin email</button>

      <button type="button" class="btn btn-primary pull-right" v-show="proveedores_seleccionados.length > 0" v-on:click="enviarInvitacion(1)">Enviar Invitación por EMAIL</button>
    </div>
    <div v-show="loader">
      <h3 class="text-center">Enviando cotizaciones...</h3>
      <img src="/images/loader.gif" width="30%" class="img-responsive center-block">
    </div>
  </div>
  <a href="/generarInvitacion/{{$procedimiento->id}}">
    <button type="button" class="btn btn-info">Generar Invitación  <i class="fa fa-file-text-o"></i></button>
  </a>

  @if($procedimiento->status_invitacion == 0)
  <a href="/cerrarInvitacion/{{$procedimiento->id}}">
    <button type="button" class="btn btn-danger pull-right">Cerrar invitacion<i class="fa fa-file-text-o"></i></button>
  </a>
  @else
  <a href="/abrirInvitacion/{{$procedimiento->id}}">
    <button type="button" class="btn btn-default pull-right">Abrir invitacion<i class="fa fa-file-text-o"></i></button>
  </a>
  @endif


  <hr>
  <h3>Invitaciones</h3>
  <div v-show="invitados_show">
    <h3 class="text-center">Obteniendo invitados...</h3>
    <img src="/images/loader.gif" width="30%" class="img-responsive center-block">
  </div>
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th></th>
          <th>Proveedor</th>
          <th>Actividad</th>
          <th>RFC</th>
          <th>Email</th>
          <th>Invitación</th>
          <th>Cotización</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="invitacion in proveedores_invitados">
          <td>@{{$index+1}}</td>
          <td>@{{invitacion.proveedor_datos.nombre}}</td>
          <td>@{{invitacion.proveedor_datos.actividad}}</td>
          <td>@{{invitacion.proveedor_datos.rfc}}</td>
          <td>@{{invitacion.proveedor_datos.email}}</td>
          <td>
            <button class="btn btn-success" v-if="invitacion.servidor_envia_mail">
              <i class="fa fa-check"></i>
            </button>
            <button class="btn btn-danger" v-if="invitacion.servidor_envia_mail == 0">
              <i class="fa fa-times"></i>
            </button>
          </td>
          <td>
            <a href="/verCotizacion/@{{invitacion.id}}">
              <button type="button" class="btn btn-info">Ver cotización</button>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="col-md-10 col-md-offset-1">
  <a href="/descargaListaInvitaciones/{{$procedimiento->id}}">
    <button type="button" class="btn btn-info">Descargar Lista de Invitaciones</button>
  </a>
</div>
</div>


@endsection
@section('scripts')
<script src="{{ asset('/js/invitacion.js') }}"></script>
@endsection