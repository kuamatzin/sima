<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model {

    protected $table = "facturas";

    protected $fillable = ['numero_factura', 'fecha_factura', 'numero_orden', 'fecha_tramite_pago', 'fecha_pedido', 'monto'];

    /**
     * Una factura pertenece a una oferta
     * @return [type] [description]
     */
    public function oferta()
    {
        return $this->belongsTo('App\Oferta');
    }

}
