<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Invitacion;
use App\Oferta;
use App\Partida;
use App\Procedimiento;
use App\Proveedor;
use App\Requisicion;
use App\Services\ExcelGenerator;
use App\Services\WordGenerator;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;


class OfertasController extends Controller {

	public function verCotizacion($invitacion_id){
		$invitacion = Invitacion::findOrFail($invitacion_id);
		return view('ofertas.invitacion_cotizacion', compact('invitacion'));
	}

	public function invitacion($procedimiento_id, Request $request)
	{
		if ($request->ajax()) {
			if ($request->actividad == '') {
				$request->actividad = 'UNRECOGNIZED';
			}
			if ($request->nombre == '') {
				$request->nombre = 'UNRECOGNIZED';
			}
			if ($request->rfc == '') {
				$request->rfc = 'UNRECOGNIZED';
			}
			$proveedores = Proveedor::where('nombre', 'LIKE', '%'.$request->nombre.'%')->orWhere('actividad', 'LIKE', '%'.$request->actividad.'%')->orWhere('rfc', 'LIKE', '%'.$request->rfc.'%')->get();

			return $proveedores;
		}
		$procedimiento = Procedimiento::findOrFail($procedimiento_id);
		return view('ofertas.invitacion', compact('procedimiento'));
	}

	public function proveedoresInvitados($procedimiento_id, Request $request){
		if ($request->ajax()) {
			$invitaciones = Invitacion::where('procedimiento_id', $procedimiento_id)->get();
			return $invitaciones->toJson();
		}
		$invitaciones = Invitacion::where('procedimiento_id', $procedimiento_id)->get();
	}

	public function descargaListaInvitaciones($procedimiento_id){
		$invitaciones = Invitacion::where('procedimiento_id', $procedimiento_id)->get();
		$documento = new WordGenerator;
		$documento->listaInvitaciones($invitaciones);
	}

	private function createInvitacion($proveedor_id, $procedimiento_id, $tipoInvitacion)
	{
		$invitacion_a = Invitacion::where('proveedor_id', $proveedor_id)->where('procedimiento_id', $procedimiento_id)->first();
		if ($invitacion_a == null) {
			$invitacion = new Invitacion;
			$invitacion->proveedor_id = $proveedor_id;
			$invitacion->procedimiento_id = $procedimiento_id;
			if ($tipoInvitacion == 1) {
				$invitacion->url = $this->generateRandomString(50);
			}
			$invitacion->enviado = false;
			$invitacion->save();
			return $invitacion;
		}
		else {
			$invitacion_a->url = $this->generateRandomString(50);
			$invitacion_a->save();
		}
		return $invitacion_a;
	}

	public function emailInvitacion($proveedor, $invitacion)
	{
		$requisicion = $invitacion->procedimiento->requisiciones[0];
		$data = [
			'nombre'        => $proveedor->nombre,
			'representante' => $proveedor->representante,
			'email'         => $proveedor->email,
			'url'			=> $invitacion->url,
			'descripcion'   => $requisicion->descripcion,
			'codificacion'  => $requisicion->mes . '_' . $requisicion->consecutivo . '_' .  $requisicion->anio
        ];

        $email = $proveedor->email;

        Mail::send('emails.invitacionCotizar', $data, function ($message) use ($email) {
            $message->to($email)->subject('Nuevo Proveedor en SIAA 2.0');
        });

        if(count(Mail::failures()) > 0){
		    $invitacion->servidor_envia_mail = false;
		    $invitacion->save();
		}
		else {
			$invitacion->servidor_envia_mail = true;
		    $invitacion->save();
		}
	}

	function generateRandomString($length = 10) {
	    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}

	public function sendInvitacion($procedimiento_id, Request $request)
	{
		if ($request->ajax()) {
			foreach ($request->proveedores as $key => $proveedor) {
				$proveedor = Proveedor::findOrFail($proveedor);
				$invitacion = $this->createInvitacion($proveedor->id, $procedimiento_id, $request->tipoInvitacion);
				if ($request->tipoInvitacion == 1) {
					$this->emailInvitacion($proveedor, $invitacion);
				}	
			}
		}
	}

