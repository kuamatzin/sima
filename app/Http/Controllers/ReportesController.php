<?php namespace App\Http\Controllers;

use App\Dependencia;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Procedimiento;
use App\Proveedor;
use App\Requisicion;
use App\Services\ExcelGenerator;
use App\User;
use Illuminate\Http\Request;

class ReportesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $proveedores = ['' => "Indiferente"] + Proveedor::orderBy('nombre', 'asc')->pluck('nombre', 'id')->toArray();
        $dependencias = ['' => "Indiferente"] + Dependencia::pluck('nombre', 'id')->toArray();
        $usuarios = ['' => "Indiferente"] + User::where('privilegios', 5)->pluck('name', 'id')->toArray();
        $procedimientos = [];
        return view('reportes.reportes', compact('dependencias', 'usuarios', 'procedimientos', 'proveedores'));
    }

    public function busqueda(Request $request)
    {
        $procedimientos = Requisicion::where('asignada', 1);

        if ((int)$request->usuario_id != 0) {
            if ($request->status != '') {
                $proc = Procedimiento::where('analista_id', (int)$request->usuario_id)->where('status', (int)$request->status)->pluck('id');    
            }
            else {
                $proc = Procedimiento::where('analista_id', (int)$request->usuario_id)->pluck('id');
            }
            $procedimientos->whereIn('procedimiento_id', $proc);
        }
        else {
            if ($request->status != '') {
                $proc = Procedimiento::where('status', (int)$request->status)->pluck('id');
                $procedimientos->whereIn('procedimiento_id', $proc);
            }
        }
        
        if ($request->tipo_procedimiento != 0) {
            $procedimientos->where('procedimiento_adjudicacion', $request->tipo_procedimiento);
        }
        if ($request->dependencia_id != 0) {
            $procedimientos->where('dependencia_id', $request->dependencia_id);
        }

        $procedimientos->where('anio', $request->ejercicio_fiscal);
        $procedimientos = $procedimientos->get();
        if ($request->proveedor != '') {
            foreach ($procedimientos as $key => $procedimiento) {
                $proveedoresAdjudicados = $procedimiento->procedimiento->proveedoresAdjudicados()->pluck('id')->toArray();
                //Verifica si el proveedor esta dentro de los ganadores
                if (!in_array($request->proveedor, $proveedoresAdjudicados)) {
                    $procedimientos = $procedimientos->except($procedimiento->id);
                }
            }
        }
        return $procedimientos;
    }

    public function busqueda_por_procedimiento(Request $request)
    {
        $datos = explode("_", $request->codificacion);
        $datos2 = explode("-", $datos[1]);
        $mes = $datos[0];
        $consecutivo = $datos2[0];
        $anio = $datos2[1];

        return Requisicion::where('anio', $anio)->where('consecutivo', $consecutivo)->where('mes', $mes)->get();
    }

    public function descargar(Request $request)
    {
        $proveedor = $request->proveedor;
        $procedimientos = $this->busqueda($request);
        $excel = new ExcelGenerator;
        $excel->descargarReporte($procedimientos, $proveedor);
    }

    public function  requisiciones($anio)
    {
        $requisiciones = Requisicion::where('anio', $anio)->get();
        $excel = new ExcelGenerator;
        $excel->descargarRequisiciones($requisiciones);
    }
}
