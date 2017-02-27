<?php namespace App\Http\Controllers;

use App\Dependencia;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\UnidadAdministrativaRequest;
use App\UnidadAdministrativa;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class UnidadesAdministrativasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$unidades_administrativas = UnidadAdministrativa::all();
		return view('unidades_administrativas.index', compact('unidades_administrativas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($dependencia_id)
	{
		$dependencia = Dependencia::findOrFail($dependencia_id);
		return view('unidades_administrativas.create', compact('dependencia'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(UnidadAdministrativaRequest $request, $dependencia_id)
	{
		$request['dependencia_id'] = $dependencia_id;
		UnidadAdministrativa::create($request->all());
		Flash::success('Unidad Administrativa creada con exito');
		return redirect("dependencias/$dependencia_id");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$unidad_administrativa = UnidadAdministrativa::findOrFail($id);
		return view('unidades_administrativas.show', compact('unidad_administrativa'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$nullOption = "Dependencia a la que pertenece";
		$dependencias = ['' => "$nullOption"] + Dependencia::pluck('nombre', 'id')->toArray();
		$unidad_administrativa = UnidadAdministrativa::findOrFail($id);
		return view('unidades_administrativas.edit', compact('unidad_administrativa', 'dependencias'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(UnidadAdministrativaRequest $request, $id)
	{
		$unidad_administrativa = UnidadAdministrativa::findOrFail($id);
		$unidad_administrativa->update($request->all());
		Flash::success('Unidad Administrativa editada correctamente');
		return redirect('unidades_administrativas');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
