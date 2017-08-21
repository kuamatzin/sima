<?php namespace App\Http\Controllers;

use App\Dependencia;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\RequisicionRequest;
use App\Requisicion;
use App\Services\WordGenerator;
use App\UnidadAdministrativa;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Laracasts\Flash\Flash;

class RequisicionesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	public function index()
	{
		$programa_anual = false;
		$anio = Input::get('anio');
		$mes = Input::get('mes');
		$month = $mes ? $mes : Carbon::now()->month;
		$year = $anio ? $anio : Carbon::now()->year;
		$requisiciones = Requisicion::where('anio', $year)->where('mes', $month);
		if (Auth::user()->isAnalista()) {
			$requisiciones = $requisiciones->where('dependencia_id', Auth::user()->dependencia_id)->get();
		}
		elseif (Auth::user()->isAnalistaUnidad()) {
			$requisiciones = $requisiciones->where('unidad_administrativa_id', Auth::user()->unidad_administrativa_id)->get();
		}
		else {
			$requisiciones = $requisiciones->get();
		}

		$dependencias = Dependencia::all();
		return view('requisiciones.index', compact('programa_anual', 'requisiciones', 'dependencias', 'year', 'month'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{	
		$programa_anual = false;
		$nullOption = "Dependencia a la que pertenece";
		$dependencias = ['' => "$nullOption"] + Dependencia::pluck('nombre', 'id')->toArray();
		$edit = false;
		$requisicion;
		return view('requisiciones.create', compact('dependencias', 'edit', 'programa_anual', 'requisicion'));
	}


	private function datosRequisicion($requisicion, $request, $edit = false)
	{
		$mytime = Carbon::now();
		$editar_codigo = false;
		if ($request->regularizar == null) {
			if (!$edit) {
				$last_requisicion = Requisicion::where('mes', $mytime->month)->where('anio', $mytime->year)->orderBy('consecutivo', 'desc')->first();
				if ($last_requisicion == null) {
					$request['consecutivo'] = 1;
				}
				else {
					if ($last_requisicion->mes == $mytime->month && $last_requisicion->anio == $mytime->year) {
						$request['consecutivo'] = $last_requisicion->consecutivo + 1;
					}
					else {
						$request['consecutivo'] = 1;
					}
				}
				$request['mes'] = $mytime->month;
				$request['anio'] = $mytime->year;
			}
			else {
				$request['consecutivo'] = $requisicion->consecutivo;
				$request['mes'] = $requisicion->mes;
				$request['anio'] = $requisicion->anio;
			}
			$request['regularizada'] = false;
		}
		else {
			$editar_codigo = true;
			$fecha_regularizacion = explode("-", $request->fecha_regularizacion);
			$last_requisicion = Requisicion::where('mes', $fecha_regularizacion[1])->orderBy('created_at', 'desc')->first();
			if ($last_requisicion != null) {
				$request['consecutivo'] = $last_requisicion->consecutivo + 1;
				$request['mes'] = $fecha_regularizacion[1];
				$request['anio'] = $fecha_regularizacion[0];
				$request['regularizada'] = true;
			}
			else {
				$request['consecutivo'] = 1;
				$request['mes'] = $fecha_regularizacion[1];
				$request['anio'] = $fecha_regularizacion[0];
				$request['regularizada'] = true;
			}
		}

		if ($request->unidad_administrativa_id != null) {
			$unidad_administrativa = UnidadAdministrativa::findOrFail($request->unidad_administrativa_id);
			$request['dependencia_id'] = $unidad_administrativa->dependencia->id;
		}

		$requisicion->dependencia_id = $request->dependencia_id;
		if ($edit == false) {
			$requisicion->user_id = Auth::user()->id;
			$requisicion->unidad_administrativa_id = $request->unidad_administrativa_id;
		}
		$requisicion->mes = $request->mes;
		$requisicion->anio = $request->anio;
		$requisicion->consecutivo = $request->consecutivo;
		$requisicion->regularizada = $request->regularizada;
		$requisicion->tipo_requisicion = $request->tipo_requisicion;
		$requisicion->status = $request->status;
		$requisicion->descripcion = $request->descripcion;
		$requisicion->partida_presupuestal = $request->partida_presupuestal;
		$requisicion->codificacion = $request->codificacion;
		$requisicion->presupuesto = $request->presupuesto;
		$requisicion->origen_recursos = $request->origen_recursos;
		$requisicion->procedimiento_adjudicacion = $request->procedimiento_adjudicacion;
		$requisicion->tiempo_entrega = $request->tiempo_entrega;
		$requisicion->lugar_entrega = $request->lugar_entrega;
		$requisicion->garantia = $request->garantia;
		$requisicion->asesor = $request->asesor;
		$requisicion->cargo_asesor = $request->cargo_asesor;
		$requisicion->email_asesor = $request->email_asesor;
		$requisicion->dias_pago = $request->dias_pago;
		$requisicion->observaciones = $request->observaciones == null ? '' : $request->observaciones;
		$requisicion->requisitos_tecnicos = $request->requisitos_tecnicos == null ? '' : $request->requisitos_tecnicos;
		$requisicion->requisitos_economicos = $request->requisitos_economicos == null ? '' : $request->requisitos_economicos;
		$requisicion->requisitos_informativos = $request->requisitos_informativos == null ? '' : $request->requisitos_informativos;
		$requisicion->condiciones_pago = $request->condiciones_pago;
		$requisicion->datos_facturacion = $request->datos_facturacion;
		$requisicion->anticipo = $request->anticipo == null ? '' : $request->anticipo;
		$requisicion->vigencia = $request->vigencia == null ? 0 : 1;
		$requisicion->vigencia_especificacion = $request->vigencia_especificacion == null ? '' : $request->vigencia_especificacion;
		$requisicion->dias_entrega_lunes_viernes = $request->dias_entrega_lunes_viernes;
		$requisicion->dias_entrega_texto = $request->dias_entrega_texto == null ? '' : $request->dias_entrega_texto;
		$requisicion->hora_entrega_inicial = $request->hora_entrega_inicial == null ? '' : $request->hora_entrega_inicial;
		$requisicion->hora_entrega_final = $request->hora_entrega_final == null ? '' : $request->hora_entrega_final;
		$requisicion->instalacion = $request->instalacion == null ? 0 : 1;
		$requisicion->empacado = $request->empacado == null ? 0 : 1;
		$requisicion->lista_requisitos = $request->lista_requisitos == null ? '' : $request->lista_requisitos;
		$requisicion->save();
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(RequisicionRequest $request)
	{	
		$requisicion = new Requisicion;
		$this->datosRequisicion($requisicion, $request);
		Flash::success('Requisicion creada correctamente');
		return redirect('requisiciones');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$requisicion = Requisicion::findOrFail($id);
		return view('requisiciones.show', compact('requisicion'));
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
		$requisicion = Requisicion::find($id);
		$edit = true;
		return view('requisiciones.edit', compact('requisicion', 'dependencias', 'edit'));
	}

	/**
	 * Duplica una requisición
	 * @return null 
	 */
	public function duplicate($id)
	{
		$mytime = Carbon::now();
		$last_requisicion = Requisicion::where('mes', $mytime->month)->where('anio', $mytime->year)->orderBy('consecutivo', 'desc')->first();
		$nuevaRequisición = Requisicion::find($id)->replicate();
		$nuevaRequisición->mes = $mytime->month;
		$nuevaRequisición->consecutivo = $last_requisicion->consecutivo + 1;
		$nuevaRequisición->anio = $mytime->year;
		$nuevaRequisición->procedimiento_id = null;
		$nuevaRequisición->asignada = 0;
		$nuevaRequisición->save();
		Flash::success('Requisicion duplicada correctamente');
		return redirect('requisiciones');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, RequisicionRequest $request)
	{
		$requisicion = Requisicion::findOrFail($id);
		$this->datosRequisicion($requisicion, $request, true);
		Flash::success('Requisicion editada correctamente');
		return redirect('requisiciones');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$requisicion = Requisicion::findOrFail($id);
		$requisicion->delete();
		Flash::success('Requisicion eliminada correctamente');
		return redirect('requisiciones');
	}

	public function descarga($id)
	{
		$requisicion = Requisicion::findOrFail($id);
		$reporte = new WordGenerator;
		$reporte->createDocument($requisicion);
	}
}
