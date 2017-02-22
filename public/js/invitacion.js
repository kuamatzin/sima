Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
var procedimiento_id = document.querySelector('#procedimiento_id').getAttribute('value');
var app = new Vue({
    el: "#busqueda",
    data: {
        proveedores_seleccionados : [],
        loader : false,
        proveedores_show : false,
        invitados_show : false
    },
    methods: {
        getProveedores: function(){
            var that = this;
            this.proveedores_show = true;
            this.$http.get('/invitacion/' + procedimiento_id, { actividad: this.actividad, rfc: this.rfc, nombre: this.nombre }, function(data, status, request){
                this.$set('proveedores', data);
            }).then(function(){
                that.proveedores_show = false;
            }, function(error){
                console.log(error)
            });
        },
        getProveedoresInvitados: function(){
            var that = this;
            this.invitados_show = true;
            this.$http.get('/proveedores_invitados/' + procedimiento_id, {}, function(data, status, request){
                this.$set('proveedores_invitados', data);
            }).then(function(){
                that.invitados_show = false;
            }, function(error){
                console.log(error)
            });
        },
        addProveedor: function(proveedor){
            this.proveedores_seleccionados.push(proveedor);
        },
        removeProveedor: function(proveedor){
            this.proveedores_seleccionados.splice(proveedor, 1);
        },
        enviarInvitacion: function(tipoInvitacion){
            var that = this;
            this.loader = true;
            console.log(this.fecha_caducidad)
            var proveedores_ids = [];
            for (var i = this.proveedores_seleccionados.length - 1; i >= 0; i--) {
                proveedores_ids.push(this.proveedores_seleccionados[i].id);
            };
            this.$http.post('/invitacion/' + procedimiento_id, { proveedores: proveedores_ids , fecha_caducidad: this.fecha_caducidad, tipoInvitacion: tipoInvitacion }, function(data, status, request){
                this.getProveedoresInvitados();
                this.proveedores_seleccionados = [];
            }).then(function(){
                that.loader = false;
            }, function(error){
                console.log("Error")
            });
        }
    }
});

app.getProveedoresInvitados();
//# sourceMappingURL=invitacion.js.map
