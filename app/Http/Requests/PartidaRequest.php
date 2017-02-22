<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PartidaRequest extends Request {

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
			'descripcion'     => 'required',
			'cantidad_minima' => 'required|numeric',
			'unidad_medida'   => 'required'
		];
	}

}
