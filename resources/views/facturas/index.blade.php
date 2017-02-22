@extends('app')
@section('content')
<div id="facturas">
    <input type="hidden" id="token" value="{{ csrf_token() }}">
    <h3>Facturas para partida:</h3>
    <p>{{$oferta->partida->descripcion}}</p>
    <hr>
    <a href="/facturas/{{$oferta->id}}/create">
        <button type="button" class="btn btn-success">Registrar Factura</button>
    </a>
    <hr>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th>Numero de factura</th>
                    <th>Monto</th>
                    <th>Fecha de pedido</th>
                    <th>Fecha de factura</th>
                    <th>Fecha de tramite de pago</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($oferta->facturas as $key => $factura)
                <tr id="{{$factura->id}}">
                    <td>{{$key + 1}}</td>
                    <td>{{$factura->numero_factura}}</td>
                    <td>{{$factura->monto}}</td>
                    <td>{{$factura->fecha_pedido}}</td>
                    <td>{{$factura->fecha_factura}}</td>
                    <td>{{$factura->fecha_tramite_pago}}</td>
                    <td>
                        <a href="/facturas/{{$factura->id}}/edit">
                            <button type="button" class="btn btn-warning">Editar</button>
                        </a>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" v-on:click="confirmar({{$factura->id}})">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="modal-eliminar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="text-center">¿Esta seguro de que desea eliminar la factura?</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No estoy seguro</button>
                    <button type="button" class="btn btn-danger" v-on:click="eliminar()">Estoy seguro</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
    var vm = new Vue({
        el: "#facturas",
        data: {
            seleccionada: ''
        },
        methods: {
            confirmar: function(id){
                this.seleccionada = id;
                $('#modal-eliminar').modal('show')
            },
            eliminar: function(){
                this.$http.delete('/facturas/' + this.seleccionada).then(function(data, status, request){
                    if (data.data = "true") {
                        $('#' + this.seleccionada).hide('slow/400/fast');
                        $('#modal-eliminar').modal('hide')
                    }
                }, function(error){
                    console.log(error)
                    alert(error)
                });
            }
        }
    })
</script>
@endsection