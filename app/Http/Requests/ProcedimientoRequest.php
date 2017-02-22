<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProcedimientoRequest extends Request {

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
			'requisicion' => 'required|max:1|min:1',
			'analista_id' => 'required'
		];
	}

}
