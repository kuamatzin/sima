<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class RequisicionRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'status'                     => 'required',
			'tipo_requisicion'           => 'required',
			'descripcion'                => 'required|min:10',
			'partida_presupuestal'       => 'required|numeric',
			'codificacion'               => 'required',
			'presupuesto'                => 'required|numeric',
			'origen_recursos'            => 'required',
			'procedimiento_adjudicacion' => 'required',
			'tiempo_entrega'             => 'required',
			'lugar_entrega'              => 'required',
			'garantia'                   => 'required',
			'asesor'                     => 'required',
			'cargo_asesor'               => 'required',
			'email_asesor'               => 'required|email|max:255',
			'dias_pago'                  => 'required',
			'condiciones_pago'           => 'required',
			'datos_facturacion'          => 'required'
		];
	}

}