	public function generateInvitacion($procedimiento_id){
		$procedimiento = Procedimiento::findOrFail($procedimiento_id);
		$generateDocument = new WordGenerator;
		$generateDocument->createInvitacion($procedimiento);
	}
	
	public function dictamen_tecnico($procedimiento_id)
	{
		$procedimiento = Procedimiento::findOrFail($procedimiento_id);
		$proveedores = $procedimiento->proveedores;
		foreach ($procedimiento->requisiciones[0]->partidas as $key => $partida) {
			foreach ($proveedores as $key => $proveedor) {
				$status = DB::select("SELECT status FROM ofertas 
					WHERE proveedor_id = $proveedor->id AND partida_id = $partida->id");
				if (count($status) > 0) {
					$partida_proveedor[$partida->id . "_" . $proveedor->id] = $status[0]->status;
				}
				else {
					$partida_proveedor[$partida->id . "_" . $proveedor->id] = "";
				}
			}
		}

		return view('ofertas.dictamen_tecnico', compact('procedimiento', 'proveedores', 'partida_proveedor'));
	}

	public function dictamen_tecnico_store(Request $request)
	{
		if ($request->motivo_partida_proveedor != null) {
			foreach ($request->motivo_partida_proveedor as $key => $motivo) {
				if ($motivo != "") {
					$info = explode("_", $key);
					$oferta = DB::select("SELECT * FROM ofertas 
							WHERE proveedor_id = $info[1] AND partida_id = $info[0]");
					$oferta = Oferta::findOrFail($oferta[0]->id);
					$oferta->motivo = $motivo;
					$oferta->save();
				}	
			}
		}
		
		foreach ($request->partida_proveedor as $key => $status) {
			$info = explode("_", $key);
			$oferta = DB::select("SELECT * FROM ofertas 
					WHERE proveedor_id = $info[1] AND partida_id = $info[0]");
			if (count($oferta) > 0) {
				//Update
				$oferta = Oferta::findOrFail($oferta[0]->id);
				$oferta->status = $status;
				$oferta->save();
			}
			else {
				//Nueva Oferta
				$oferta = new Oferta;
				$partida = Partida::findOrFail($info[0]);
				$oferta->procedimiento_id = $request->procedimiento;
				$oferta->partida_id = $info[0];
				$oferta->proveedor_id = $info[1];
				$oferta->status = $status;
				$oferta->marca = $partida->marca;
				$oferta->save();	
			}
		}
		$procedimiento = Procedimiento::findOrFail($request->procedimiento);
		$procedimiento->status = 3;
		$procedimiento->save();
		return redirect('procedimientos');
	}

	public function createCargaEconomica($procedimiento_id)
	{
		$procedimiento = Procedimiento::findOrFail($procedimiento_id);
		$proveedores = $procedimiento->proveedores->pluck('nombre', 'id')->toArray();
		$proveedores_ids = $procedimiento->proveedores;
		//dd($procedimiento);
		if (sizeof($proveedores_ids) == 0) {
			return view('ofertas.vacio');
		}
		$ofertas = false;
		if (Input::get('proveedor_id')) {
			$ofertas = $ofertas = Oferta::where('procedimiento_id', $procedimiento->id)->where('status', 1)->where('proveedor_id', Input::get('proveedor_id'))->paginate(15);
		}
		return view('ofertas.carga_economica', compact('procedimiento', 'proveedores', 'ofertas', 'proveedores_ids'));
	}

	public function storeCargaEconomica(Request $request, $procedimiento_id)
	{
		$procedimiento = Procedimiento::findOrFail($procedimiento_id);
		$partidas = $procedimiento->requisiciones[0]->partidas;
		$ofertas = Oferta::where('procedimiento_id', $procedimiento->id)->where('status', 1)->get();
		foreach ($ofertas as $key => $oferta) {	
			if ($request->{$oferta->id}) {
				$oferta->precio_unitario = $request->{$oferta->id}['precio_unitario'];
				$oferta->importe_sin_iva = $request->{$oferta->id}['importe_sin_iva'];
				$oferta->iva = $request->{$oferta->id}['iva'];
				$oferta->marca = $oferta->partida->cantidad_minima;
				$oferta->marca = $request->{$oferta->id}['marca'];
				$oferta->importe_con_iva = $request->{$oferta->id}['importe_con_iva'];
				$oferta->ganador = 0;
				if ($request->{$oferta->id}['monto_total'] == 0) {
					$oferta->monto_total = 0;
					//$oferta->status = 5; //5 -> NO COTIZA
				}
				else {
					$oferta->monto_total = $request->{$oferta->id}['monto_total'];
					$oferta->status = 1;
				}
				$oferta->save();
			}		
		}
		return redirect('carga_economica/' . $procedimiento_id);
	}

	/**
	 * Funcion que determina las ofertas ganadoras de una partida en un procedimineto
	 * @param  Procedimiento $procedimiento El procedimiento en el cual serán buscadas las ofertas ganadoras
	 * @param  Partida $partida       La partida en partícular donde sera buscada la oferta ganadora
	 * @return array                Retorna la partida o las ofertas ganadoras de una partida en un procedimiento
	 */
	public function ganador($ofertas, $partida)
	{
		$costo_minimo = $ofertas->where('status', 1)->where('partida_id', $partida)->min('monto_total');

		$ofertaGanadora = $ofertas->where('status', 1)->where('partida_id', $partida)->where('monto_total', $costo_minimo)->pluck('id')->toArray();
		//$ofertaGanadora = Oferta::select('id', 'status', 'monto_total')->where('procedimiento_id', $procedimiento->id)->where('status', 1)->where('partida_id', $partida)->where('monto_total', '=', 165.5088)->get();
		if (sizeof($ofertaGanadora) != 0) {
			return $ofertaGanadora;
		}
	}

	public function analisis_comparativo($id, $descarga)
	{
		$proveedores = array();
		$procedimiento = Procedimiento::findOrFail($id);
		$partidas = $procedimiento->requisiciones[0]->partidas;
		$proveedores_procedimiento = $procedimiento->proveedores;
		$proveedores_ids = $proveedores_procedimiento->pluck('id')->toArray();
		/*
		$ofertas_cuadroComparativo = Oferta::where('procedimiento_id', $procedimiento->id)->where('status', '!=', 6)->where(function($query) use ($proveedores_ids){
			foreach ($proveedores_ids as $key => $proveedor_id) {
				$query->orWhere('proveedor_id', $proveedor_id);
			}
		})->orderBy('partida_id', 'asc')->get();
		*/
		$ofertas_cuadroComparativo = Oferta::whereIn('proveedor_id', $proveedores_ids)->where('procedimiento_id', $id)->where('status', '!=', 6)->orderBy('partida_id', 'asc')->get();
		//$ofertas_cuadroComparativo = Oferta::where('procedimiento_id', $procedimiento->id)->where('status', '!=', 6)->orderBy('partida_id', 'asc')->get();

		//Aqui se ordenan los nombres de proveedores
		$size_proveedores = sizeof($proveedores_procedimiento);
		for ($i=0; $i < $size_proveedores; $i++) {
			array_push($proveedores, Proveedor::select('id', 'nombre')->where('id', $ofertas_cuadroComparativo[$i]->proveedor_id)->get());
		}
		$ofertas_cuadroComparativo_final = [];
		foreach ($partidas as $key => $partida) {
			for ($i=0; $i < sizeof($proveedores); $i++) {
				array_push($ofertas_cuadroComparativo_final, $ofertas_cuadroComparativo->where('proveedor_id', $proveedores[$i][0]->id)->where('partida_id', $partida->id)->first());
			}
		}
		
		$ofertas_cuadroComparativo = Collection::make($ofertas_cuadroComparativo_final);

		//Aqui se ordenan las ofertas de cuadro comparativo
		if ($descarga == 0) {
			return view('ofertas.analisis_comparativo', compact('procedimiento', 'partidas', 'ofertas_cuadroComparativo', 'proveedores', 'size_proveedores'));
		}
		else {
			if ($id == 517 || $id == 580) {
				return response()->download("cuadros_comparativos/$id.xlsx");
			}
			else {
				$excel = new ExcelGenerator;
				$excel->descargaCuadroComparativo($procedimiento->id, $procedimiento->requisiciones[0]->descripcion, $proveedores, $partidas, $ofertas_cuadroComparativo, $size_proveedores);
			}
		}
	}

	public function analisis_comparativo_mantenimiento(Request $request, $procedimiento_id)
	{
		$procedimineto = Procedimiento::findOrFail($procedimiento_id);
		$ofertas = Oferta::where('procedimiento_id', $procedimiento_id)->where('status', '!=', 6)->orderBy('partida_id', 'asc')->get();
		foreach ($ofertas as $key => $oferta) {
			if (in_array($oferta->id, $request->ganadores)) {
			    $oferta->ganador = 1;
			}
			else {
				$oferta->ganador = 0;
			}
			$oferta->save();
		}
		return Redirect::back()->withMessage('Mantenimiento Guardado');
	}

	public function pedido($procedimiento_id)
	{
		$procedimiento = Procedimiento::findOrFail($procedimiento_id);
		$ofertas = $procedimiento->ofertasGanadoras();
		return view('pedidos.show', compact('procedimiento', 'ofertas'));
	}

	public function pedido_reporte($procedimiento_id, $proveedor_id, $numero_pedido)
	{
		$pedido = new WordGenerator;
		$procedimiento = Procedimiento::findOrFail($procedimiento_id);
		$procedimiento->status = 6;
		$procedimiento->save();
		$partidas = $procedimiento->requisiciones[0]->partidas;
		$ofertas_ganadoras_proveedor = $procedimiento->ofertas->where('proveedor_id', (int)$proveedor_id)->where('ganador', 1);
		foreach ($partidas as $key => $partida) {
			foreach ($ofertas_ganadoras_proveedor as $key2 => $oferta) {
				if ($oferta->partida_id == $partida->id) {
					$oferta['numero'] = $key + 1;
				}
			}
		}
		$pedido->reportePedido($procedimiento, $ofertas_ganadoras_proveedor, $numero_pedido);
	}

	public function crear_dictamen_tecnico($procedimiento_id)
	{
		$procedimiento = Procedimiento::findOrFail($procedimiento_id);
		$dictamen_tecnico = new WordGenerator;
		$dictamen_tecnico->dictamen_tecnico($procedimiento);
	}

	public function finalizarCargaEconomica($procedimiento_id)
	{
		$procedimiento = Procedimiento::findOrFail($procedimiento_id);
		$partidas = $procedimiento->requisiciones[0]->partidas;
		//Determinar ofertas ganadoras
		$proveedores_ids = $procedimiento->proveedores->pluck('id')->toArray();

		$ofertas_cuadroComparativo = Oferta::where('procedimiento_id', $procedimiento->id)->where('status', '!=', 6)->where(function($query) use ($proveedores_ids){
			foreach ($proveedores_ids as $key => $proveedor_id) {
				$query->orWhere('proveedor_id', $proveedor_id);
			}
		})->orderBy('partida_id', 'asc')->get();

		foreach ($ofertas_cuadroComparativo as $key => $ofertas) {
			$ofertas->ganador = 0;
			$ofertas->save();
		}

		foreach ($partidas as $key => $partida) {
			//Falta determinar si hay más de dos ganadores
			$partidasGanadoras = $this->ganador($ofertas_cuadroComparativo, $partida->id);
			if ($partidasGanadoras != null) {
				foreach ($partidasGanadoras as $key => $partidaGanadora) {
					foreach ($ofertas_cuadroComparativo as $keyOfertas => $oferta) {
						if ($oferta->id == $partidaGanadora) {
							$oferta->ganador = 1;
							$oferta->save();
		 				}
					}	
				}
			}
		}
		return redirect('procedimientos');
	}

	public function cerrarInvitacion($procedimiento_id)
	{
		$procedimiento = Procedimiento::findOrFail($procedimiento_id);
		$procedimiento->status_invitacion = true;
		$procedimiento->save();

		return redirect()->back();

	}

	public function abrirInvitacion($procedimiento_id)
	{
		$procedimiento = Procedimiento::findOrFail($procedimiento_id);
		$procedimiento->status_invitacion = false;
		$procedimiento->save();

		return redirect()->back();

	}
}
