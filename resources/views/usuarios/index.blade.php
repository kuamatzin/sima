@extends('app')
@section('content')
	<h1><i class="fa fa-user"></i> Usuarios</h1>
    <a href="{{ url('usuarios/create')}}"><button type="button" class="btn btn-primary">Crear Usuario <i class="fa fa-plus"></i></button></a>
    <br><br>
    <input type="text" name="" id="search" class="form-control" value="" required="required" pattern="" title=""><br>
    <div role="tabpanel">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#analistas" aria-controls="analistas" role="tab" data-toggle="tab">Analistas</a>
            </li>
            <li role="presentation">
                <a href="#monitores" aria-controls="monitores" role="tab" data-toggle="tab">Monitores</a>
            </li>
            <li role="presentation">
                <a href="#proveedores" aria-controls="proveedores" role="tab" data-toggle="tab">Administradores</a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="analistas">
              <table class="table table-bordered table-hover" id="table">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Dependencia</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($usuarios_analistas as $usuario)
                    <tr id="searchable">
                      <td>{{ $usuario->name }}</td>
                      <td>{{ $usuario->email }}</td>
                      <td>{{ $usuario->dependencia->nombre }}</td>
                      <td><a href="{{ action('UsuariosController@edit', $usuario->id) }}"><button type="button" class="btn btn-warning">Editar <i class="fa fa-pencil"></i></button></a></td>
                      <td>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$usuario->id}}">
                          Eliminar <i class="fa fa-trash-o"></i>
                        </button>
                      </td>
                    </tr>

                    <div class="modal fade" id="myModal{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-body">
                            <p>Está seguro de eliminar al usuario: {{$usuario->name}}</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('usuarios.destroy', $usuario->id))) !!}
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

            
            <div role="tabpanel" class="tab-pane" id="monitores">
              <table class="table table-bordered table-hover" id="table">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($usuarios_monitores as $usuario)
                    <tr id="searchable">
                      <td>{{ $usuario->name }}</td>
                      <td>{{ $usuario->email }}</td>
                      <td><a href="{{ action('UsuariosController@edit', $usuario->id) }}"><button type="button" class="btn btn-warning">Editar <i class="fa fa-pencil"></i></button></a></td>
                      <td>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$usuario->id}}">
                          Eliminar <i class="fa fa-trash-o"></i>
                        </button>
                      </td>
                    </tr>

                    <div class="modal fade" id="myModal{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-body">
                            <p>Está seguro de eliminar al usuario: {{$usuario->name}}</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('usuarios.destroy', $usuario->id))) !!}
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


            <div role="tabpanel" class="tab-pane" id="proveedores">
              <table class="table table-bordered table-hover" id="table2">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($usuarios_admin as $usuario_admin)
                    <tr id="searchable2">
                      <td>{{ $usuario_admin->name }}</td>
                      <td>{{ $usuario_admin->email }}</td>
                      <td><a href="{{ action('UsuariosController@edit', $usuario_admin->id) }}"><button type="button" class="btn btn-warning">Editar <i class="fa fa-pencil"></i></button></a></td>
                      <td>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$usuario_admin->id}}">
                          Eliminar <i class="fa fa-trash-o"></i>
                        </button>
                      </td>
                    </tr>

                    <div class="modal fade" id="myModal{{$usuario_admin->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-body">
                            <p>Está seguro de eliminar al usuario: {{$usuario_admin->name}}</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('usuarios.destroy', $usuario_admin->id))) !!}
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
    <hr>
@endsection

@section('scripts')
<script>
    var $rows = $('#table #searchable');
    var $rows2 = $('#table2 #searchable2');
    $('#search').keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
        
        $rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();

        $rows2.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
</script>
@endsection