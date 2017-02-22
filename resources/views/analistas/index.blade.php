@extends('app')
@section ('content')
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Id Requisicion</th>
          <th>Id Procedimiento</th>
          <th>Descripcion</th>
          <th>Administrar</th>
        </tr>
      </thead>
      <tbody>
        @foreach($procedimientos as $key => $procedimiento)
        <tr>
          <td>{{$procedimiento->requisiciones[0]->id}}</td>
          <td>{{$procedimiento->id}}</td>
          <td>{{$procedimiento->requisiciones[0]->descripcion}}</td>
          <td><a href="{{ action('ProcedimientosAnalistaController@administrar', $procedimiento->id) }}"><button type="button" class="btn btn-warning">Administrar</button></a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
