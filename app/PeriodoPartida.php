<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodoPartida extends Model {

	protected $table = "periodos_partidas";

    protected $fillable = [
        'partida_id',
        'descripcion',
        'cantidad_articulos',
        'presupuesto'
    ];

    public function partidas()
    {
        return $this->belongsTo('App\Partida', 'partida_id');
    }

}
