<?php namespace App\Http\Controllers;

use App\Dependencia;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\ProgramaAnualRequest;
use App\Http\Requests\RequisicionRequest;
use App\ProgramaAnual;
use App\Requisicion;
use App\Services\ExcelGenerator;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Laracasts\Flash\Flash;

class ProgramaAnualController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	
		if (Input::get('anio')) {
			$año = Input::get('anio');
		}
		else {
			$año = date("Y");
		}
		if (Auth::user()->isAnalista() || Auth::user()->isAnalistaUnidad()) {
			$programas_anuales = ProgramaAnual::whereYear('created_at', '=', $año)->where('dependencia_id', Auth::user()->dependencia_id)->get();
		}
		else {
			$programas_anuales = ProgramaAnual::whereYear('created_at', '=', $año)->get();
		}
		$dependencias = Dependencia::all();
		return view('programas_anuales.index', compact('programas_anuales', 'dependencias', 'año'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$programa_anual = new ProgramaAnual;
		$programa_anual['fuente_financiamiento'] = 0;
		$nullOption = "Dependencia a la que pertenece";
		$dependencias = ['' => "$nullOption"] + Dependencia::pluck('nombre', 'id')->toArray();
		return view('programas_anuales.create', compact('dependencias', 'programa_anual'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ProgramaAnualRequest $request)
	{
		$programa_anual = Auth::user()->programas_anuales()->create($request->all());
		Flash::success('Programa anual creado correctamente');
		return redirect('programa_anual');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$programa_anual = ProgramaAnual::findOrFail($id);
		return view('programas_anuales.show', compact('programa_anual'));
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
		$programa_anual = ProgramaAnual::findOrFail($id);
		return view('programas_anuales.edit', compact('programa_anual', 'dependencias'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($programa_anual_id, ProgramaAnualRequest $request)
	{
		$programa_anual = ProgramaAnual::findOrFail($programa_anual_id);
		$programa_anual->update($request->all());
		Flash::success('Programa Anual editado correctamente');
		return redirect('programa_anual');
	}

	public function duplicar($programa_anual_id)
	{
		$programa_anual = ProgramaAnual::findOrFail($programa_anual_id);
		$nuevo_programa_anual = $programa_anual->replicate();
		$nuevo_programa_anual->save();
		foreach ($programa_anual->partidas_presupuestales as $key => $partida_presupuestal) {
			$nueva_partida_presupuestal = $partida_presupuestal->replicate();
			foreach ($partida_presupuestal->partidas as $key => $partida) {
				$nueva_partida = $partida->replicate();
				$nueva_partida->partida_presupuestal_id = $nueva_partida_presupuestal->id;
				$nueva_partida->save();
				$nueva_partida_presupuestal->partidas()->save($nueva_partida);
			}
			$nueva_partida_presupuestal->programa_anual_id = $nuevo_programa_anual->id;
			$nueva_partida_presupuestal->save();
			$nuevo_programa_anual->partidas_presupuestales()->save($nueva_partida_presupuestal);
		}

		return redirect('programa_anual');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		ProgramaAnual::delete($id);
		Flash::success('Programa Anual eliminado correctamente');
		return redirect('requisiciones');
	}


	public function descarga($programa_anual_id, $formato)
	{
		$programa_anual = ProgramaAnual::findOrFail($programa_anual_id);
		$excel = new ExcelGenerator;
		$programa_anual['formato'] = $formato;
		$excel->descargaProgramaAnual($programa_anual);
	}

}
