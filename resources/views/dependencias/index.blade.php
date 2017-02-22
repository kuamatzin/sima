@extends('app')
@section ('content')
  <div class="row">
    <div class="col-md-12">
      <h1><i class="fa fa-building-o"></i> Dependencias</h1>
      <a href="{{ url('dependencias/create')}}"><button type="button" class="btn btn-primary">Crear dependencia	<i class="fa fa-plus"></i></button></a>
      <hr>
      <input type="text" name="search" id="search" class="form-control" value="" required="required" pattern="" title="">
      <br>
      <table class="table table-bordered table-hover" id="table">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Siglas</th>
            <th>Titular</th>
            <th>Ver</th>
            <th>Editar</th>
            <th>Eliminar</th>
          </tr>
        </thead>
        <tbody>
          @foreach($dependencias as $dependencia)
              <tr id="searchable">
                <td>{{ $dependencia->nombre }}</td>
                <td>{{ $dependencia->siglas }}</td>
                <td>{{ $dependencia->titular }}</td>
                <td><a href="{{ url('dependencias', $dependencia->id) }}"><button type="button" class="btn btn-primary">Ver <i class="fa fa-eye"></i></button></a></td>
                <td><a href="{{ action('DependenciasController@edit', $dependencia->id) }}"><button type="button" class="btn btn-warning">Editar <i class="fa fa-pencil"></i></button></a></td>
                <td>
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$dependencia->id}}">
                    Eliminar <i class="fa fa-trash-o"></i>
                  </button>
                </td>
              </tr>
              <div class="modal fade" id="myModal{{$dependencia->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-body">
                      <p>Está seguro de eliminar la dependencia: {{$dependencia->nombre}}</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                      {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('dependencias.destroy', $dependencia->id))) !!}
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