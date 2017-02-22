<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadAdministrativa extends Model {

	protected $table = 'unidades_administrativas';

    protected $fillable = [
        'dependencia_id',
        'nombre',
        'calle',
        'numero_exterior',
        'numero_interior', 
        'colonia', 
        'municipio', 
        'lada', 
        'telefono', 
        'siglas', 
        'titular', 
        'cargo_titular', 
        'autoriza', 
        'cargo_autoriza', 
        'valida', 
        'cargo_valida'
    ];

    /**
     * Una unidad administrativa pertenece a una dependencia
     * @return array Dependencia
     */
    public function dependencia()
    {
        return $this->belongsTo('App\Dependencia');
    }

    /**
     * Todos los usuarios de una unidad administrativa
     * @return Array Users
     */
    public function usuarios()
    {
        return $this->hasMany('App\User', 'unidad_administrativa_id');
    }

    /**
     * Todas las requisiciones de una unidad administrativa
     * @return array Requisicion
     */
    public function requisiciones()
    {
        return $this->hasMany('App\Requisicióm', 'unidad_administrativa_id');
    }

}
