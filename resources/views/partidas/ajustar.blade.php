@extends('app')

@section('content')
    <h3>Editar cantidades</h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Cantidad Original</th>
                <th>Cantidad Editar</th>
            </tr>
        </thead>
        <tbody>
            {!! Form::open(['url' => 'ajustar_cantidades/' . $procedimiento->id]) !!}
                @foreach($procedimiento->requisiciones[0]->partidas as $key => $partida)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$partida->descripcion}}</td>
                    <td>{{$partida->marca}}</td>
                    <td>{{$partida->cantidad_minima}}</td>
                    <td>       
                        @if(!is_numeric($partida->cantidad_ajuste))
                            {!! Form::text('cantidad_ajuste[]', $partida->cantidad_minima, ['class' => 'form-control']) !!}
                        @else
                            {!! Form::text('cantidad_ajuste[]', $partida->cantidad_ajuste, ['class' => 'form-control']) !!}
                        @endif
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>
    <button type="submit" class="btn btn-warning pull-right">Editar cantidades</button>
    {!! Form::close() !!}
@endsection

@section('scripts')

@endsection