@extends('app')
@section('content')
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">{{ $programa_anual->programa }}</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <p>
                    <strong>Dependencia:</strong>
                    {{ $programa_anual->dependencia->nombre }}
                </p>
                <p>
                    <strong>Analista:</strong>
                    {{ $programa_anual->usuario->name }}
                </p>
                <p>
                    <strong>Presupuesto Total Anual:</strong>
                    {{ $programa_anual->presupuesto_total_anual }}
                </p>
                <p>
                    <strong>Domicilio:</strong>
                    {{ $programa_anual->domicilio }}
                </p>
                <a href="/programa_anual/descarga/{{$programa_anual->id}}/xlsx">
                    <button type="button" class="btn btn-success pull-left">
                    Descargar Reporte Excel
                    </button>
                </a>
                <a href="/programa_anual/descarga/{{$programa_anual->id}}/pdf" style="padding-right: 50px">
                    <button type="button" class="btn btn-primary pull-left">
                    Descargar Reporte PDF
                    </button>
                </a>
            </div>
            <div class="col-md-6">
                <p>
                    <strong>Teléfono:</strong>
                    {{ $programa_anual->dependencia->nombre }}
                </p>
                <p>
                    <strong>Programa:</strong>
                    {{ $programa_anual->programa }}
                </p>
                <p>
                    <strong>Subprograma:</strong>
                    {{ $programa_anual->subprograma }}
                </p>
                <p>
                    <strong>Fuente de Financiamiento:</strong>
                    {{ $programa_anual->fuente_financiamiento }}
                </p>

                <a href="/partidas_presupuestales/{{$programa_anual->id}}/create">
                    <button type="button" class="btn btn-success pull-right">Agregar Partida Presupuestal
                </button>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Partidas Presupuestales</h3>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <td>Partida Presupuestal</td>
                        <td>Concepto</td>
                        <td>Ver</td>
                        <td>Editar</td>
                        <td>Eliminar</td>
                        <td>Agregar Partidas</td>
                        <td>Acumulado</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programa_anual->partidas_presupuestales as $key => $partida_presupuestal)
                    <tr>
                        <td>{{ $key +1 }}</td>
                        <td>{{ $partida_presupuestal->partida_presupuestal }}</td>
                        <td>{{ $partida_presupuestal->concepto }}</td>
                        <td>
                            <a href="{{ action('PartidasPresupuestalesController@show', $partida_presupuestal->id) }}">
                                <button type="button" class="btn btn-primary">Ver</button>
                            </a>
                        </td>
                        <td>
                            <a href="{{ action('PartidasPresupuestalesController@edit', $partida_presupuestal->id) }}">
                                <button type="button" class="btn btn-warning">Editar</button>
                            </a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger">Eliminar</button>
                        </td>
                        <td>
                            <a href="{{ action('PartidaProgramaAnualController@create', $partida_presupuestal->id) }}">
                                <button type="button" class="btn btn-success">Agregar partida <i class="fa fa-plus"></i>
                                </button>
                            </a>
                        </td>
                        <td>
                            <strong name="presupuesto_{{$key}}">${{$partida_presupuestal->acumulado()}}</strong>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <p><strong>Presupuesto Total de Partidas Presupuestales: </strong> <strong>${{$programa_anual->presupuesto_total()}}</strong></p>
        </div>
    </div>
</div>
@endsection