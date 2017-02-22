@extends('app')

@section('content2')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$procedimiento->requisiciones[0]->descripcion}}</h3>
                </div>
                <div class="panel-body">
                    <p>Techo presupuestal: ${{$procedimiento->requisiciones[0]->presupuesto}}</p>
                    <p>Total adjudicado: ${{$procedimiento->totalAdjudicado()}}</p>
                </div>
            </div>
        </div>
        @if($procedimiento->totalAdjudicadoCantidad() > $procedimiento->requisiciones[0]->getOriginal('presupuesto'))
        <div class="col-md-5">
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Cuidado!</strong> El monto total adjudicado revasa el techo presupuestal
            </div>
        </div>
        @endif
        <div class="col-md-3">
            <a href="/ajustar_cantidades/{{$procedimiento->id}}" class="btn btn-success">Ajustar cantidades</a>
        </div>
    </div>
    <h3>Colores</h3>
    <p style="display: inline">Oferta ganadora: <div class="oferta-ganadora cuadro"></div></p>
    <p style="display: inline">No cumple: <div class="no-cumple cuadro"></div></p>
    <p style="display: inline">No cotiza: <div class="no-cotiza cuadro"></div></p>
    <hr>
    <h3>Cuadro Comparativo</h3>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Partida</th>
                <th>Cantidad</th>
                <th>Unidad</th>
                <th width="400px">Descripcion</th>
                @foreach($proveedores as $key => $proveedor)
                <th>
                    <div class="row center-block">
                        <p class="text-center proveedor">{{$proveedor[0]->nombre}}</p>
                        <div class="col-md-6 linea">
                            P.U.
                        </div>
                        <div class="col-md-6">
                            P.T.
                        </div>
                    </div>
                </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            {!! Form::open(['method' => 'POST', 'url' => 'analisis_comparativo/' . $procedimiento->id, 'class' => 'form-horizontal']) !!}
            @foreach($partidas as $key => $partida)
            <tr>
                <td>{{$key + 1}}</td>
                <td>
                    @if(!is_numeric($partida->cantidad_ajuste))
                        {{ $partida->cantidad_minima }}
                    @else
                        {{ $partida->cantidad_ajuste }}            
                    @endif
                </td>
                <td>{{$partida->unidad_medida}}</td>
                <td>{{$partida->descripcion}}</td>
                @foreach($proveedores as $key2 => $proveedor)
                    @if($ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->status == 2)
                        <td class="no-cumple"><p class="text-center">NO CUMPLE</p></td>
                    @elseif($ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->status == 5)
                        <td class="no-cotiza"><p class="text-center">NO COTIZA</p></td>
                    @else
                        @if($ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->ganador == 1)
                            <td class="oferta-ganadora">
                                <div class="row center-block">
                                    <div class="col-md-2">
                                        <div class="checkbox-table">
                                            <label for="ganador">
                                                {!! Form::checkbox('ganadores[]', $ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->id, true, ['id' => $ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->id]) !!}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        ${{$ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->getPrecioUnitarioFormated()}}
                                    </div>
                                    <div class="col-md-5">
                                        ${{$ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->getMontoTotalFormated()}}
                                    </div>
                                </div>                                
                            </td>
                        @else
                            <td>
                                <div class="row center-block">
                                    <div class="col-md-2">
                                        <div class="checkbox">
                                            <label for="ganador">
                                                {!! Form::checkbox('ganadores[]', $ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->id, null, ['id' => $ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->id]) !!}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        ${{$ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->getPrecioUnitarioFormated()}}
                                    </div>
                                    <div class="col-md-5">
                                        ${{$ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->getMontoTotalFormated()}}
                                    </div>
                                </div>
                            </td>
                        @endif  
                    @endif   
                @endforeach
            </tr>
            @endforeach
            <tr>
            <td></td><td></td><td></td><td class="tabla-totales"><strong>Totales</strong></td>
            @foreach($proveedores as $key => $proveedor)
                <td class="tabla-totales">
                    <div class="row center-block">
                        <div class="col-md-6 linea">
                            <strong>
                                ${{$ofertas_cuadroComparativo->where('proveedor_id', $proveedor[0]['id'])->where('status', 1)->sum('precio_unitario')}}
                            </strong>
                        </div>
                        <div class="col-md-6">
                            <strong>
                                ${{$ofertas_cuadroComparativo->where('proveedor_id', $proveedor[0]['id'])->where('status', 1)->sum('monto_total')}}
                            </strong>
                        </div>
                    </div>                                
                </td>
            @endforeach
            </tr>
        </tbody>
    </table>
    {!! Form::button('Mantenimiento <i class="fa fa-wrench"></i>', array('type' => 'submit', 'class' => 'btn btn-warning pull-left')) !!}

    {!! Form::close() !!}

    <a href="{{ url('descargaCuadroComparativo', ['procedimiento_id' => $procedimiento->id, 'descarga' => 1])}}"><button type="button" class="btn btn-success pull-right">Descargar Cuadro Comparativo <i class="fa fa-download"></i></button></a>
</div>
@endsection