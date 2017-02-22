<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Partida extends Model {

	protected $table = 'partidas';

	protected $fillable = [
		'requisicion_id',
		'partida_presupuestal_id',
		'descripcion',
		'cantidad_minima',
		'cantidad_maxima',
		'precio_unitario',
		'presupuesto_total_articulo',
		'unidad_medida',
		'marca',
		'cantidad_ajuste',
		'clave'
	];
	/**
	 * La partida pertenece a un usuario
	 * @return array 
	 */
	public function usuario(){
		return $this->belongsTo('App\User', 'user_id');
	}

	/**
	 * La partida pertenece a una requisicion
	 * @return array
	 */
	public function requisicion(){
		return $this->belongsTo('App\Requisicion', 'requisicion_id');
	}

	/**
	 * La partida pertenece a un programa anual
	 * @return array
	 */
	public function partida_presupuestal()
	{
		return $this->belongsTo('App\PartidaPresupuestal', 'partida_presupuestal_id');
	}


	public function periodos_pago()
	{
		return $this->hasMany('App\PeriodoPartida', 'partida_id');
	}

	/**
	 * Una partida tiene varias ofertas
	 * @return Oferta
	 */
	public function ofertas()
	{
		return $this->hasMany('App\Oferta');
	}

	public function motivo($proveedor_id)
	{
		$oferta = $this->ofertas->where('proveedor_id', $proveedor_id);
		if (count($oferta) > 0) {
			$oferta = $oferta->toArray();
			$oferta = reset($oferta);
			return $oferta['motivo'];
		}
	}
}
