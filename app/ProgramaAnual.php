<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramaAnual extends Model {

    protected $table = 'programas_anuales';

    protected $fillable = ['dependencia_id', 'presupuesto_total_anual', 
    'unidad_administrativa_id', 'domicilio', 'telefono', 'programa',
    'subprograma', 'fuente_financiamiento', 'partida_presupuestal', 'concepto'];
 
    public function partidas_presupuestales()
    {
        return $this->hasMany('App\PartidaPresupuestal');
    }

    public function dependencia()
    {
        return $this->belongsTo('App\Dependencia', 'dependencia_id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function getFuenteFinanciamientoAttribute($value)
    {
        switch ($value) {
            case 1:
                return "Estatales";
            default:
                return "No especificado";
        }
    }

    public function getPresupuestoTotalAnualAttribute($value)
    {
        return number_format($value, 2);
    }

    public function presupuesto_total()
    {
        $presupuesto_total = 0;
        foreach ($this->partidas_presupuestales as $key => $partida_presupuestal) {
            $presupuesto_total = $presupuesto_total + $partida_presupuestal->acumulado(false);
        }
        return number_format($presupuesto_total, 2);
    }
}
