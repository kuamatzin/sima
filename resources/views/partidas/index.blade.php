@extends('app')
@section ('content')
      <div class="row">
        <h2>Requisicion: {{$requisicion->descripcion}}</h2>
        <hr>
        <div class="col-md-6">
          <p><strong>Dependencia: </strong>{{$requisicion->dependencia->nombre}}</p>
          <p><strong>Tipo: </strong>
          <!-- Determinar si es Bien o Servicio -->
          {{$requisicion->tipo_requisicion}}
          </p>
          <!-- Fin determinar Bien o Servicio -->
          <p><strong>Descripcion: </strong>{{$requisicion->descripcion}}</p>
          <p><strong>Partida Presupuestal: </strong>{{$requisicion->partida_presupuestal}}</p>
          <p><strong>Codificación: </strong>{{$requisicion->codificacion}}</p>
          <p><strong>Presupuesto: </strong>{{$requisicion->presupuesto}}</p>
          <p><strong>Origen de recursos: </strong>
          <!-- Determinar Origen de Recursos -->
          @if($requisicion->origen_recursos == 1)
          Estatales
          @elseif($requisicion->origen_recursos == 2)
          Propios
          @else
          Federales
          @endif
          <!-- Fin determinar Origen de Recursos-->
          </p>
          <p><strong>Procedimiento de adjudicación: </strong>
          <!-- Determinar Procedimiento de Adjudicación -->
          @if($requisicion->procedimiento_adjudicacion == 1)
          Adjudicación Directa
          @elseif($requisicion->procedimiento_adjudicacion == 2)
          Invitación a cuando menos 3
          @else
          Licitación Pública
          @endif
          </p>
          <!-- Fin determinar Procedimiento de Adjudicación -->
          </p>
          <p><strong>Tiempo de entrega: </strong>{{$requisicion->tiempo_entrega}}</p>
          <p><strong>Lugar de entrega: </strong>{{$requisicion->lugar_entrega}}</p>
          <p><strong>Garantía: </strong>{{$requisicion->garantia}}</p>
        </div>
        <div class="col-md-6">
          <p><strong>Asesor: </strong>{{$requisicion->asesor}}</p>
          <p><strong>Cargo del asesor: </strong>{{$requisicion->cargo_asesor}}</p>
          <p><strong>Email del asesor: </strong>{{$requisicion->email_asesor}}</p>
          <p><strong>Dias para pago: </strong>{{$requisicion->dias_pago}}</p>
          <p><strong>Observaciones: </strong>{{$requisicion->observaciones}}</p>
          <p><strong>Requisitos Técnicos: </strong>{{$requisicion->requisitos_tecnicos}}</p>
          <p><strong>Requisitos Informativos: </strong>{{$requisicion->requisitos_informativos}}</p>
          <p><strong>Requisitos Económicos: </strong>{{$requisicion->requisitos_economicos}}</p>
          <p><strong>Condiciones de Pago: </strong>{{$requisicion->condiciones_pago}}</p>
          <p><strong>Datos de facturación: </strong>{{$requisicion->datos_facturacion}}</p>
          <p><strong>Status: </strong>{{$requisicion->status}}</p>
          <a href="/requisiciones/descarga/{{$requisicion->id}}">
            <button type="button" class="btn btn-success" style="margin-left:180px">Descargar Reporte</button>
          </a>
        </div>
        <div class="col-md-12">
          <hr>
          <h2>Partidas</h2>
          <a href="{{ action('PartidasController@create', $requisicion->id) }}"><button type="button" class="btn btn-primary">Crear partida</button></a>
          <br><br>
          <input type="text" name="" id="search" class="form-control" value="" required="required" pattern="" title="">
          <br>
          <table class="table table-bordered table-hover" id="table">
            <thead>
              <tr>
                <th>No.</th>
                <th>Descripcion</th>
                <th>Cantidad Minima</th>
                <th>Unidad de medida</th>
                <th>Ver</th>
                <th>Editar</th>
                <th>Eliminar</th>
              </tr>
            </thead>
            <tbody>
              @foreach($requisicion->partidas as $key => $partida)
                <tr id="searchable">
                  <td>{{$key+1}}</td>
                  <td>{{ $partida->descripcion }}</td>
                  <td>{{ $partida->cantidad_minima }}</td>
                  <td>{{ $partida->unidad_medida }}</td>
                  <td><a href="{{ url('partidas/show', $partida->id) }}"><button type="button" class="btn btn-primary">Ver</button></a></td>
                  <td><a href="{{ action('PartidasController@edit', $partida->id) }}"><button type="button" class="btn btn-warning">Editar</button></a></td>
                  <td>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$partida->id}}">Eliminar</button>
                  </td>
                </tr>

                <div class="modal fade" id="myModal{{$partida->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-body">
                        <p>Está seguro de eliminar la partida <strong>{{$key+1}}</strong>  de la requisicion: <strong>{{$partida->requisicion->descripcion}}</strong></p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'url' => 'partidas/' . $partida->requisicion->id . '/' . $partida->id)) !!}
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
</script>
@endsection
