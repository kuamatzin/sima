<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\PartidaRequest;
use App\Partida;
use App\PartidaPresupuestal;
use App\PeriodoPartida;
use App\ProgramaAnual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartidaProgramaAnualController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id_requisicion)
	{	
		$requisicion = Requisicion::find($id_requisicion);
		return view('partidasProgramaAnual.index', compact('requisicion'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($programa_anual_id)
	{
		$requisicion_view = false;
		$partida_presupuestal = PartidaPresupuestal::find($programa_anual_id);
		return view('partidasProgramaAnual.create', compact('partida_presupuestal', 'requisicion_view'));
	}

	public function createPeriodosPartidas($request, $partida)
	{
		foreach ($request->cantidades as $key => $cantidad) {
			if ($cantidad != "" && $request->presupuestos[$key] != "") {
				$periodo_partida = new PeriodoPartida;
				$periodo_partida->partida_id = $partida->id;
				$periodo_partida->descripcion = $key + 1;
				$periodo_partida->cantidad_articulos = $cantidad;
				$periodo_partida->presupuesto = $request->presupuestos[$key];
				$periodo_partida->save();
			}
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(PartidaRequest $request, $partida_presupuestal_id)
	{
		$request['partida_presupuestal_id'] = $partida_presupuestal_id;
		$partida = Auth::user()->partidas()->create($request->all());
		$this->createPeriodosPartidas($request, $partida);

		return redirect('partidas_presupuestales/show/' . $partida_presupuestal_id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$partida = Partida::findOrFail($id);
		return view('partidasProgramaAnual.show', compact('partida'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$requisicion_view = false;
		$partida = Partida::findOrFail($id);
		$nums = array();
		$verificar = array();
		$periodos = $partida->periodos_pago()->orderBy('descripcion', 'asc')->get();
		foreach ($partida->periodos_pago as $key => $periodo) {
			array_push($nums, $periodo->descripcion);
		}
		sort($nums);
		$cont = 0;
		for ($i=1; $i < 5; $i++) {
			$valores = array();
			$vals = array();
			if (in_array($i, $nums)) {
				array_push($vals, $periodos[$cont]->cantidad_articulos);
				array_push($vals, $periodos[$cont]->presupuesto);
				array_push($vals, $periodos[$cont]->id);
				array_push($verificar, $vals);
				$cont = $cont + 1;
			}
			else {
				array_push($vals, "");
				array_push($vals, "");
				array_push($vals, "");
				array_push($verificar, $vals);
			}
		}
		return view('partidasProgramaAnual.edit', compact('partida', 'requisicion_view', 'verificar'));
	}

	public function updatePeriodoPartidas($request, $partida)
	{
		foreach ($request->cantidades as $key => $cantidad) {
			if ($cantidad != "" && $request->presupuestos[$key] != "") {
				$periodo_pago = PeriodoPartida::find($request->ids[$key]);
				if ($periodo_pago != null) {
					$periodo_pago->cantidad_articulos = $request->cantidades[$key];
					$periodo_pago->presupuesto = $request->presupuestos[$key];
					$periodo_pago->save();
				}
				else {
					$periodo_partida = new PeriodoPartida;
					$periodo_partida->partida_id = $partida->id;
					$periodo_partida->descripcion = $key + 1;
					$periodo_partida->cantidad_articulos = $cantidad;
					$periodo_partida->presupuesto = $request->presupuestos[$key];
					$periodo_partida->save();
				}
			}
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(PartidaRequest $request , $partida_id)
	{
		$partida = Partida::findOrFail($partida_id);
		$partida->update($request->all());
		$this->updatePeriodoPartidas($request, $partida);
		return redirect('partidas_presupuestales/show/' . $partida->partida_presupuestal->id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id_partida)
	{
		$partida = Partida::findOrFail($id_partida);
		$partida_presupuestal_id = $partida->partida_presupuestal_id;
		$partida->delete();
		return redirect('partidas_presupuestales/show/' . $partida_presupuestal_id);
	}

}
