<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Invitacion extends Model {

	protected $table = "invitaciones";

    protected $fillable = ['proveedor_id', 'procedimiento_id', 'url', 'fecha_caducidad', 'enviado'];

    protected $appends = ['proveedor_datos'];

    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }
    
    public function procedimiento()
    {
        return $this->belongsTo('App\Procedimiento', 'procedimiento_id');
    }

    public function setFechaCaducidadAttribute($date)
    {
        $this->attributes['fecha_caducidad'] = Carbon::createFromFormat('Y-m-d H:i', str_replace("T"," ", $date));
    }

    public function getProveedorDatosAttribute()
    {
        return $this->proveedor;
    }
}
