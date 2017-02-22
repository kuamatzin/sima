@extends('app')

@section('content')
    <h2>Pedido para procedimiento: {{$procedimiento->requisiciones[0]->descripcion}}</h2>
    <p>Analista: {{$procedimiento->analista->name}}</p>
    <p>Observaciones: {{$procedimiento->requisiciones[0]->observaciones}}</p>
    <hr>
    <h3>Partidas Ganadas por Proveedor</h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th>Oferta</th>
                    <th>Proveedor Ganador</th>
                    <th>Generar Pedido</th>
                    <th>Facturas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ofertas as $key => $oferta)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$oferta->partida->descripcion}}</td>
                    <td>{{$oferta->proveedor->nombre}}</td>
                    <td>
                        @if($key == 0)
                        <a href="/pedido/{{$procedimiento->id}}/{{$oferta->proveedor->id}}/{{$key+1}}">
                            <button type="button" class="btn btn-primary">Generar Pedido</button>
                        </a>
                        @else
                            @if($oferta->proveedor->nombre != $ofertas[$key-1]->proveedor->nombre)
                            <a href="/pedido/{{$procedimiento->id}}/{{$oferta->proveedor->id}}/{{$key+1}}">
                                <button type="button" class="btn btn-primary">Generar Pedido</button>
                            </a>
                            @endif
                        @endif
                        
                    </td>
                    <td>
                        <a href="/facturas/{{$oferta->id}}">
                            <button type="button" class="btn btn-success">Facturas</button>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')

@endsection