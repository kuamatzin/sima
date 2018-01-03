@extends('app')
@section ('content')
    <div class="row">
      <div class="col-md-12">
        <h1><i class="fa fa-file"></i> Requisiciones</h1>
          <a href="{{ url('requisiciones/create')}}"><button type="button" class="btn btn-primary">Crear requisicion <i class="fa fa-plus"></i></button></a>
        <hr>
        <div class="row">
          <div class="col-md-2">
            <label for="">Ejercicio Fiscal</label>
            <select id="ejercicio_fiscal" class="form-control" required="required">
              <option value="2016">2016</option>
              <option value="2017">2017</option>
              <option value="2018">2018</option>
            </select>
          </div>
          <div class="col-md-2">
            <label for="">Mes</label>
            <select id="mes" class="form-control" required="required">
              <option value="1">Enero</option>
              <option value="2">Febrero</option>
              <option value="3">Marzo</option>
              <option value="4">Abril</option>
              <option value="5">Mayo</option>
              <option value="6">Junio</option>
              <option value="7">Julio</option>
              <option value="8">Agosto</option>
              <option value="9">Septiembre</option>
              <option value="10">Octubre</option>
              <option value="11">Noviembre</option>
              <option value="12">Diciembre</option>
            </select>
          </div>
        </div>
        <br><br>
        <input type="text" name="" id="search" class="form-control" value="" required="required" pattern="" title=""><br>
        <table class="table table-bordered table-hover" id="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Codificación</th>
              <th>Descripcion</th>
              <th>Dependencia</th>
              <th>Asesor</th>
              <th>Status</th>
              <th>Ver</th>
              <th>Editar</th>
              <th>Duplicar</th>
              <th>Eliminar</th>
              <th>Agregar partida</th>
            </tr>
          </thead>
          <tbody>
            @foreach($requisiciones as $requisicion)
              <tr id="searchable">
                <td>{{ $requisicion->id }}</td>
                <td>{{ $requisicion->mes }}_{{ $requisicion->consecutivo }}-{{ $requisicion->anio }}</td>
                <td>{{ $requisicion->descripcion }}</td>
                <td>{{ $requisicion->dependencia->nombre }}</td>
                <td>{{ $requisicion->asesor }}</td>
                <td>{{ $requisicion->status }}</td>
                <td><a href="{{ url('partidas', $requisicion->id) }}"><button type="button" class="btn btn-primary">Ver <i class="fa fa-eye"></i></button></a></td>
                <td><a href="{{ action('RequisicionesController@edit', $requisicion->id) }}"><button type="button" class="btn btn-warning">Editar <i class="fa fa-pencil"></i></button></a></td>
                <td>
                  {!! Form::open(array('class' => 'form-inline', 'method' => 'POST', 'action' => array('RequisicionesController@duplicate', $requisicion->id))) !!}
                    {!! Form::submit('Duplicar', array('class' => 'btn btn-default')) !!}
                  {!! Form::close() !!}
                </td>
                <td>
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$requisicion->id}}">
                    Eliminar <i class="fa fa-trash-o"></i>
                  </button>
                </td>
                <td><a href="{{ action('PartidasController@create', $requisicion->id) }}"><button type="button" class="btn btn-success">Agregar partida <i class="fa fa-plus"></i></button></a></td>
              </tr>

              <div class="modal fade" id="myModal{{$requisicion->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-body">
                      <p>Está seguro de eliminar la requisición: {{$requisicion->descripcion}}</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                      {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('requisiciones.destroy', $requisicion->id))) !!}
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
    $("#mes").val({{$month}});
    $('#mes').change(function(event) {
      window.location = '/requisiciones?anio=' + $('#ejercicio_fiscal').val() + '&mes=' + $('#mes').val();
    });

    $("#ejercicio_fiscal").val({{$year}});
    $('#ejercicio_fiscal').change(function(event) {
      window.location = '/requisiciones?anio=' + $('#ejercicio_fiscal').val() + '&mes=' + $('#mes').val();
    });
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