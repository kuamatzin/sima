<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\ProveedorRequest;
use App\Invitacion;
use App\Oferta;
use App\Partida;
use App\Procedimiento;
use App\Proveedor;
use App\Services\WordGenerator;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Laracasts\Flash\Flash;
use Validator;

class ProveedoresController extends Controller {

	public function __construct()
	{
		$this->middleware('auth', ['except' => ['cotizacion', 'cotizacionAction']]);
		//$this->middleware('manager');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$proveedores = Proveedor::all();
		return view('proveedores.index', compact('proveedores'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('proveedores.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ProveedorRequest $request)
	{	
		$new_proveedor = Proveedor::create($request->all());
		/*
		$usuario_proveedor = new User;
		$usuario_proveedor->name        = $request->nombre;
		$usuario_proveedor->email       = $request->email;
		$usuario_proveedor->password    = bcrypt($request->password);
		$usuario_proveedor->privilegios = 3;
		$usuario_proveedor->save();

		$new_proveedor->user_id = $usuario_proveedor->id;
		$new_proveedor->save();


		$this->welcomeProveedor($new_proveedor, $request->password);
		*/
		Flash::success('Proveedor creado');
		return redirect('proveedores');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$proveedor = Proveedor::find($id);
		return view('proveedores.show', compact('proveedor'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$proveedor = Proveedor::find($id);
		return view('proveedores.edit', compact('proveedor'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, ProveedorRequest $request)
	{
		$proveedor = Proveedor::findOrFail($id);
		$proveedor->update($request->all());
		Flash::success('Proveedor actualizado correctamente');
		return redirect('proveedores');
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

	public function welcomeProveedor($proveedor, $pass)
	{
		$data = [
			'nombre'        => $proveedor->nombre,
			'representante' => $proveedor->representante,
			'email'         => $proveedor->email,
			'password'      => $pass,
        ];

        $email = $proveedor->email;

        Mail::send('emails.newProveedor', $data, function ($message) use ($email) {
            $message->to($email)->subject('Invitación para cotización');
        });
	}


	public function cotizacion(Request $request, $url)
	{
		$invitacion = Invitacion::where('url', $url)->first();

		//Autoguardado en cotizacion en caso de que existan mas de 15 partidas
		if ($request->input('page')) {
			if ($invitacion) {
				if ($invitacion->enviado == false) {
					$numeroPartidas = sizeof($request->all()) - 1;
					for ($i=0; $i < $numeroPartidas; $i++) {
						$partida = $request->input($i . "partida");
						$oferta = Oferta::where('procedimiento_id', $invitacion->procedimiento->id)->where('proveedor_id', $invitacion->proveedor->id)->where('partida_id', $partida[0])->first();
						if ($oferta != null) {
							$oferta->status = 1;
							$oferta->cantidad = $partida[1] == null ? '' : $partida[1];
							$oferta->precio_unitario = $partida[2] == null ? '' : $partida[2];
							$oferta->importe_sin_iva = $partida[3] == null ? '' : $partida[3];
							$oferta->iva = $partida[4] == null ? '' : $partida[4];
							$oferta->importe_con_iva = $partida[5] == null ? '' : $partida[5];
							$oferta->monto_total = $partida[6] == null ? '' : $partida[6];
							$oferta->marca = $partida[7] == null ? '' : $partida[7];
							$oferta->save();
						}
						else {
							$oferta = new Oferta();
							$oferta->status = 1;
							$oferta->cantidad = $partida[1] == null ? '' : $partida[1];
							$oferta->precio_unitario = $partida[2] == null ? '' : $partida[2];
							$oferta->importe_sin_iva = $partida[3] == null ? '' : $partida[3];
							$oferta->iva = $partida[4] == null ? '' : $partida[4];
							$oferta->importe_con_iva = $partida[5] == null ? '' : $partida[5];
							$oferta->monto_total = $partida[6] == null ? '' : $partida[6];
							$oferta->partida_id = $partida[0];;
							$oferta->procedimiento_id = $invitacion->procedimiento->id;
							$oferta->proveedor_id = $invitacion->proveedor->id;
							$oferta->marca = $partida[7] == null ? '' : $partida[7];
							$oferta->save();
						}
					}
				}
			}
		}
		$ofertas_proveedor = Oferta::where('procedimiento_id', $invitacion->procedimiento_id)->where('proveedor_id', $invitacion->proveedor_id)->get();

		$partidas = Partida::where('requisicion_id', $invitacion->procedimiento->requisiciones[0]->id)->paginate(15);

		if (($request->input('page'))) {
			$pagina = ($request->input('page') - 1) * 15;
		}
		else {
			$pagina = 1;
		}

		if ($invitacion) {
			//Procedimiento->status_invitacion == 0 -> Invitacion abierta
			if ($invitacion->enviado == false && $invitacion->procedimiento->status_invitacion != false) {
				return view('invitaciones.cerrada');
			}

			if ($invitacion->enviado == false) {
				return view('invitaciones.create', compact('invitacion', 'partidas', 'ofertas_proveedor', 'pagina'));
			}
			else {
				return view('invitaciones.ya_enviada');
			}
		}
		else {
			return view('invitaciones.error');
		}
	}

	public function cotizacionAction(Request $request, $url)
	{
		$invitacion = Invitacion::where('url', $url)->first();
		$numeroPartidas = (sizeof($request->all()) - 2) / 8;
		$partidas_invitacion = $invitacion->procedimiento->requisiciones[0]->partidas;
		$llave = 1;
		for ($i=0; $i < $numeroPartidas; $i++) {
			$allKeys = array_keys($request->all());
			$key = $allKeys[$llave];
			$datos_partida = explode("_", $key, 2);
			$numero_partida = (int)$datos_partida[0];
			if (is_int($numero_partida) && $numero_partida != 0) {
				$oferta = Oferta::where('procedimiento_id', $invitacion->procedimiento->id)->where('proveedor_id', $invitacion->proveedor->id)->where('partida_id', $numero_partida)->first();
				if ($oferta != null) {
					$oferta->status = 1;
					$oferta->cantidad = $request->{$numero_partida . '_cantidad'};
					$oferta->precio_unitario = $request->{$numero_partida . '_precio_unitario'};
					$oferta->importe_sin_iva = $request->{$numero_partida . '_importe_sin_iva'};
					$oferta->iva = $request->{$numero_partida . '_iva'};
					$oferta->importe_con_iva = $request->{$numero_partida . '_importe_con_iva'};
					$oferta->monto_total = $request->{$numero_partida . '_monto_total'};
					$oferta->marca = $request->{$numero_partida . '_marca'};
					$oferta->clave = $request->{$numero_partida . '_clave'};
					
					$oferta->save();
				}
				else {
					$oferta = new Oferta();
					$oferta->status = 1;
					$oferta->cantidad = $request->{$numero_partida . '_cantidad'};
					$oferta->precio_unitario = $request->{$numero_partida . '_precio_unitario'};
					$oferta->importe_sin_iva = $request->{$numero_partida . '_importe_sin_iva'};
					$oferta->iva = $request->{$numero_partida . '_iva'};
					$oferta->importe_con_iva = $request->{$numero_partida . '_importe_con_iva'};
					$oferta->monto_total = $request->{$numero_partida . '_monto_total'};
					$oferta->partida_id = $numero_partida;
					$oferta->procedimiento_id = $invitacion->procedimiento->id;
					$oferta->proveedor_id = $invitacion->proveedor->id;
					$oferta->marca = $request->{$numero_partida . '_marca'};
					$oferta->clave = $request->{$numero_partida . '_clave'};
					$oferta->save();
				}
				$llave = $llave + 8;
			}
		}
		
		$numero_partidas_invitacion = $invitacion->procedimiento->requisiciones[0]->partidas->count();
		//Checar si hay ceros en las invitaciones
		$ofertas = Oferta::where('procedimiento_id', $invitacion->procedimiento->id)->where('proveedor_id', $invitacion->proveedor->id)->get();
		
		$partidas_enviadas_request = (sizeof($request->all()) - 2) / 8;
		//Aqui se aplica metodo que ya tengo
		if ($partidas_enviadas_request < 15) {
			if(Input::get('documento') != "") {
				//Se crea el documento de cotización para el proveedor
	            			$this->cotizacionFormato($request, $invitacion->id);
	        		}
	        		elseif(Input::get('guardar') != "") {
	        			//Se almacena la cotizacion
	           			$validator = $this->storeCotizacion($request, $invitacion->url);
	            			if ($validator->fails()) {
	            				return redirect('cotizacion/'. $url)->withErrors($validator)->withInput($request->all());
	            			}		
	            			else {
	            				return view('invitaciones.exito');
	            			}
	        		}
		}
		else {
			//Ha llenado todas las partidas
			if ($numero_partidas_invitacion == $ofertas->count()) {
				if(Input::get('documento') != "") {
					//Se crea el documento de cotización para el proveedor
		            			$this->cotizacionFormato($ofertas, $invitacion->id, 1);
		        		}
		        		elseif(Input::get('guardar') != "") {
		        			//Se almacena la cotizacion
		            			$validator = $this->storeCotizacion($request, $invitacion->url, $ofertas, 1);
		            			if ($validator->fails()) {
		            				return redirect('cotizacion/'. $url)->withErrors($validator)->withInput($request->all());
		            			}
		            			else {
		            				return view('invitaciones.exito');
		            			}
		        		}
			}
			//No se han llenado todas las ofertas
			else {
				if(Input::get('documento') != "") {
					Session::flash('message', "No se pudo crear el documento, hay ofertas en blanco.  Debe capturar todas las ofertas");
					return Redirect::back();
		       		 }
		       	 	else {
					Session::flash('message', "No se pudo guardar su cotización, hay ofertas en blanco.  Debe capturar todas las ofertas");
					return Redirect::back();
		        		}		
			}
		}
	}

	public function storeCotizacion(Request $request, $url, $ofertas = null, $tipoCotizacion = 0)
	{
		$rules = [
			'formato'	 => 'required'
		];
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			return $validator;
		}
		else{
			$invitacion = Invitacion::where('url', $url)->first();
			if ($invitacion) {
				if ($invitacion->enviado == false) {
					$file = $request->file("formato");
                				$name = time() . '-' . $file->getClientOriginalName();
                				$file->move(public_path() . '/cotizacionesEnviadas/', $name);

					$invitacion->enviado = true;
					$invitacion->cotizacion_proveedor = $name;
					$invitacion->save();
					return $validator;
				}
				else {
					return view('invitaciones.ya_enviada');
				}
			}
			else {
				return view('invitaciones.error');
			}
		}
	}

	public function cotizacionFormato($ofertas, $invitacion_id, $tipoCotizacion = 0)
	{
		$invitacion = Invitacion::findOrFail($invitacion_id);
		$reporte = new WordGenerator;
		$reporte->createCotizacion($ofertas, $invitacion, $tipoCotizacion);
	}

	public function invitacionBlanco($procedimiento_id)
	{	
		$procedimiento = Procedimiento::findOrFail($procedimiento_id);
		$reporte = new WordGenerator;
		$reporte->createInvitacion($procedimiento);
	}

	public function reabrirCotizacion($invitacion_id)
	{
		$invitacion = Invitacion::findOrFail($invitacion_id);
		$invitacion->enviado = false;
		$invitacion->save();

		return redirect()->back();
	}

}
