<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PartidaPresupuestal extends Model {

    protected $table = 'partidas_presupuestales';

    protected $fillable = ['programa_anual_id', 'partida_presupuestal', 'concepto'];

    public function programa_anual()
    {
        return $this->belongsTo('App\ProgramaAnual');
    }

    public function partidas()
    {
        return $this->hasMany('App\Partida', 'partida_presupuestal_id');
    }

    public function acumulado($formated = true)
    { 
        if ($formated) {
            return number_format($this->partidas->sum('presupuesto_total_articulo'), 2);
        }
        return $this->partidas->sum('presupuesto_total_articulo');
    }
}
