<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class DependenciaRequest extends Request {

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
			'nombre'          => 'required|min:3',
			'calle'           => 'required|min:3',
			'numero_exterior' => 'required',
			'colonia'         => 'required|min:3',
			'municipio'       => 'required',
			'lada'            => 'required|min:2',
			'telefono'        => 'required|min:3',
			'siglas'          => 'required',
			'titular'         => 'required|min:3',
			'cargo_titular'   => 'required|min:3',
			'autoriza'        => 'required|min:3',
			'cargo_autoriza'  => 'required|min:3',
			'valida'          => 'required|min:3',
			'cargo_valida'    => 'required|min:3'
		];
	}

}
