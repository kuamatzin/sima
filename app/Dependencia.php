<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model {

	protected $table = 'dependencias';

	protected $fillable = [
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
	 * La dependencia tiene muchos usuarios que la administran
	 * @return array 
	 */
	public function usuarios()
	{
		return $this->hasMany('App\User')->where('privilegios', 3);
	}

	/**
	 * La dependencia tiene muchos usuarios que la administran
	 * @return array 
	 */
	public function usuariosUnidadAdministrativa()
	{
		return $this->hasMany('App\User')->where('privilegios', 4);
	}

	/**
	 * La dependencia tiene varias requisiciones
	 * @return array
	 */
	public function requisiciones()
	{
		return $this->hasMany('App\Requisicion');
	}

	/**
	 * Dependencia puede tener una o más unidades administrativas
	 * @return array Unidades Administrativas
	 */
	public function unidades_administrativas()
	{
		return $this->hasMany('App\UnidadAdministrativa');
	}

}
