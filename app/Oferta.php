<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model {

	protected $fillable = ['procedimiento_id', 'proveedor_id', 'partida_id', 'status', 'motivo', 'cantidad', 'cantidad_minima', 'cantidad_maxima', 'precio_unitario', 'importe_sin_iva', 'iva', 'importe_con_iva', 'monto_total', 'condiciones_pago', 'tiempo_entrega', 'vigencia', 'clave', 'marca'];
    
    /**
     * Una oferta pertenece a una partida
     * @return Partida Model
     */
    public function partida()
    {
        return $this->belongsTo('App\Partida');
    }

    /**
     * Una oferta pertenece a una requisicion
     * @return Requisicion Model 
     */
    public function procedimiento()
    {
        return $this->belongsTo('App\Procedimiento');
    }

    /**
     * Una oferta puede tener varias facturas
     * @return Factura Collection
     */
    public function facturas()
    {
        return $this->hasMany('App\Factura');
    }

    /**
     * Una oferta pertenece a un proveedor
     * @return Proveedor Model
     */
    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }

    public function getPrecioUnitarioFormated()
    {
        return number_format($this->precio_unitario, 2);
    }

    public function getMontoTotalFormated()
    {
        return number_format($this->monto_total, 2);
    }

    public function getImporteConIva()
    {
        return number_format($this->importe_con_iva, 2);
    }

    public function getImporteSinIva()
    {
        return number_format($this->importe_sin_iva, 2);
    }
}
