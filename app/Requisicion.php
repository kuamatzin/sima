<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisicion extends Model {

	protected $table = 'requisiciones';

	protected $fillable = [
		'dependencia_id',
		'unidad_administrativa_id',
		'user_id',
		'status',
		'tipo_requisicion',
		'descripcion', 
		'partida_presupuestal', 
		'codificacion', 
		'presupuesto', 
		'origen_recursos', 
		'procedimiento_adjudicacion', 
		'tiempo_entrega', 
		'lugar_entrega', 
		'garantia', 
		'asesor', 
		'cargo_asesor',
		'email_asesor',
		'dias_pago',
		'observaciones',
		'requisitos_tecnicos',
		'requisitos_economicos',
		'requisitos_informativos',
		'condiciones_pago',
		'datos_facturacion',
		'periodo',
		'mes',
		'anio',
		'consecutivo',
		'regularizada',
                        'anticipo',
                        'lista_requisitos',
                        'vigencia',
                        'vigencia_especificacion',
                        'dias_entrega_lunes_viernes',
                        'dias_entrega_texto',
                        'hora_entrega_inicial',
                        'hora_entrega_final',
                        'instalacion',
                        'empacado'
	];

	//Permite tratar el campo como una instancia de Carbon
	protected $dates = ['published_at'];

	protected $appends = ['value_procedimiento_adjudicacion', 'value_analista', 'value_dependencia', 'value_status'];

            protected $casts = [
                'lista_requisitos' => 'array'
            ];

	/**
	 * Requisicióm pertenece a un usuario
	 * @return array
	 */
	public function usuario()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	/**
	 * La requisicion tiene muchas partidas
	 * @return array 
	 */
	public function partidas()
	{
		return $this->hasMany('App\Partida', 'requisicion_id');
	}

	/**
	 * Una requisicion puede pertenecer a una unidad administrativa
	 * @return arrat UnidadAdministrativa
	 */
	public function unidad_administrativa()
	{
		return $this->belongsTo('App\UnidadAdministrativa', 'unidad_administrativa_id');
	}

	/**
	 * Una requisicion pertenece a una dependencia
	 * @return [type] [description]
	 */
	public function dependencia()
	{
		return $this->belongsTo('App\Dependencia', 'dependencia_id');
	}

	/**
	 * Una requisición pertenece a un procedimiento
	 * @return [type] [description]
	 */
	public function procedimiento()
	{
		return $this->belongsTo('App\Procedimiento');
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

	/**
	 * Regresa de una forma más amable al usuario el status de una requisición
	 * @return string Retorna el status de una requisicion
	 */
	public function getStatusAttribute($value)
	{
		if($value == 1){
			return 'Previa';
		}
		if($value == 2){
			return 'Definitiva';
		}
		return 'Cancelada';
	}

	/**
	 * Regresa de forma mas amable para el usuario el tipo de requisicion
	 * @param  int $value Valor original
	 * @return String        Retorna el tipo de requisicion
	 */
	public function getTipoRequisicionAttribute($value)
	{
		if ($value == 1) {
			return 'Bien';
		}
		return 'Servicio';
	}

	public function origenRecursos($origen)
	{
		if ($origen == 3) {
			return "Federales";
		}
		if ($origen == 2) {
			return "Propios";
		}
		return "Estatales";
	}

	/**
	 * Ingresa en formato adecuado el atributo published_at a la base de datos
	 * @param date $date Fecha de la fecha de publicación de una noticia
	 */
	public function setPeriodoAtAttribute($date)
	{
		$this->attributes['periodo'] = Carbon::createFromFormat('Y-m-d H:i', str_replace("T"," ", $date));
	}


	public function scopeDefinitivas($query)
	{
		return $query->where('status', 2);
	}


	public function scopeSinasignar($query)
	{
		return $query->where('asignada', 0);
	}

	public function getPresupuestoAttribute($value)
            {
                return number_format($value, 2);
            }

            public function value_procedimiento_adjudicacion()
            {
            	$procedimiento_adjudicacion = $this->procedimiento_adjudicacion;
            	switch ($procedimiento_adjudicacion) {
            		case '1':
            			return "Adjudicacion Directa";
            			break;
            		case "2":
            			return "Invitación a cuando menos tres";
            			break;
            		case "3":
            			return "Licitación Pública";
            			break;
            		default:
            			return "Sin asignar";
            			break;
            	}
            }

            public function getValueProcedimientoAdjudicacionAttribute()
            {
            	$procedimiento_adjudicacion = $this->procedimiento_adjudicacion;
            	switch ($procedimiento_adjudicacion) {
            		case '1':
            			return "Adjudicacion Directa";
            			break;
            		case "2":
            			return "Invitación a cuando menos tres";
            			break;
            		case "3":
            			return "Licitación Pública";
            			break;
            		default:
            			return "Sin asignar";
            			break;
            	}
            }

            public function getValueAnalistaAttribute()
            {
                return $this->procedimiento->analista->name;
            }

            public function getValueDependenciaAttribute()
            {
                return $this->dependencia->nombre;
            }

            public function getValueStatusAttribute()
            {
                return $this->procedimiento->status;
            }

            public function getVigencia()
            {
                return $this->vigencia ? "SI" : "NO";
            }

}
