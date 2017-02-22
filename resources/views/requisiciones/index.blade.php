@extends('app')
@section ('content')
    <div class="row">
      <div class="col-md-12">
        <h1><i class="fa fa-file"></i> Requisiciones</h1>
          <a href="{{ url('requisiciones/create')}}"><button type="button" class="btn btn-primary">Crear requisicion <i class="fa fa-plus"></i></button></a>
        <hr>
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