<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\PartidaPresupuestalRequest;
use App\PartidaPresupuestal;
use App\ProgramaAnual;
use Illuminate\Http\Request;

class PartidasPresupuestalesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($programa_anual_id)
	{
		$programa_anual = ProgramaAnual::findOrFail($programa_anual_id);
		return view('partidas_presupuestales.create', compact('programa_anual'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($programa_anual_id, PartidaPresupuestalRequest $request)
	{
		$request['programa_anual_id'] = $programa_anual_id;
		PartidaPresupuestal::create($request->all());
		return redirect("programa_anual/$programa_anual_id");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$partida_presupuestal = PartidaPresupuestal::findOrFail($id);
		return view('partidas_presupuestales.show', compact('partida_presupuestal'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$partida_presupuestal = PartidaPresupuestal::findOrFail($id);
		return view('partidas_presupuestales.edit', compact('partida_presupuestal'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, PartidaPresupuestalRequest $request)
	{
		$partida_presupuestal = PartidaPresupuestal::findOrFail($id);
		$partida_presupuestal->update($request->all());

		return redirect("programa_anual/" . $partida_presupuestal->programa_anual->id);
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
