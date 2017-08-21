<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\ProcedimientoRequest;
use App\Invitacion;
use App\Oferta;
use App\Procedimiento;
use App\Proveedor;
use App\Requisicion;
use App\User;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Laracasts\Flash\Flash;

class ProcedimientosController extends Controller {

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
	public function index()
	{
		$anio = Input::get('anio');
		$mes = Input::get('mes');
		$month = $mes ? $mes : Carbon::now()->month;
		$año = $anio ? $anio : Carbon::now()->year;

		if (Auth::user()->isAnalistaProcedimiento()) {
			$procedimientos = Procedimiento::where('analista_id', Auth::user()->id)->whereYear('created_at', '=', $año)->get();
		}
		else{
			$procedimientos = Procedimiento::whereYear('created_at', '=', $año)->get();
		}
		
		
		foreach ($procedimientos as $key => $procedimiento) {
			if (sizeof($procedimiento->requisiciones) < 1) {
				dd($procedimiento->id);
			}
		}

		
		return view('procedimientos.index', compact('procedimientos', 'año'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$requisiciones = Requisicion::definitivas()->sinasignar()->get();
		$nullOption = "Selecciona";
		$analistas = ['' => "$nullOption"] + User::analistasProcedimiento()->pluck('name', 'id')->toArray();
		$requisicion_array = "create";
		return view ('procedimientos.create', compact('requisiciones', 'analistas', 'requisicion_array'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ProcedimientoRequest $request)
	{
		if (sizeof($request->requisicion) == 1) {
			$procedimiento = Procedimiento::create($request->all());
			foreach ($request->requisicion as $key => $requisicion_id) {
				$requisicion = Requisicion::findOrFail($requisicion_id);
				$requisicion->procedimiento_id = $procedimiento->id;
				$requisicion->asignada = 1;
				$requisicion->save();
			}
		}
		else {
			dd("Algo esta pasando, contactar al administrador del sistema");
		}
		
		Flash::success('Procedimiento creado correctamente');
		return redirect('procedimientos');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$procedimiento = Procedimiento::find($id);
		return view('procedimientos.show', compact('procedimiento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$proveedores = Proveedor::where('status', 1)->get();
		$procedimiento = Procedimiento::find($id);
		$requisiciones = Requisicion::where('status', 2)->get();
		//Las requisiciones del procedimiento
		$requisicion_array = $procedimiento->requisiciones->pluck('id')->toArray();
		$proveedor_array = $procedimiento->proveedores->pluck('id')->toArray();
		$nullOption = "Analista";
		$analistas = ['' => "$nullOption"] + User::pluck('name', 'id')->toArray();
		return view('procedimientos.edit', compact('procedimiento', 'requisiciones', 'requisicion_array','analistas', 'proveedor_array', 'proveedores'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ProcedimientoRequest $request, $id)
	{
		$procedimiento = Procedimiento::find($id);
		$procedimiento->update($request->all());
		$array = array();
		foreach ($procedimiento->requisiciones as $key => $requisicion) {
			array_push($array, $requisicion->id);
		}
		$dissociate = array_diff($array, $request['requisicion']);
		$associate = array_diff($request['requisicion'], $array);
		foreach ($dissociate as $key => $des) {
			$requisicion = Requisicion::findOrFail($des);
			$requisicion->asignada = 0;
			$requisicion->procedimiento()->dissociate($procedimiento);
			$requisicion->save();
		}
		foreach ($associate as $key => $as) {
			$requisicion = Requisicion::findOrFail($as);
			$requisicion->asignada = 1;
			$requisicion->procedimiento()->associate($procedimiento);
			$requisicion->save();
		}
		//$procedimiento->proveedores()->sync($request['proveedor']);
		$procedimiento->save();
		Flash::success('Procedimiento editado correctamente');
		return redirect('procedimientos');
	}

	public function licitantes($id)
	{
		$procedimiento = Procedimiento::findOrFail($id);
		$proveedores = $procedimiento->proveedoresInvitados();
		$proveedor_array = 'create';
		if (count($procedimiento->proveedores) > 0) {
			$proveedor_array = $procedimiento->proveedores->pluck('id')->toArray();
		}
		return view('procedimientos.licitantes', compact('procedimiento', 'proveedores', 'proveedor_array'));
	}

	public function licitantesStore(Request $request, $id)
	{
		$procedimiento = Procedimiento::findOrFail($id);
		//Ya se han agregado proveedores al procedimiento
		if (count($procedimiento->proveedores) > 0) {
			foreach ($procedimiento->proveedores as $key => $proveedor) {
				//Verificar que en el request ya este el proveedor asociado al procedimiento
				//Quitando ofertas del proveedor
				//dd(in_array("295", $request['proveedor']));
				if (in_array("$proveedor->id", $request['proveedor']) == FALSE) {
					$ofertas = Oferta::where('procedimiento_id', $procedimiento->id)->where('proveedor_id', $proveedor->id)->get();
					foreach ($ofertas as $key => $oferta) {
						$oferta->status = 6; //La oferta no puede ser considerada
						$oferta->ganador = false;
						$oferta->save();
					}
				}
				//Agregando ofertas del proveedor
				else {
					$ofertas = Oferta::where('procedimiento_id', $procedimiento->id)->where('proveedor_id', $proveedor->id)->get();
					foreach ($ofertas as $key => $oferta) {
						if ($oferta->status == 6) {
							$oferta->status = 1;
							$oferta->ganador = false;
							$oferta->save();
						}
					}
				}
			}
			$procedimiento->proveedores()->sync($request['proveedor']);
		}
		else {
			$procedimiento->proveedores()->attach($request['proveedor']);
		}
		$procedimiento->status = 2;
		$procedimiento->save();
		return redirect('procedimientos');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$procedimiento = Procedimiento::findOrFail($id);
		//Borrando requisiciones del procedimineto
		foreach ($procedimiento->requisiciones as $key => $requisicion_id) {
			$requisicion = Requisicion::findOrFail($requisicion_id->id);
			$requisicion->procedimiento_id = NULL;
			$requisicion->asignada = 0;
			$requisicion->save();
		}
		//Borrrando ofertas del procedimineto
		Oferta::where('procedimiento_id', $procedimiento->id)->delete();
		//Borrando invitaciones del procedimineto
		Invitacion::where('procedimiento_id', $procedimiento->id)->delete();
		$procedimiento->delete();
		Flash::success('Procedimiento eliminado correctamente');
		return redirect('procedimientos');
	}

	public function cancelar_prodecimiento($procedimiento_id, Request $request)
	{
		$procedimiento = Procedimiento::findOrFail($procedimiento_id);
		$procedimiento->status = 8;
		$procedimiento->oficio_cancelar = $request->oficio_cancelar;
		$procedimiento->save();
		return redirect()->back();
	}

	public function cancelado($procedimiento_id)
	{
		$procedimiento = Procedimiento::findOrFail($procedimiento_id);

		return view('procedimientos.cancelado', compact('procedimiento'));
	}

}
