<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\PartidaRequest;
use App\Oferta;
use App\Partida;
use App\Procedimiento;
use App\Requisicion;
use Auth;
use Illuminate\Http\Request;

class PartidasController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
		//$this->middleware('manager');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id_requisicion)
	{	
		$requisicion = Requisicion::find($id_requisicion);
		return view('partidas.index', compact('requisicion'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($requisicion_id)
	{
		$requisicion = Requisicion::find($requisicion_id);
		return view('partidas.create', compact('requisicion', 'requisicion_view'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(PartidaRequest $request, $id_requisicion)
	{
		$request['requisicion_id'] = $id_requisicion;
		$request['cantidad_maxima'] = $request->cantidad_maxima == null ? '' : $request->cantidad_maxima;
		$request['clave'] = $request->clave == null ? '' : $request->clave;
		Auth::user()->partidas()->create($request->all());

		return redirect('partidas/' . $id_requisicion);
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
		return view('partidas.show', compact('partida'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$partida = Partida::findOrFail($id);
		return view('partidas.edit', compact('partida', 'requisicion_view'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(PartidaRequest $request , $id_requisicion, $id_partida)
	{
		$partida = Partida::findOrFail($id_partida);
		$request['cantidad_maxima'] = $request->cantidad_maxima == null ? '' : $request->cantidad_maxima;
		$request['clave'] = $request->clave == null ? '' : $request->clave;
		$partida->update($request->all());

		return redirect('partidas/' . $id_requisicion);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id_requisicion, $id_partida)
	{
		$partida = Partida::findOrFail($id_partida);
		$partida->delete();
		return redirect('partidas/' . $id_requisicion);
	}


	public function ajustar($procedimiento_id)
	{
		$procedimiento = Procedimiento::findOrFail($procedimiento_id);
		return view('partidas.ajustar', compact('procedimiento'));
	}

	public function storeAjuste(Request $request, $procedimiento_id)
	{
		$procedimiento = Procedimiento::findOrFail($procedimiento_id);
		$requisicion = Requisicion::findOrFail($procedimiento->requisiciones[0]->id);
		foreach ($requisicion->partidas as $key => $partida) {
			$partida->cantidad_ajuste = $request->cantidad_ajuste[$key];
			$partida->save();
			$ofertas = Oferta::where('partida_id', $partida->id)->get();
			foreach ($ofertas as $key => $oferta) {
				$precio_unitario = $oferta->precio_unitario;
				$oferta->importe_sin_iva = $precio_unitario * $partida->cantidad_ajuste;
				$oferta->importe_con_iva = ($precio_unitario * $partida->cantidad_ajuste * ($oferta->iva/100) + $precio_unitario * $partida->cantidad_ajuste);
				$oferta->monto_total = ($precio_unitario * $partida->cantidad_ajuste * ($oferta->iva/100) + $precio_unitario * $partida->cantidad_ajuste);
				$oferta->save();
			}
		}

		return redirect('analisis_comparativo/' .  $procedimiento_id . '/0');
	}

}
