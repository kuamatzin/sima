@extends('app')
@section ('content')
  <div class="main">
    <div class="row">
    <h1>{{$unidad_administrativa->nombre}}</h1>
    <h2>Información</h2>
    <hr>
      <div class="col-md-6">
            <p>Nombre: {{$unidad_administrativa->nombre}}</p>
            <p>Calle: {{$unidad_administrativa->calle}}</p>
            <p>Número exterior {{$unidad_administrativa->numero_exterior}}</p>
            <p>Número interior {{$unidad_administrativa->numero_interior}}</p>
            <p>Colonia: {{$unidad_administrativa->colonia}}</p>
            <p>Municipio: {{$unidad_administrativa->municipio}}</p>
            <p>Lada: {{$unidad_administrativa->lada}}</p>
            <p>Teléfono: {{$unidad_administrativa->telefono}}</p>
      </div>
      <div class="col-md-6">
            
            <p>Extensión: {{$unidad_administrativa->extension}}</p>
            <p>Siglas: {{$unidad_administrativa->siglas}}</p>
            <p>Titular: {{$unidad_administrativa->titular}}</p>
            <p>Cargo del titular: {{$unidad_administrativa->cargo_titular}}</p>
            <p>Autoriza: {{$unidad_administrativa->autoriza}}</p>
            <p>Cargo de autoriza: {{$unidad_administrativa->cargo_autoriza}}</p>
            <p>Valida: {{$unidad_administrativa->valida}}</p>
            <p>Cargo de valida: {{$unidad_administrativa->cargo_valida}}</p>
      </div>
    </div>
    
    <h2>Usuarios de {{$unidad_administrativa->nombre}}</h2>
    <a href="/usuarios_unidad_administrativa/{{$unidad_administrativa->id}}/create">
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
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($unidad_administrativa->usuarios as $key => $usuario)
                <tr>
                    <td>{{$usuario->name}}</td>
                    <td>{{$usuario->email}}</td>
                    <td>{{$usuario->getTipoUsuario()}}</td>
                    <td>
                        <a href="/usuarios_unidad_administrativa/{{$usuario->id}}/edit">
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
