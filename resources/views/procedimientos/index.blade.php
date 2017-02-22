@extends('app')
@section('styles')
<link href="https://cdn.jsdelivr.net/sweetalert2/5.3.2/sweetalert2.min.css" rel="stylesheet">
@endsection
@section ('content2')
    <div class="row">
      <div class="col-md-12">
        <h1><i class="fa fa-book"></i> Procedimientos</h1>
        @if(Auth::user()->isAMonitor() || Auth::user()->isAManager())
          <a href="{{ url('procedimientos/create')}}">
            <button type="button" class="btn btn-primary">Crear procedimiento <i class="fa fa-plus"></i></button>
          </a>
-        @endif
        <hr>
        <div class="row">
            <div class="col-md-2 form-group{{ $errors->has('ejercicio_fiscal') ? ' has-error' : '' }}">
              {!! Form::label('ejercicio_fiscal', 'Ejericicio Fiscal') !!}
              {!! Form::select('ejercicio_fiscal', [2016 => '2016', 2017 => '2017'], $año, ['id' => 'ejercicio_fiscal', 'class' => 'form-control', 'id' => 'ejercicio_fiscal_select']) !!}
              <small class="text-danger">{{ $errors->first('ejercicio_fiscal') }}</small>
          </div>
          </div>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th></th>
                <th class="text-center">Descripción</th>
                <th class="text-center">Codificación</th>
                <th class="text-center">Analista</th>
                <th class="text-center">Invitación</th>
                <th class="text-center">Licitantes</th>
                <th class="text-center">Dictamen Técnico</th>
                <th class="text-center">Carga Económica</th>
                <th class="text-center">Análisis Comparativo</th>
                <th class="text-center">Pedido</th>
                <th class="text-center">Ver</th>
                @if(Auth::user()->getTipoUsuario() != 'Analista Procedimiento')
                <th class="text-center">Editar</th>
                <th class="text-center">Eliminar</th>
                @endif
                <th class="text-center">Cancelar</th>
                <th class="text-center">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($procedimientos as $key => $procedimiento)
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $procedimiento->requisiciones[0]->descripcion }}</td>
                    <td>{{ $procedimiento->requisiciones[0]->mes }}_{{ $procedimiento->requisiciones[0]->consecutivo }}-{{ $procedimiento->requisiciones[0]->anio }}</td>
                    <td>{{ $procedimiento->analista->name }}</td>
                    <td>
                      <a href="{{ url('invitacion', $procedimiento->id) }}">
                        <button type="button" class="btn btn-default center-block"><i class="fa fa-hand-paper-o"></i></button>
                      </a>
                    </td>
                    <td><a href="{{ url('licitantes', $procedimiento->id) }}"><button type="button" class="btn btn-licitantes center-block"><i class="fa fa-users"></i></button></a></td>
                    <td><a href="{{ url('dictamen_tecnico', $procedimiento->id) }}"><button type="button" class="btn btn-dictamen center-block"><i class="fa fa-check-square"></i></button></a></td>
                    <td><a href="{{ url('carga_economica', $procedimiento->id) }}"><button type="button" class="btn btn-carga center-block"><i class="fa fa-money"></i></button></a></td>
                    <td>
                      <a href="{{ url('analisis_comparativo', ['procedimiento_id' => $procedimiento->id, 'descarga' => 0]) }}">
                        <button type="button" class="btn btn-analisis center-block"><i class="fa fa-trophy"></i></button>
                      </a>
                    </td>
                    <td>
                      <a href="{{ url('pedido', ['procedimiento_id' => $procedimiento->id]) }}">
                        <button type="button" class="btn btn-info center-block"><i class="fa fa-paper-plane-o"></i></button>
                      </a>
                    </td>
                    <td><a href="{{ url('procedimientos', $procedimiento->id) }}"><button type="button" class="btn btn-primary center-block"> <i class="fa fa-eye"></i></button></a></td>
                    @if(Auth::user()->getTipoUsuario() != 'Analista Procedimiento')
                    <td>
                      <a href="{{ action('ProcedimientosController@edit', $procedimiento->id) }}">
                        <button type="button" class="btn btn-warning center-block">
                          <i class="fa fa-pencil"></i>
                        </button>
                      </a>
                    </td>
                    <td>
                      <button type="button" class="btn btn-danger center-block" data-toggle="modal" data-target="#myModal{{$procedimiento->id}}">
                      <i class="fa fa-trash-o"></i>
                      </button>
                    </td>
                    @endif
                    <td>
                      <!--  Cancelar procedimiento -->
                      @if($procedimiento->status == 'Cancelado')
                        <a href="/procedimiento/cancelado/{{$procedimiento->id}}">
                          <button type="button" class="btn btn-danger center-block"><i class="fa fa-ban" aria-hidden="true"></i></button>
                        </a>
                      @else
                        <a onclick="cancelar_prodecimiento({{$procedimiento}})">
                          <button type="button" class="btn btn-danger center-block"><i class="fa fa-ban" aria-hidden="true"></i></button>
                        </a>
                      @endif         
                    </td>
                    <td>{{$procedimiento->status}}</td>
                  </tr>
                  <div class="modal fade" id="myModal{{$procedimiento->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-body">
                          <p>Está seguro de eliminar el procedimiento: {{ $procedimiento->requisiciones[0]->mes }}_{{ $procedimiento->requisiciones[0]->consecutivo }}-{{ $procedimiento->requisiciones[0]->anio }}</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('procedimientos.destroy', $procedimiento->id))) !!}
                            {!! Form::submit('Eliminar', array('class' => 'btn btn-danger')) !!}
                          {!! Form::close() !!}
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-id">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Cancelar Procedimiento</h4>
          </div>
          <div class="modal-body">
            <p>Procedimiento a cancelar: </p>
            <p id="procedimiento_cancelar"></p>

            {!! Form::open(['url' => '/cancelar_prodecimiento', 'id' => 'form_cancelar']) !!}
              <div class="form-group{{ $errors->has('oficio_cancelar') ? ' has-error' : '' }}">
                  {!! Form::label('oficio_cancelar', 'Numero de oficio') !!}
                  {!! Form::text('oficio_cancelar', null, ['class' => 'form-control', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('oficio_cancelar') }}</small>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-danger">Cancelar procedimiento</button>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/sweetalert2/5.3.2/sweetalert2.min.js"></script>
<script>
  $('#ejercicio_fiscal_select').change(function(event) {
    window.location.href = '/procedimientos?anio=' + $('#ejercicio_fiscal_select').val()
  });
  var cancelar_prodecimiento = function(procedimiento){
    if (procedimiento.status == 'Cancelado') {
      swal({   title: "Procedimiento Cancelado: " + procedimiento.requisiciones[0].mes  + '_' + procedimiento.requisiciones[0].consecutivo + '_' + procedimiento.requisiciones[0].anio ,   text: "Número de oficio: " + procedimiento.oficio_cancelar,   imageUrl: "http://d2r5da613aq50s.cloudfront.net/wp-content/uploads/483813.image1.jpg" });
    }
    else {
      $('#procedimiento_cancelar').html(procedimiento.requisiciones[0].mes  + '_' + procedimiento.requisiciones[0].consecutivo + ' - ' + procedimiento.requisiciones[0].descripcion);
      $('#form_cancelar').get(0).setAttribute('action', '/cancelar_prodecimiento/' + procedimiento.id);
      $('#modal-id').modal('show');
    } 
}
</script>
@endsection
