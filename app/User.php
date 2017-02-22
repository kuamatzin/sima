<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'dependencia_id', 'unidad_administrativa_id', 'privilegios'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];


	/**
	 * Usuario tiene muchas requisiciones
	 * @return array
	 */
	public function requisiciones()
	{
		return $this->hasMany('App\Requisicion');
	}

	/**
	 * Este usuario pertenece(administra) a una dependencia
	 * @return array 
	 */
	public function dependencia()
	{
		return $this->belongsTo('App\Dependencia', 'dependencia_id');
	}

	/**
	 * Usuario tiene muchas partidas
	 * @return array
	 */
	public function partidas()
	{
		return $this->hasMany('App\Partida');
	}

	/**
	 * Usuario tiene multiple cantidad de operaciones
	 * @return array Todas las operaciones que ha creado un usuario
	 */
	public function procedimientos()
	{
		return $this->hasMany('App\Procedimiento', 'analista_id');
	}


	/**
	 * Un usuario tiene multiples programas anuales
	 * @return array Todos los programas anuales
	 */
	public function programas_anuales()
	{
		return $this->hasMany('App\ProgramaAnual', 'user_id');
	}

	/**
	 * Determina si un usuario es un administrador o no
	 * @return boolean
	 */
	public function isAManager()
	{
		if (\Auth::user()->privilegios == 1) {
			return true;
		}
		return false;
	}

	public function isAMonitor()
	{
		if (\Auth::user()->privilegios == 2) {
			return true;
		}
		return false;
	}

	/**
	 * Determina si un usuario es analista
	 * @return boolean
	 */
	public function isAnalista()
	{
		if (\Auth::user()->privilegios == 3) {
			return true;
		}
		return false;
	}

	/**
	 * Determina si un usuario es analista de unidad
	 * @return boolean
	 */
	public function isAnalistaUnidad()
	{
		if (\Auth::user()->privilegios == 4) {
			return true;
		}
		return false;
	}


	public function isAnalistaProcedimiento(){
		if (\Auth::user()->privilegios == 5) {
			return true;
		}
		return false;
	}

	/**
	 * Regresa el tipo de usuario de una forma más entendible para el frontend
	 * @return string Retorna el tipo de usuario
	 */
	public function getTipoUsuario()
	{
		if($this->privilegios == 2){
			return 'Monitor';
		}
		if($this->privilegios == 3){
			return 'Analista';
		}
		if ($this->privilegios == 4) {
			return 'Analista Unidad Administrativa';
		}
		if ($this->privilegios == 5) {
			return 'Analista Procedimiento';
		}
		return 'Administrador';
	}

	public function scopeAnalistasProcedimiento($query)
	{
		return $query->where('privilegios', 5);
	}

	public function scopeAnalistasUnidadAdministrativa($query)
	{
		return $query->where('privilegios', 4);
	}

	public function scopeAnalistas($query)
	{
		return $query->where('privilegios', 3);
	}

	public function scopeMonitores($query)
	{
		return $query->where('privilegios', 2);
	}

	public function scopeAdministradores($query)
	{
		return $query->where('privilegios', 1);
	}

}
