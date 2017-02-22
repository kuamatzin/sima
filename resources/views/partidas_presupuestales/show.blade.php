@extends('app')

@section('content')
<a href="/programa_anual/{{$partida_presupuestal->programa_anual->id}}">
    <button type="button" class="btn btn-primary">Regresar</button>
</a>
<br><br>
<h3>{{$partida_presupuestal->programa_anual->programa}}</h3>
<hr>
<h3>{{$partida_presupuestal->partida_presupuestal}} : {{$partida_presupuestal->concepto}}</h3>
<br>
<a href="{{ action('PartidaProgramaAnualController@create', $partida_presupuestal->id) }}">
    <button type="button" class="btn btn-success pull-right">Agregar partida <i class="fa fa-plus"></i>
    </button>
</a>
<br><br>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Partidas</h3>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Descripcion</th>
                        <th>Cantidad Minima</th>
                        <th>Unidad de medida</th>
                        <th>Presupuesto Total</th>
                        <!--<th>Ver</th>-->
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($partida_presupuestal->partidas as $key => $partida)
                    <tr id="searchable">
                        <td>{{ $key+1 }}</td>
                        <td>{{ $partida->descripcion }}</td>
                        <td>{{ $partida->cantidad_minima }}</td>
                        <td>{{ $partida->unidad_medida }}</td>
                        <td>{{ $partida->presupuesto_total_articulo }}</td>
                        <!--<td><a href="{{ url('partidas/show', $partida->id) }}"><button type="button" class="btn btn-primary">Ver</button></a></td>-->
                        <td><a href="{{ action('PartidaProgramaAnualController@edit', $partida->id) }}"><button type="button" class="btn btn-warning">Editar</button></a></td>
                        <td>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$partida->id}}">Eliminar</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="myModal{{$partida->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <p>Está seguro de eliminar la partida <strong>{{$key+1}}</strong>  de la requisicion: <strong>{{$partida->partida_presupuestal->concepto}}</strong></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'url' => 'partidas_programa_anual/' . $partida->id)) !!}
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

@endsection