<?php namespace App\Http\Controllers;

use App\Dependencia;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\DependenciaRequest;
use Laracasts\Flash\Flash;

class DependenciasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct()
	{
		$this->middleware('auth');
		//$this->middleware('manager');
	}

	public function index()
	{
		$dependencias = Dependencia::all();
		return view('dependencias.index', compact('dependencias'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('dependencias.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(DependenciaRequest $request)
	{
		Dependencia::create($request->all());
		Flash::success('Dependencia creada con exito');
		return redirect('dependencias');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$dependencia = Dependencia::find($id);

		if (is_null($dependencia)) {
			return view('errors.503');
		}

		return view('dependencias.show', compact('dependencia'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$dependencia = Dependencia::find($id);
		if (is_null($dependencia)) {
			return view('errors.503');
		}
		return view('dependencias.edit', compact('dependencia'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, DependenciaRequest $request)
	{
		$dependencia = Dependencia::findOrFail($id);
		$dependencia->update($request->all());
		Flash::success('Dependencia editada correctamente');
		return redirect('dependencias');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$dependencia = Dependencia::findOrFail($id);
		$dependencia->delete();
		Flash::success('Dependencia eliminada correctamente');
		return redirect('dependencias');
	}

}
