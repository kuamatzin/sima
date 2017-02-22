<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\ProcedimientoRequest;
use App\Procedimiento;
use App\Proveedor;
use App\Requisicion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProcedimientosAnalistaController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $procedimientos = Auth::user()->procedimientos;
        return view('analistas.index', compact('procedimientos'));
    }

    public function administrar($procedimiento_id)
    {
        $procedimiento = Procedimiento::findOrFail($procedimiento_id);
        if ($procedimiento->analista_id == Auth::user()->id) {
            $proveedores = Proveedor::where('status', 1)->get();
            $proveedor_array = $procedimiento->proveedores->lists('id');
            if (count($proveedor_array) == 0) {
                $proveedor_array = 'create';
            }
            return view('analistas.edit', compact('procedimiento', 'proveedores', 'proveedor_array'));
        }
        return "No tienes asignado este procedimiento";
    }

}
