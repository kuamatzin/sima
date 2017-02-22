@extends('app')
@section ('content2')
  <div class="row">
    <div class="col-md-12">
      <h1><i class="fa fa-truck"></i> Proveedores</h1>
      <a href="{{ url('proveedores/create')}}"><button type="button" class="btn btn-primary">Crear provedor <i class="fa fa-plus"></i></button></a>
      <hr>
      <input type="text" name="" id="search" class="form-control" value="" required="required" pattern="" title=""> <br>
      <div class="table-responsive">
      <table class="table table-bordered table-hover" id="table">
        <thead>
          <tr>
            <th></th>
            <th>Nombre</th>
            <th>Actividad</th>
            <th>Representante</th>
            <th>Telefono</th>
            <th>RFC</th>
            <th>Fecha Alta</th>
            <th>Fecha Recibido Alta</th>
            <th>Fecha Renovación</th>
            <th>Fecha Recibido Renovación</th>
            <th>Editar</th>
          </tr>
        </thead>
        <tbody>
          @foreach($proveedores as $key => $proveedor)
              <tr id="searchable">
                <td>{{$key+1}}</td>
                <td>{{ $proveedor->nombre }}</td>
                <td>{{ $proveedor->actividad }}</td>
                <td>{{ $proveedor->representante }}</td>
                <td>{{ $proveedor->telefono }}</td>
                <td>{{ $proveedor->rfc }}</td>
                <td>{{ $proveedor->fecha_alta }}</td>
                <td>{{ $proveedor->fecha_recibido_alta }}</td>
                <td>{{ $proveedor->fecha_renovacion }}</td>
                <td>{{ $proveedor->fecha_recibido_renovacion }}</td>
                <!--
                <td><a href="{{ url('proveedores', $proveedor->id) }}"><button type="button" class="btn btn-primary">Ver <i class="fa fa-eye"></i></button></a></td>
                -->
                <td><a href="{{ action('ProveedoresController@edit', $proveedor->id) }}"><button type="button" class="btn btn-warning">Editar <i class="fa fa-pencil"></i></button></a></td>
                <!--
                <td>
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$proveedor->id}}">
                    Eliminar <i class="fa fa-trash-o"></i>
                  </button>
                </td>
                -->
              </tr>
              <div class="modal fade" id="myModal{{$proveedor->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-body">
                      <p>Está seguro de eliminar la dependencia: {{$proveedor->descripcion}}</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                      {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('proveedores.destroy', $proveedor->id))) !!}
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