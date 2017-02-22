<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model {

	protected $table = 'proveedores';

	protected $fillable = [
		'nombre',
		'representante',
		'lada',
		'telefono', 'telefono2', 'telefono3', 'telefono4',
		'email', 'email2', 'email3', 'email4',
		'direccion',
		'rfc',
		'status',
		'pagina_web',
		'folio',
		'actividad',
		'estado',
		'clabe',
		'fecha_alta',
		'fecha_recibido_alta',
		'fecha_renovacion',
		'fecha_recibido_renovacion',
		'observaciones',
		'temporal'
	];

	/**
	 * Un proveedor tiene mas de un procedimiento
	 * @return array Retorna colección de todos los procedimientos de un proveedor
	 */
	public function procedimientos(){
		return $this->belongsToMany('App\Procedimiento')->withTimestamps();
	}

	/**
	 * Un proveedor posee varias ofertas que ha efectuado
	 * @return Oferta Colección de ofertas del proveedor
	 */
	public function ofertas()
	{
		return $this->hasMany('App\Oferta');
	}

	/**
	 * Método para saber cuando marcar como "cheked" en editar en form.blade.php de procedimientos
	 * Compara el id de una requisicion con el array de procedimientos->requisiciones(Devuelve
	 * una coleccion de requisiciones pertenecientes a un procedimiento), es decir compara todas
	 * las requisiciones con las requisiciones de un procedimiento
	 * @param  array $requisicion_array Requisiciones de un procedimiento
	 * @return boolean                  Retorna true cuando existe coincidencia
	 */
	public function checkId($requisicion_array)
	{
		if (array_search($this->id, $requisicion_array) !== false) {
			return true;
		}
		return false;
	}

	public function getStatusAttribute($value)
	{
		switch ($value) {
			case 1:
				return "Libre";
				break;
			case 2:
				return "Vetado";
				break;
			
			default:
				return "Sin definir";
				break;
		}
	}

	public function setStatusAttribute($value)
    {
    	switch ($value) {
    		case 'Libre':
    			$status = 1;
    			break;
    		case 'Vetado':
    			$status = 2;
    			break;
    		default:
    			$status = 1;
    			break;
    	}
        $this->attributes['status'] = $status;
    }

}
