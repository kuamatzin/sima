@extends('app')
@section ('content')
  <div class="main">
    <div class="row">
    <h1>{{$dependencia->nombre}}</h1>
    <h2>Información</h2>
    <hr>
      <div class="col-md-6">
            <p>Nombre: {{$dependencia->nombre}}</p>
            <p>Calle: {{$dependencia->calle}}</p>
            <p>Número exterior {{$dependencia->numero_exterior}}</p>
            <p>Número interior {{$dependencia->numero_interior}}</p>
            <p>Colonia: {{$dependencia->colonia}}</p>
            <p>Municipio: {{$dependencia->municipio}}</p>
            <p>Lada: {{$dependencia->lada}}</p>
            <p>Teléfono: {{$dependencia->telefono}}</p>
      </div>
      <div class="col-md-6">
            
            <p>Extensión: {{$dependencia->extension}}</p>
            <p>Siglas: {{$dependencia->siglas}}</p>
            <p>Titular: {{$dependencia->titular}}</p>
            <p>Cargo del titular: {{$dependencia->cargo_titular}}</p>
            <p>Autoriza: {{$dependencia->autoriza}}</p>
            <p>Cargo de autoriza: {{$dependencia->cargo_autoriza}}</p>
            <p>Valida: {{$dependencia->valida}}</p>
            <p>Cargo de valida: {{$dependencia->cargo_valida}}</p>
      </div>
    </div>
    <h2>Unidades Administrativas</h2>
    <a href="/unidades_administrativas/{{$dependencia->id}}/create"><button type="button" class="btn btn-primary">Agregar Unidad Administrativa</button></a>
    <hr>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Responsable</th>
                    <th>Teléfono</th>
                    <th>Ver</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dependencia->unidades_administrativas as $key => $unidad_administrativa)
                <tr>
                    <td>{{$unidad_administrativa->nombre}}</td>
                    <td>{{$unidad_administrativa->titular}}</td>
                    <td>{{$unidad_administrativa->telefono}}</td>
                    <td>
                        <a href="/unidades_administrativas/{{$unidad_administrativa->id}}"><button type="button" class="btn btn-primary">Ver</button></a>
                    </td>
                    <td>
                        <a href="/unidades_administrativas/{{$unidad_administrativa->id}}/edit"><button type="button" class="btn btn-warning">Editar</button></a>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div> 
    <h2>Usuarios de {{$dependencia->nombre}}</h2>
    <a href="/usuarios_dependecia/{{$dependencia->id}}/create">
        <button type="button" class="btn btn-primary">Agregar Usuario</button>     
    </a>
    <br><br>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Privilegios</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dependencia->usuarios as $key => $usuario)
                <tr>
                    <td>{{$usuario->name}}</td>
                    <td>{{$usuario->email}}</td>
                    <td>{{$usuario->getTipoUsuario()}}</td>
                    <td>
                        <a href="/usuarios_dependecia/{{$usuario->id}}/edit">
                            <button type="button" class="btn btn-warning">Editar</button>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div> 
        
    </a>
  </div>
@endsection
