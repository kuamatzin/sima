<?php namespace App;

use App\Oferta;
use Illuminate\Database\Eloquent\Model;

class Procedimiento extends Model {

	protected $table = 'procedimientos';

	protected $fillable = [
		'analista_id',
		'status_invitacion',
		'oficio_cancelar'
	];

	/**
	 * Una operacion puede ser administrada por un solo analista
	 * @return User Retorna un objecto de la clase Usuario
	 */
	public function analista()
	{
		return $this->belongsTo('App\User', 'analista_id');
	}

	/**
	 * Un procedimiento tiene mas de un proveedor
	 * @return array Retorna colección de todos los proveedores de un procedimiento
	 */
	public function proveedores()
	{
		return $this->belongsToMany('App\Proveedor')->withTimestamps();
	}

	public function proveedoresInvitados()
	{
		$proveedores = array();
		foreach ($this->invitaciones as $key => $invitacion) {
			$proveedor = $invitacion->proveedor;
			$proveedor['cotizacion_enviada'] = $invitacion->enviado;
			$proveedor['estaInvitacion_id'] = $invitacion->id;
			$proveedor['archivo_cotizacion'] = $invitacion->cotizacion_proveedor;
			array_push($proveedores, $proveedor);
		}
		return $proveedores;
	}

	public function numeroProcedimiento()
	{
		$requisicion = $this->requisiciones[0];
		$numero = $requisicion->mes . '_' . $requisicion->consecutivo;
		return $numero;
	}

	public function descripcion()
	{
		return $this->requisiciones[0]->descripcion;
	}

	/**
	 * Un procedimiento tiene una o más requisiciones
	 * @return array Retorna todas las requisiciones de un procedimineto
	 */
	public function requisiciones()
	{
		return $this->hasMany('App\Requisicion', 'procedimiento_id');
	}

	/**
	 * Un procedimineto tiene una o más ofertas
	 * @return array Retorna todas las ofertas de un procedimiento
	 */
	public function ofertas()
	{
		return $this->hasMany('App\Oferta');
	}

	/**
	 * Ofertas ganandoras de un procedimiento
	 * @return collection Ofertas 
	 */
	public function ofertasGanadoras()
	{
		return $this->hasMany('App\Oferta')->where('ganador', 1)->orderBy('id', 'ASC')->get();
	}

	public function totalAdjudicado()
	{
		$totalAdjudicado = $this->hasMany('App\Oferta')->where('ganador', 1)->sum('monto_total');
		return number_format($totalAdjudicado, 2);
	}

	public function totalAdjudicadoCantidad()
	{
		return $this->hasMany('App\Oferta')->where('ganador', 1)->sum('monto_total');
	}

	public function invitaciones()
	{
		return $this->hasMany('App\Invitacion');
	}

	public function proveedoresAdjudicados()
	{
		$proveedoresSeleccionadosProcedimiento = $this->proveedores;
		$proveedoresAdjudicados = Proveedor::find($this->hasMany('App\Oferta')->where('ganador', 1)->where('status', 1)->pluck('proveedor_id')->toArray());

		return $proveedoresAdjudicados;
	}

	public function adjudicadoPorProveedor($proveedor_id)
	{
		$montoAdjudicado = $this->hasMany('App\Oferta')->where('ganador', 1)->where('proveedor_id', $proveedor_id)->orderBy('id', 'ASC')->sum('monto_total');

		return number_format($montoAdjudicado, 2);
	}

	public function proveedoresAdjudicadosFormated()
	{
		$proveedores = $this->proveedoresAdjudicados();
		$proveedores_string = '';
		foreach ($proveedores as $key => $proveedor) {
			if ($key == 0) {
				$proveedores_string = $proveedores_string . $proveedor->nombre;
			}
			else {
				$proveedores_string = $proveedores_string . ' - ' . $proveedor->nombre;
			}
		}
		return $proveedores_string;
	}

	/**
	 * Retorna el status de un procedimiento de manera mas amigable para el usuario
	 * @param  integer $value Status del procedimiento
	 * @return string        Status del procedimiento
	 */
	public function getStatusAttribute($value)
	{
		switch ($value) {
			case 1:
				return "Creado";
				break;
			case 2:
				return "En cotización";
				break;
			case 3:
				return "Dictamen Técnico";
				break;
			case 4:
				return "Carga Económica";
				break;
			case 5:
				return "Analisis Comparativo";
				break;
			case 6:
				return "Pedido";
				break;
			case 7:
				return "Factura";
				break;
			case 8:
				return "Cancelado";
				break;
			default:
				return "Status pendiente";
				break;
		}
	}
}
