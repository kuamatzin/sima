@extends('app')
@section ('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h1>{{$proveedor->nombre}}</h1>
        <hr>
        <h2>Información</h2>
        <p>Nombre: {{$proveedor->nombre}}</p>
        <p>Representante: {{$proveedor->representante}}</p>
        <p>Actividad: {{$proveedor->actividad}}</p>
        <p>Lada: {{$proveedor->lada}}</p>
        <p>Teléfono: {{$proveedor->telefono}}</p>
        <p>Email: {{$proveedor->email}}</p>
        <p>Dirección: {{$proveedor->direccion}}</p>
        <p>Estado: {{$proveedor->estado}}</p>
        <p>RFC: {{$proveedor->rfc}}</p>
        <p>CLABE: {{$proveedor->clabe}}</p>
        <p>Folio: {{$proveedor->folio}}</p>
        <p>Status: {{$proveedor->status}}</p>
        <p>Proveedor Temporal:
            @if($proveedor->temporal)
            SI
            @else
            NO
            @endif
        </p>
        <hr>
        <a href="">
        <button type="button" class="btn btn-primary">Agregar distribuidor</button></a>
    </div>
</div>
@endsection