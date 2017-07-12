<?php namespace App\Http\Controllers;

use App\Dependencia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UsuariosDependenciasRequest;
use App\UnidadAdministrativa;
use App\User;
use Laracasts\Flash\Flash;
use Validator;

class UsuariosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('manager', ['except' => ['procedimientos', 'procedimientos_create', 'procedimientos_store', 'unidad_administrativa_create', 'unidad_administrativa_store', 'unidad_administrativa_edit', 'unidad_administrativa_update', 'procedimientos_edit', 'procedimientos_update']]);
	}

	public function index()
	{
		$usuarios_analistas = User::analistas()->get();
		$usuarios_monitores = User::monitores()->get();
		$usuarios_admin = User::administradores()->get();
		return view('usuarios.index', compact('usuarios_analistas', 'usuarios_admin', 'usuarios_monitores'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{	
		$nullOption = "Dependencia a administrar";
		$dependencias = ['' => "$nullOption"] + Dependencia::pluck('nombre', 'id')->toArray();
		return view('usuarios.create', compact('dependencias'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(UserRequest $request)
	{
		if ($request['privilegios'] == 3) {
			User::create([
				'name'           => $request['name'],
				'email'          => $request['email'],
				'privilegios'    => $request['privilegios'],
				'dependencia_id' => $request['dependencia_id'],
				'password'       => bcrypt($request['password']),
			]);
		}

		User::create([
			'name'           => $request['name'],
			'email'          => $request['email'],
			'privilegios'    => $request['privilegios'],
			'password'       => bcrypt($request['password']),
		]);
		
		Flash::success('Usuario creado correctamente');
		return redirect('usuarios');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$nullOption = "Dependencia a administrar";
		$dependencias = ['' => "$nullOption"] + Dependencia::lists('nombre', 'id');
		$usuario = User::findOrFail($id);
		return view('usuarios.edit', compact('usuario', 'dependencias'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$usuario = User::findOrFail($id);
		$request = $request->all();

		//Aquí no se está actualizando la contraseña
		if($request['password'] == null){
			if ($request['email'] == $usuario->email)
			{
				$rules = array(
					'privilegios'	 => 'required',
					'name'           => 'required|max:255'
				);

				$validator = Validator::make($request, $rules);

				if ($validator->fails())
				{
					return redirect('usuarios/'. $usuario->id .'/edit')->withErrors($validator)->withInput(Request::all());
				}
				else
				{	
					$usuario->privilegios  	 = $request['privilegios'];
					$usuario->dependencia_id = $request['dependencia_id'];
					$usuario->name           = $request['name'];
					$usuario->save();
					Flash::success('Usuario editado correctamente');
					return redirect('usuarios');
				}
			}
			else
			{
				$rules = array(
					'name'           => 'required|max:255',
					'email'          => 'required|email|max:255|unique:users'
				);

				$validator = Validator::make($request, $rules);

				if ($validator->fails())
				{
					return redirect('usuarios/'. $usuario->id .'/edit')->withErrors($validator)->withInput(Request::all());
				}
				else
				{
					$usuario->privilegios    = $request['privilegios'];
					$usuario->dependencia_id = $request['dependencia_id'];
					$usuario->name           = $request['name'];
					$usuario->email 		 = $request['email'];
					$usuario->save();
					Flash::success('Usuario editado correctamente');
					return redirect('usuarios');
				}
			}
		}
		else{
			if ($request['email'] == $usuario->email)
			{
				$rules = array(
					'privilegios'	 => 'required',
					'name'           => 'required|max:255',
					'password'       => 'required|confirmed|min:6'
				);

				$validator = Validator::make($request, $rules);

				if ($validator->fails())
				{
					return redirect('usuarios/'. $usuario->id .'/edit')->withErrors($validator)->withInput(Request::all());
				}
				else
				{	
					$usuario->privilegios    = $request['privilegios'];
					if ($usuario->privilegios == 3 || $usuario->privilegios == 4 || $usuario->privilegios == 5) {
						$usuario->dependencia_id = $request['dependencia_id'];
					}
					$usuario->name           = $request['name'];
					$usuario->password  	 = bcrypt($request['password']);
					$usuario->save();
					Flash::success('Usuario editado correctamente');
					return redirect('usuarios');
				}
			}
			else
			{
				$rules = array(
					'privilegios'	 => 'required',
					'name'           => 'required|max:255',
					'email'          => 'required|email|max:255|unique:users',
					'password'       => 'required|confirmed|min:6'
				);

				$validator = Validator::make($request, $rules);

				if ($validator->fails())
				{
					return redirect('usuarios/'. $usuario->id .'/edit')->withErrors($validator)->withInput(Request::all());
				}
				else
				{
					$usuario->privilegios    = $request['privilegios'];
					$usuario->dependencia_id = $request['dependencia_id'];
					$usuario->name           = $request['name'];
					$usuario->email 		 = $request['email'];
					$usuario->password  	 = bcrypt($request['password']);
					$usuario->save();
					Flash::success('Usuario editado correctamente');
					return redirect('usuarios');
				}
			}
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$usuario = User::findOrFail($id);
		$usuario->delete();
		Flash::success('Usuario eliminado correctamente');
		return redirect('usuarios');
	}


	public function dependencia_create($dependencia_id)
	{
		$dependencia = Dependencia::findOrFail($dependencia_id);

		return view('usuarios.dependencia_create', compact('dependencia'));
	}

	public function dependencia_store(UsuariosDependenciasRequest $request, $dependencia_id)
	{
		$request['dependencia_id'] = $dependencia_id;
		$request['password'] = bcrypt($request->password);
		$usuario = User::create($request->all());

		return redirect("dependencias/$dependencia_id");
	}

	public function dependencia_edit($user_id)
	{
		$user = User::findOrFail($user_id);
		return view('usuarios.dependencia_edit', compact('user'));
	}

	public function dependencia_update(Request $request, $user_id)
	{
		$request = $request->all();
		$user = User::findOrFail($user_id);
		if ($user->email == $request['email']) {
			//NO ESTA ACTUALIZANDO EMAIL
			$rules = [
				'privilegios'	 => 'required',
				'name'           => 'required|max:255',
			];
		}
		else {
			//ACTUALIZA EMAIL
			$rules = [
				'privilegios'	 => 'required',
				'name'           => 'required|max:255',
				'email'          => 'required|email|max:255|unique:users',
			];
		}
		
		$validator = Validator::make($request, $rules);

		if ($validator->fails()) {
			dd("MAL");
		}
		else{
			$user->update($request);
			return redirect("dependencias/$user->dependencia_id");
		}
	}

	public function unidad_administrativa_create($unidad_administrativa_id)
	{
		$unidad_administrativa = UnidadAdministrativa::findOrFail($unidad_administrativa_id);

		return view('usuarios.unidad_administrativa_create', compact('unidad_administrativa'));
	}

	public function unidad_administrativa_store(UsuariosDependenciasRequest $request, $unidad_administrativa_id)
	{
		$unidad_administrativa = UnidadAdministrativa::findOrFail($unidad_administrativa_id);
		$request['unidad_administrativa_id'] = $unidad_administrativa_id;
		$request['dependencia_id'] = $unidad_administrativa->dependencia->id;
		$request['password'] = bcrypt($request->password);
		$usuario = User::create($request->all());

		return redirect("unidades_administrativas/$unidad_administrativa_id");
	}

	public function unidad_administrativa_edit($user_id)
	{
		$user = User::findOrFail($user_id);
		return view('usuarios.unidad_administrativa_edit', compact('user'));
	}

	public function unidad_administrativa_update(Request $request, $user_id)
	{
		$request = $request->all();
		$user = User::findOrFail($user_id);
		if ($user->email == $request['email']) {
			//NO ESTA ACTUALIZANDO EMAIL
			$rules = [
				'privilegios'	 => 'required',
				'name'           => 'required|max:255',
			];
		}
		else {
			//ACTUALIZA EMAIL
			$rules = [
				'privilegios'	 => 'required',
				'name'           => 'required|max:255',
				'email'          => 'required|email|max:255|unique:users',
			];
		}
		if ($request['password'] != '') {
			$rules['password'] = 'required|confirmed|min:6';
		}
		
		$validator = Validator::make($request, $rules);

		if ($validator->fails()) {
			dd("MAL");
		}
		else {
			if ($request['password'] == '') {
				unset($request['password']);
			}
			else {
				$request['password'] = bcrypt($request['password']);
			}
			$user->update($request);
			return redirect("unidades_administrativas/$user->unidad_administrativa_id");
		}
	}

	public function procedimientos()
	{
		$usuarios = User::analistasProcedimiento()->get();
		return view('usuarios.procedimientos_index', compact('usuarios'));
	}

	public function procedimientos_create()
	{
		return view('usuarios.procedimientos_create');
	}

	public function procedimientos_store(UsuariosDependenciasRequest $request)
	{
		$request['password'] = bcrypt($request->password);
		$usuario = User::create($request->all());

		return redirect('usuarios_procedimientos');
	}

	public function procedimientos_edit($user_id)
	{
		$user = User::findOrFail($user_id);
		return view('usuarios.procedimientos_edit', compact('user'));
	}

	public function procedimientos_update(Request $request, $user_id)
	{
		$request = $request->all();
		$user = User::findOrFail($user_id);
		if ($user->email == $request['email']) {
			//NO ESTA ACTUALIZANDO EMAIL
			$rules = [
				'privilegios'	 => 'required',
				'name'           => 'required|max:255',
			];
		}
		else {
			//ACTUALIZA EMAIL
			$rules = [
				'privilegios'	 => 'required',
				'name'           => 'required|max:255',
				'email'          => 'required|email|max:255|unique:users',
			];
		}
		
		$validator = Validator::make($request, $rules);

		if ($request['password'] == '') {
			unset($request['password']);
		}
		else {
			$request['password'] = bcrypt($request['password']);
		}

		if ($validator->fails()) {
			dd("MAL");
		}
		else{
			$user->update($request);
			return redirect('usuarios_procedimientos');
		}
	}
}
