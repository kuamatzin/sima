@extends('app')
@section('content')
<h1>Programas Anuales</h1>
<div class="row">
  <div class="col-md-2 form-group{{ $errors->has('ejercicio_fiscal') ? ' has-error' : '' }}">
    {!! Form::label('ejercicio_fiscal', 'Ejericicio Fiscal') !!}
    {!! Form::select('ejercicio_fiscal', [2016 => '2016', 2017 => '2017', 2018 => '2018'], $año, ['id' => 'ejercicio_fiscal', 'class' => 'form-control', 'id' => 'ejercicio_fiscal_select']) !!}
    <small class="text-danger">{{ $errors->first('ejercicio_fiscal') }}</small>
  </div>
</div>

<a href="{{ url('programa_anual/create')}}"><button type="button" class="btn btn-primary">Crear programa anual <i class="fa fa-plus"></i></button></a>

<hr>
<input type="text" name="" id="search" class="form-control" value="" required="required" pattern="" title=""><br>
<table class="table table-bordered table-hover" id="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Programa</th>
            <th>Dependencia</th>
            <th>Usuario</th>
            <th>Presupuesto Total</th>  
            <th>Ver</th>
            <th>Editar</th>
            <th>Eliminar</th>
            <th>Agregar Partida Presupuestal</th>
            <th>Duplicar Programa Anual</th>
        </tr>
    </thead>
    <tbody>
        @foreach($programas_anuales as $programa_anual)
        <tr id="searchable">
            <td>{{ $programa_anual->id }}</td>
            <td>{{ $programa_anual->programa }}</td>
            <td>{{ $programa_anual->dependencia->nombre }}</td>
            <td>{{ $programa_anual->usuario->name }}</td>
            <td>{{ $programa_anual->presupuesto_total_anual }}</td>
            <td><a href="{{ url('programa_anual', $programa_anual->id) }}"><button type="button" class="btn btn-primary">Ver <i class="fa fa-eye"></i></button></a></td>
            <td><a href="{{ action('ProgramaAnualController@edit', $programa_anual->id) }}"><button type="button" class="btn btn-warning">Editar <i class="fa fa-pencil"></i></button></a></td>
            <td>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$programa_anual->id}}">
                Eliminar <i class="fa fa-trash-o"></i>
                </button>
            </td>
            <td>
                <a href='{{ url("partidas_presupuestales/$programa_anual->id/create") }}'>
                    <button type="button" class="btn btn-success">Agregar Partida Presupuestal  </button>
                </a>
            </td>
            <td>
                {!! Form::open(['url' => '/programa_anual/duplicar/' . $programa_anual->id]) !!}
                    <button type="submit" class="btn btn-info">Duplicar</button>
                {!! Form::close() !!}
            </td>
        </tr>
        <div class="modal fade" id="myModal{{$programa_anual->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p>Está seguro de eliminar la requisición: {{$programa_anual->descripcion}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('programa_anual.destroy', $programa_anual->id))) !!}
                        {!! Form::submit('Eliminar', array('class' => 'btn btn-danger')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </tbody>
</table>
@endsection
@section('scripts')
<script>
    $('#ejercicio_fiscal_select').change(function(event) {
        window.location.href = '/programa_anual?anio=' + $('#ejercicio_fiscal_select').val()
    });
</script>
@endsection