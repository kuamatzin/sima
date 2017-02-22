@extends('app')

@section('content')
<div class="container">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Proveedor</th>
                    <th>Adjudicado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ofertas_ganadoras as $key => $adjudicado)
                <tr>
                    <td>{{$adjudicado['proveedor']}}</td>
                    <td>${{number_format($adjudicado['monto_total_adjudicado'], 2)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')

@endsection