<?php namespace App\Services;

use App\Proveedor;
use App\Requisicion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;
use PHPExcel_Worksheet_PageSetup;
/**
* Clase que se encarga de todo Excel
*/
class ExcelGenerator
{
    private function checkIfIsEmail($string){
        if (substr_count($string, '@') == 0) {
            return false;
        }
        else {
            return true;
        }
    }

    private function createDate($string){
        if (strpos($string, '/') !== false) {
            $string = str_replace("RENOVO", "", $string);
            $string = str_replace("ALTA", "", $string);
            $string = str_replace(" ", "", $string);
            $inicio = mb_strpos($string, '/', 0) - 2;
            $date = Carbon::createFromFormat('d/m/Y', substr ($string, $inicio, strlen($string)));
            return $date;
        }
        return $string;
    }

    public function padronProveedores(){
        Excel::load('padron2.xlsx', function($reader) {
            $paginas_web = array();
            $emailsss = array();
            $sheet = $reader->get();
            $hoja = $sheet[0];
            foreach ($hoja as $key => $row) {
                $proveedor = new Proveedor;
                $proveedor->nombre        = $row->proveedor;
                $proveedor->folio         = $row->folio;
                $proveedor->actividad     = $row->actividad;
                if ($row->rfc == null) {
                    $row->rfc = "";
                }
                $proveedor->rfc           = $row->rfc;
                $proveedor->representante = $row->contacto;
                $proveedor->direccion     = $row->direccion;
                $proveedor->estado        = $row->estado;
                $proveedor->telefono      = $row->telefono;
                $proveedor->clabe         = $row->clabe_interbancaria;
                if ($row->numero_de_sima == null) {
                    $row->numero_de_sima = "";
                }
                if (strpos($row->fecha_de_renovacion_o_alta, 'RENOVO') !== false) {
                    $proveedor->fecha_renovacion = $this->createDate($row->fecha_de_renovacion_o_alta);
                    $proveedor->fecha_recibido_renovacion = $this->createDate($row->fecha_de_recibido_renovacion_o_alta);
                }
                if (strpos($row->fecha_de_renovacion_o_alta, 'ALTA') !== false) {
                    $proveedor->fecha_alta = $this->createDate($row->fecha_de_renovacion_o_alta);
                    $proveedor->fecha_recibido_alta = $this->createDate($row->fecha_de_recibido_renovacion_o_alta);
                }
                
                $proveedor->observaciones = $row->numero_de_sima;
                if (strpos($row->e_mail, ',') !== false) {
                    $emails = explode(',', $row->e_mail);
                    $emails = array_filter(array_map('trim', $emails));
                    $control = 0;
                    foreach ($emails as $key3 => $email) {
                        if($this->checkIfIsEmail($email)){
                            if ($control == 0) {
                                $proveedor->email = $email;
                                $control = $control + 1;
                            }
                            elseif ($control == 1) {
                                $proveedor->email2 = $email;
                                $control = $control + 1;
                            }
                            elseif ($control == 2) {
                                $proveedor->email3 = $email;
                                $control = $control + 1;
                            }
                            else {
                                $proveedor->email4 = $email;
                                $control = $control + 1;
                            }
                        }
                        else {
                            $pagina_web = $email;
                            $proveedor->pagina_web = $pagina_web;
                        }
                    }
                }
                elseif (strpos($row->e_mail, ' ') !== false) {
                    $emails = explode(' ', $row->e_mail);
                    $emails = array_filter(array_map('trim', $emails));
                    $control = 0;
                    foreach ($emails as $key2 => $email) {
                        if($this->checkIfIsEmail($email)){
                            if ($control == 0) {
                                $proveedor->email = $email;
                                $control = $control + 1;
                            }
                            elseif ($control == 1) {
                                $proveedor->email2 = $email;
                                $control = $control + 1;
                            }
                            elseif ($control == 2) {
                                $proveedor->email3 = $email;
                                $control = $control + 1;
                            }
                            else {
                                $proveedor->email4 = $email;
                                $control = $control + 1;
                            }
                        }
                        else {
                            $pagina_web = $email;
                            $proveedor->pagina_web = $pagina_web;
                        }
                    }
                }
                else {
                    //array_push($emailsss, $row->e_mail . " KEY: " . $key); 4081
                    $proveedor->email = $row->e_mail;
                }
                //grupo_cima2008@hotmail.com
                $proveedor->save();
            }
        });
    }

    private function crearFilaDatos($proveedores)
    {
        $info = array('Partidas', 'Cantidad', 'Unidad de Medida', 'Descripcion');
        for ($i=0; $i < sizeof($proveedores); $i++) {
            array_push($info, 'Precio Unitario');
            array_push($info, 'Precio Total');
        }
        return $info;
    }

    public function crearHeader($dependencia)
    {
        $encabezado = [];
        $nombre = ['GOBIERNO DEL ESTADO DE TLAXCALA'];
        $responsable = ['OFICIALÍA MAYOR DE GOBIERNO'];
        $descripcion = ['DIRECCIÓN GENERAL DE ADQUISICIONES, RECURSOS MATERIALES Y SERVICIOS'];
        $cuadro = ['CUADRO COMPARATIVO'];
        $dependencia = ["DEPENDENCIA: $dependencia"];
        array_push($encabezado, $dependencia);
        array_push($encabezado, $cuadro);
        array_push($encabezado, $descripcion);
        array_push($encabezado, $responsable);
        array_push($encabezado, $nombre);

        return $encabezado;
    }

    private function crearFilaProveedores($codificacion, $descripcion_req, $proveedores)
    {
        $prov = ["AD-" . $codificacion . " " . $descripcion_req, '', '', ''];
        for ($i=0; $i < sizeof($proveedores); $i++) { 
            array_push($prov, $proveedores[$i][0]->nombre);
            array_push($prov, '');
        }
        return $prov;
    }

    private function crearColumnasDatosOfertasYColoresDeCeldas($partidas, $proveedores, $size_proveedores, $ofertas_cuadroComparativo, $letras, $inicio_de_columna_para_colores){
        $columnasycolores = array();
        $columna_datos_oferta = array();
        $celdas_no_cumple = array();
        $celdas_no_cotiza = array();
        $celdas_ganadoras = array();
        foreach ($partidas as $key => $partida) {
            $datos_oferta_proveedor = array();
            array_push($datos_oferta_proveedor, $key+1);
            if (!is_numeric($partida->cantidad_ajuste)) {
                array_push($datos_oferta_proveedor, $partida->cantidad_minima);         
           }
           else {
                array_push($datos_oferta_proveedor, $partida->cantidad_ajuste);
            }
            array_push($datos_oferta_proveedor, $partida->unidad_medida);
            array_push($datos_oferta_proveedor, $partida->descripcion);
            
            $cont = 4;

            foreach ($proveedores as $key2 => $proveedor) {
                if($ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->status == 2){
                    array_push($datos_oferta_proveedor, "NO CUMPLE");
                    array_push($datos_oferta_proveedor, "NO CUMPLE");
                    array_push($celdas_no_cumple, $letras[$cont] . "" . ($key+$inicio_de_columna_para_colores));
                    array_push($celdas_no_cumple, $letras[$cont+1] . "" . ($key+$inicio_de_columna_para_colores));
                    $cont = $cont + 2;
                }
                elseif($ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->status == 5) {
                    array_push($datos_oferta_proveedor, "NO COTIZA");
                    array_push($datos_oferta_proveedor, "NO COTIZA");
                    array_push($celdas_no_cotiza, $letras[$cont] . "" . ($key+$inicio_de_columna_para_colores));
                    array_push($celdas_no_cotiza, $letras[$cont+1] . "" . ($key+$inicio_de_columna_para_colores));
                    $cont = $cont + 2;
                }
                else {
                    if($ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->ganador == 1){
                        array_push($datos_oferta_proveedor, $ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->precio_unitario);
                        array_push($datos_oferta_proveedor, $ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->importe_sin_iva);
                        array_push($celdas_ganadoras, $letras[$cont] . "" . ($key+$inicio_de_columna_para_colores));
                        array_push($celdas_ganadoras, $letras[$cont+1] . "" . ($key+$inicio_de_columna_para_colores));
                        $cont = $cont + 2;
                    }
                    else {
                        array_push($datos_oferta_proveedor, $ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->precio_unitario);
                        array_push($datos_oferta_proveedor, $ofertas_cuadroComparativo[$size_proveedores*$key+$key2]->importe_sin_iva);
                        $cont = $cont + 2;
                    } 
                } 
            }
            array_push($columna_datos_oferta, $datos_oferta_proveedor);
        }

        $columnasycolores = array('columnas_datos_ofertas' => $columna_datos_oferta, 'celdas_ganadoras' => $celdas_ganadoras, 'celdas_no_cotiza' => $celdas_no_cotiza, 'celdas_no_cumple' => $celdas_no_cumple);

        return $columnasycolores;
    }

    private function crearMontosTotales($proveedores, $ofertas_cuadroComparativo)
    {
        $monto_totales = ['', '', '', 'SUBTOTAL:'];
        //Montos totales
        foreach ($proveedores as $key => $proveedor) {
            array_push($monto_totales, "");
            array_push($monto_totales, $ofertas_cuadroComparativo->where('proveedor_id', $proveedor[0]['id'])->where('status', 1)->sum('importe_sin_iva'));
        }
        return $monto_totales;
    }

    private function crearIvasTotales($proveedores, $ofertas_cuadroComparativo)
    {
        $ivas_totales = ['', '', '', '16% DE IVA:'];
        //Montos totales
        foreach ($proveedores as $key => $proveedor) {
            array_push($ivas_totales, "");
            array_push($ivas_totales, $ofertas_cuadroComparativo->where('proveedor_id', $proveedor[0]['id'])->where('status', 1)->sum('importe_con_iva') - $ofertas_cuadroComparativo->where('proveedor_id', $proveedor[0]['id'])->where('status', 1)->sum('importe_sin_iva'));
        }
        return $ivas_totales;
    }

    private function crearCondicionesDePago($proveedores, $ofertas_cuadroComparativo)
    {
        $condiciones_pago = ['', '', '', 'CONDICIONES DE PAGO:'];
        //Montos totales
        foreach ($proveedores as $key => $proveedor) {
            array_push($condiciones_pago, "");
            $ofertas_ordenadas = array_values($ofertas_cuadroComparativo->where('proveedor_id', $proveedor[0]['id'])->where('status', 1)->toArray());
            foreach ($ofertas_ordenadas as $key2 => $oferta) {
                array_push($condiciones_pago, $ofertas_ordenadas[$key2]['condiciones_pago']);
            }
        }
        return $condiciones_pago;
    }

    private function crearTiemposEntrega($proveedores, $ofertas_cuadroComparativo)
    {
        $tiempos_entrega = ['', '', '', 'TIEMPOS DE ENTREGA:'];
        //Montos totales
        foreach ($proveedores as $key => $proveedor) {
            array_push($tiempos_entrega, "");
            $ofertas_ordenadas = array_values($ofertas_cuadroComparativo->where('proveedor_id', $proveedor[0]['id'])->where('status', 1)->toArray());
            foreach ($ofertas_ordenadas as $key2 => $oferta) {
                array_push($tiempos_entrega, $ofertas_ordenadas[$key2]['tiempo_entrega']);
            }
        }
        return $tiempos_entrega;
    }

    private function crearVigencia($proveedores, $ofertas_cuadroComparativo)
    {
        $vigencias = ['', '', '', 'VIGENCIA:'];
        //Montos totales
        foreach ($proveedores as $key => $proveedor) {
            array_push($vigencias, "");
            $ofertas_ordenadas = array_values($ofertas_cuadroComparativo->where('proveedor_id', $proveedor[0]['id'])->where('status', 1)->toArray());
            foreach ($ofertas_ordenadas as $key2 => $oferta) {
                array_push($vigencias, $ofertas_ordenadas[$key2]['vigencia']);
            }
        }
        return $vigencias;
    }

    private function crearTotales($proveedores, $ofertas_cuadroComparativo)
    {
        $totales = ['', '', '', 'TOTAL:'];
        //Montos totales
        foreach ($proveedores as $key => $proveedor) {
            array_push($totales, "");
            array_push($totales, $ofertas_cuadroComparativo->where('proveedor_id', $proveedor[0]['id'])->where('status', 1)->sum('importe_con_iva'));
        }
        return $totales;
    }

    private function crearSubtotalesAdjudicar($proveedores, $ofertas_cuadroComparativo)
    {
        $subtotales_adjudicados = ['', '', '', 'SUBTOTAL A ADJUDICAR POR PARTIDAS:'];
        //Montos totales
        foreach ($proveedores as $key => $proveedor) {
            array_push($subtotales_adjudicados, "");
            array_push($subtotales_adjudicados, $ofertas_cuadroComparativo->where('proveedor_id', $proveedor[0]['id'])->where('status', 1)->where('ganador', 1)->sum('importe_sin_iva'));
        }
        return $subtotales_adjudicados;
    }

    private function crearIvasAdjudicar($proveedores, $ofertas_cuadroComparativo)
    {
        $ivas_adjudicar = ['', '', '', '16% DE IVA:'];
        //Montos totales
        foreach ($proveedores as $key => $proveedor) {
            array_push($ivas_adjudicar, "");
            array_push($ivas_adjudicar, $ofertas_cuadroComparativo->where('proveedor_id', $proveedor[0]['id'])->where('status', 1)->where('ganador', 1)->sum('importe_con_iva') - $ofertas_cuadroComparativo->where('proveedor_id', $proveedor[0]['id'])->where('status', 1)->where('ganador', 1)->sum('importe_sin_iva'));
        }
        return $ivas_adjudicar;
    }

    private function crearTotalesAdjudicar($proveedores, $ofertas_cuadroComparativo)
    {
        $totales_adjudicar = ['', '', '', 'TOTAL:'];
        //Montos totales
        foreach ($proveedores as $key => $proveedor) {
            array_push($totales_adjudicar, "");
            array_push($totales_adjudicar, $ofertas_cuadroComparativo->where('proveedor_id', $proveedor[0]['id'])->where('status', 1)->where('ganador', 1)->sum('importe_con_iva'));
        }
        return $totales_adjudicar;
    }

    private function crearObservaciones($proveedores, $ofertas_cuadroComparativo)
    {
        $observaciones = ['', '', '', 'OBSERVACIONES:'];
        //Montos totales
        foreach ($proveedores as $key => $proveedor) {
            array_push($observaciones, "");
            $ofertas_ordenadas = array_values($ofertas_cuadroComparativo->where('proveedor_id', $proveedor[0]['id'])->where('status', 1)->toArray());
            foreach ($ofertas_ordenadas as $key2 => $oferta) {
                if (array_key_exists('observaciones', $observaciones)) {
                    array_push($observaciones, $ofertas_ordenadas[$key2]['observaciones']);
                }
                else {
                    array_push($observaciones, '');
                }
            }
        }
        return $observaciones;
    }

    private function crearTechoPresupuestal($partidas)
    {
        $techo_presupuestal = ['', '', '', 'TECHO PRESUPUESTAL:', ];
        //Techo presupuestal
        array_push($techo_presupuestal, $partidas[0]->requisicion->presupuesto);
        return $techo_presupuestal;
    }

    private function crearTotalAdjudicarProcedimiento($ofertas_cuadroComparativo)
    {
        $totales_adjudicar_procedimiento = ['', '', '', 'TOTAL ADJUDICADO:'];
        //Montos totales
        array_push($totales_adjudicar_procedimiento, $ofertas_cuadroComparativo->where('status', 1)->where('ganador', 1)->sum('importe_con_iva'));
        return $totales_adjudicar_procedimiento;
    }

    private function crearFirmas(){
        $firmas = ['', '', '', '', 'Elaboró', '', 'Revisó'];
        return $firmas;
    }

    private function crearNombresFirmas($elaboro){
        $nombresFirmas = ['', '', '', '', $elaboro, '', 'C.P. BLANCA AZUCENA CORTÉS ZARATE'];

        return $nombresFirmas;
    }

    private function crearCeldasColores($columnasycolores){
        $celdas = array();
        array_push($celdas, $columnasycolores['celdas_no_cotiza']);
        array_push($celdas, $columnasycolores['celdas_no_cumple']);
        array_push($celdas, $columnasycolores['celdas_ganadoras']);
        return $celdas;
    }

    private function crearDatosFinales($columnasycolores, $info, $prov, $montos_totales, $ivas, $totales, $condiciones, $tiempos_entrega, $vigencias, $subtotales_adjudicados, $ivas_adjudicar, $totales_adjudicar, $observaciones, $techo_presupuestal, $totales_adjudicar_procedimiento, $encabezado, $firmas, $nombresFirmas)
    {
        $datos_excel = $columnasycolores['columnas_datos_ofertas'];
        //Agregamos al incio del array la información
        array_unshift($datos_excel, $info);
        //Agregamos al inicio de todo los proveedores
        array_unshift($datos_excel, $prov);
        //Agregamos al final los subtotales
        array_push($datos_excel, $montos_totales);
        //Agregamos al final los ivas
        array_push($datos_excel, $ivas);
        //Agregamos al final los totales
        array_push($datos_excel, $totales);
        //Agregamos al final los condiciones de pago
        array_push($datos_excel, $condiciones);
        //Agregamos al final los tiempos de entrega
        array_push($datos_excel, $tiempos_entrega);
        //Agregamos al final los vigencias
        array_push($datos_excel, $vigencias);
        //Agregamos al final los subtotales adjudicados
        array_push($datos_excel, $subtotales_adjudicados);
        //Agregamos al final los ivas a adjudicar
        array_push($datos_excel, $ivas_adjudicar);
        //Agregamos al final los totales a adjudicar
        array_push($datos_excel, $totales_adjudicar);
        //Agregamos al final las observaciones
        array_push($datos_excel, $observaciones);
        //Agregar espacio
        array_push($datos_excel, []);
        //Agregar techo presupuestal
        array_push($datos_excel, $techo_presupuestal);
        //Agregamos al final el total adjudicado del procedimiento
        array_push($datos_excel, $totales_adjudicar_procedimiento);
        //Agregar espacio
        array_push($datos_excel, []);
        array_push($datos_excel, []);
        //Agregamos al final las firmas
        array_push($datos_excel, $firmas);
        //Agregar espacio
        array_push($datos_excel, []);
        //Agregamos al final las firmas
        array_push($datos_excel, $nombresFirmas);
       
        array_unshift($datos_excel, $encabezado[0]);
         /*
        array_unshift($datos_excel, $encabezado[1]);
        array_unshift($datos_excel, $encabezado[2]);
        array_unshift($datos_excel, $encabezado[3]);
        array_unshift($datos_excel, $encabezado[4]);
        */
        //dd($datos_excel);
        return $datos_excel;
    }

    public function descargaCuadroComparativo($id, $descripcion, $proveedores, $partidas, $ofertas_cuadroComparativo, $size_proveedores)
    {
        Excel::create("Cuadro Comparativo Proc: $id", function($excel) use($proveedores, $partidas, $ofertas_cuadroComparativo, $size_proveedores, $descripcion) {
            $fila_inicio = 3;
            $letras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'W', 'X', 'Y', 'Z'];

            $encabezado = $this->crearHeader($partidas[0]->requisicion->dependencia->nombre);
            $requisicion = $partidas[0]->requisicion;
            $codificacion = $requisicion->mes . "_" . $requisicion->consecutivo . "-" . $requisicion->anio;
            $info = $this->crearFilaDatos($proveedores);
            $prov = $this->crearFilaProveedores($codificacion, $descripcion, $proveedores);

            $columnasycolores = $this->crearColumnasDatosOfertasYColoresDeCeldas($partidas, $proveedores, $size_proveedores, $ofertas_cuadroComparativo, $letras, $fila_inicio + 2);

            $monto_totales = $this->crearMontosTotales($proveedores, $ofertas_cuadroComparativo);

            $ivas_totales = $this->crearIvasTotales($proveedores, $ofertas_cuadroComparativo);

            $totales = $this->crearTotales($proveedores, $ofertas_cuadroComparativo);

            $condiciones = $this->crearCondicionesDePago($proveedores, $ofertas_cuadroComparativo);

            $tiempos_entrega = $this->crearTiemposEntrega($proveedores, $ofertas_cuadroComparativo);

            $vigencias = $this->crearVigencia($proveedores, $ofertas_cuadroComparativo);

            $subtotales_adjudicados = $this->crearSubtotalesAdjudicar($proveedores, $ofertas_cuadroComparativo);

            $ivas_adjudicar = $this->crearIvasAdjudicar($proveedores, $ofertas_cuadroComparativo);

            $totales_adjudicar = $this->crearTotalesAdjudicar($proveedores, $ofertas_cuadroComparativo);

            $observaciones = $this->crearObservaciones($proveedores, $ofertas_cuadroComparativo);

            $techo_presupuestal = $this->crearTechoPresupuestal($partidas);

            $totales_adjudicar_procedimiento = $this->crearTotalAdjudicarProcedimiento($ofertas_cuadroComparativo);
            
            $celdas = $this->crearCeldasColores($columnasycolores);

            $firmas = $this->crearFirmas();

            $nombresFirmas = $this->crearNombresFirmas($ofertas_cuadroComparativo[0]->procedimiento->analista->name);

            $datos_excel = $this->crearDatosFinales($columnasycolores, $info, $prov, $monto_totales, $ivas_totales, $totales, $condiciones, $tiempos_entrega, $vigencias, $subtotales_adjudicados, $ivas_adjudicar, $totales_adjudicar, $observaciones, $techo_presupuestal, $totales_adjudicar_procedimiento, $encabezado, $firmas, $nombresFirmas); 

            $excel->setTitle('Cuadro Comparativo');

            // Chain the setters
            $excel->setCreator('Carlos Cuamatzin Hernandez')
                  ->setCompany('SIAA');

            // Call them separately
            $excel->setDescription('Cuadro Comparativo');
            if (strlen($descripcion) > 30) {
                $descripcion = mb_substr($descripcion, 0, 28);
            }
            
            $excel->sheet('Cuadro Comparativo ' .  $codificacion, function($sheet) use($prov, $datos_excel, $celdas, $proveedores, $letras, $partidas, $fila_inicio) {

                $objDrawing = new PHPExcel_Worksheet_Drawing;
                $objDrawing->setPath(public_path('images/encabezado_cuadro.png')); //your image path
                $objDrawing->setCoordinates('A1');
                $objDrawing->setWorksheet($sheet);
                // Set size for a single cell
                $sheet->setSize('A1', 5, 150);
                $sheet->mergeCells('A1:O1');

                $fila_inicio_proveedores = $fila_inicio;
                // Set width for a single column
                
                $sheet->setAutoSize(array(
                    'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'
                ));

                //Determinar tamaño de celda de descripción de partida
                $contador = $fila_inicio + 2;
                foreach ($partidas as $key => $partida) {
                    if (strlen($partida->descripcion) <= 250) {
                        $sheet->setSize("D$contador", 65, 70);
                    }
                    elseif (strlen($partida->descripcion) <= 350) {
                        $sheet->setSize("D$contador", 65, 90);
                    }
                    elseif (strlen($partida->descripcion) <= 550) {
                        $sheet->setSize("D$contador", 65, 120);
                    }
                    elseif (strlen($partida->descripcion) <= 800){
                        $sheet->setSize("D$contador", 65, 250);
                    }
                    elseif (strlen($partida->descripcion) <= 1000){
                        $sheet->setSize("D$contador", 65, 300);
                    }
                    else {
                        $sheet->setSize("D$contador", 65, 400);
                    }
                    $sheet->getStyle('D1:E999')->getAlignment()->setWrapText(true);
                    $contador = $contador + 1;
                }

                //Variable que ubica la letra del ultimo proveedor
                if (count($proveedores) % 2 == 0) {
                    $final_letra_proveedores = $letras[count($proveedores) + 7];
                }
                else {
                    $final_letra_proveedores = $letras[count($proveedores) + 8];
                }

                //Variable que determina ultima fila de partida
                $final_partidas = count($partidas) + $fila_inicio + 2;
                //Combinar header
                /*
                $sheet->mergeCells("A2:$final_letra_proveedores" . "2");
                $sheet->mergeCells("A3:$final_letra_proveedores" . "3");
                $sheet->mergeCells("A4:$final_letra_proveedores" . "4");
                $sheet->mergeCells("A5:$final_letra_proveedores" . "5");
                $sheet->mergeCells("A6:$final_letra_proveedores" . "6");
                */
                
                //Combinar celdas de la descripcion de la requisicion
                $sheet->mergeCells("A$fila_inicio_proveedores:D$fila_inicio_proveedores");
                //Combinar nombres de proveedores
                for ($i=4; $i < sizeof($proveedores)*2 + 4; $i = $i+2) {
                    $sheet->mergeCells($letras[$i] . "$fila_inicio_proveedores:" . $letras[$i+1] . "$fila_inicio_proveedores");
                }

                //Formato de Header
                /*
                for ($i=2; $i < 7; $i++) { 
                    $sheet->cells("A$i:E$i", function($cells) {                 
                        $cells->setFontColor('#808080');
                        $cells->setAlignment('center');
                        $cells->setFontSize(16);
                        $cells->setBackground('#E2E2E2');
                    });   
                }
                */
                
                $inicio_formato = "A$fila_inicio";
                //Formato de fila de proveedores
                $sheet->cells("$inicio_formato:$final_letra_proveedores" . "$fila_inicio", function($cells) {                 
                    $cells->setFontColor('#FAFFFF');
                    $cells->setFontSize(11);
                    $cells->setAlignment('center');
                    $cells->setBackground('#A5A5A5');
                });

                //Formato de fila de menu
                $inicio_formato_menu_number = $fila_inicio + 1;
                $inicio_formato_menu = "A$inicio_formato_menu_number";
                $sheet->cells("$inicio_formato_menu:$final_letra_proveedores" . "$inicio_formato_menu_number", function($cells) {                 
                    $cells->setFontColor('#09600B');
                    $cells->setAlignment('center');
                    $cells->setBackground('#C7EECF');
                });

                //Formato de fila de ofertas de cada proveedor
                $cont_fila_proveedor = $fila_inicio + 2;
                //Centrar cantidades de fila de cada oferta de proveedores
                foreach ($proveedores as $key => $proveedor) {
                    $sheet->cells("E$cont_fila_proveedor:$final_letra_proveedores" . "$cont_fila_proveedor", function($cells) use ($cont_fila_proveedor){    
                        $cells->setAlignment('center');

                        $cont_fila_proveedor = $cont_fila_proveedor + 1;
                    });
                }

                //Dar formato de moneda a las filas de ofertas de cada proveedor
                foreach ($partidas as $key => $partida) {
                    $sheet->setColumnFormat([
                        "E$cont_fila_proveedor:$final_letra_proveedores" . "$cont_fila_proveedor" => '"$"#,##0.00_-'
                    ]);
                    $cont_fila_proveedor = $cont_fila_proveedor + 1;
                }

                //Dar formato de moneda a subtotales, totales, iva
                $final_totales = $final_partidas + 3;
                $sheet->setColumnFormat([
                    "F$final_partidas:$final_letra_proveedores" . "$final_totales" => '"$"#,##0.00_-'
                ]);

                $final_vigencia = $final_partidas + 6;
                //Dar color a subtotales, totales, iva
                $sheet->cells("D$final_partidas:$final_letra_proveedores" . "$final_vigencia", function($cells){    
                    $cells->setAlignment('center');
                    $cells->setFontColor('#9B6415');
                    $cells->setValignment('middle');
                    $cells->setBackground('#FEEAA0');
                });

                //Dar formato de moneda a subtotales, totales, iva ADJUDICADOS
                $final_totales_adjudicados = $final_vigencia + 3;
                $sheet->setColumnFormat([
                    "F$final_vigencia:$final_letra_proveedores" . "$final_totales_adjudicados" => '"$"#,##0.00_-'
                ]);

                //Dar color a subtotales, totales, iva ADJUDICADOS
                $sheet->cells("D$final_vigencia:$final_letra_proveedores" . "$final_totales_adjudicados", function($cells){    
                    $cells->setAlignment('center');
                    $cells->setFontColor('#9B6415');
                    $cells->setValignment('middle');
                    $cells->setBackground('#FECB9C');
                });

                //Dar formato de moneda a total adjudicado de procedimiento
                $final_obervaciones = $final_totales_adjudicados + 2;
                $sheet->setColumnFormat([
                    "E$final_obervaciones:$final_letra_proveedores" . "$final_obervaciones" => '"$"#,##0.00_-'
                ]);

                //Dar color a techo presupuestal
                $sheet->cells("D$final_obervaciones:E" . "$final_obervaciones", function($cells){    
                    $cells->setAlignment('center');
                    $cells->setFontColor('#A02E50');
                    $cells->setValignment('middle');
                    $cells->setBackground('#FEC7CE');
                });

                //Dar formato de moneda a total adjudicado de procedimiento
                $final_techo_presupuestal = $final_obervaciones + 1;
                $sheet->setColumnFormat([
                    "E$final_techo_presupuestal:$final_letra_proveedores" . "$final_techo_presupuestal" => '"$"#,##0.00_-'
                ]);

                //Dar color a total adjudicado de procedimiento
                $sheet->cells("D$final_techo_presupuestal:E" . "$final_techo_presupuestal", function($cells){    
                    $cells->setAlignment('center');
                    $cells->setFontColor('#A02E50');
                    $cells->setValignment('middle');
                    $cells->setBackground('#FEC7CE');
                });

                //Poner borders a nombre de requisicion
                $sheet->cells("A$fila_inicio:D$fila_inicio", function($cells){
                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                });

                //Bordes de nombres de proveedores
                $letraE = 4;
                for ($i = 0; $i < sizeof($proveedores); $i++){
                    $sheet->cells($letras[$letraE] . "$fila_inicio:" . $letras[$letraE+1] . "$fila_inicio", function($cells){
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                    });
                    $letraE = $letraE + 2;
                }

                //Bordes Partidas, Cantidad, Unidad Medida, Precios Unitarios, Precio Total
                $fila_inicio_mas_uno = $fila_inicio + 1;
                $posicion_final_letra_proveedores = array_search($final_letra_proveedores, $letras);
                for ($i=0; $i < $posicion_final_letra_proveedores + 1; $i++) { 
                    $sheet->cells($letras[$i] . "$fila_inicio_mas_uno:" . $letras[$i] . "$fila_inicio_mas_uno", function($cells){
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');
                    });
                }
                //Borders de todas las partidas
                $letra_inicial_partidas = $fila_inicio + 2;

                for ($f=0; $f < sizeof($partidas); $f++) { 
                    for ($i=0; $i < $posicion_final_letra_proveedores + 1; $i++) { 
                        $sheet->cells($letras[$i] . "$letra_inicial_partidas:" . $letras[$i] . "$letra_inicial_partidas", function($cells){
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            $cells->setFontColor('#09600B');
                            $cells->setAlignment('center');
                            $cells->setValignment('middle');
                            $cells->setBackground('#EBF1DF');
                        });
                    }
                    $letra_inicial_partidas = $letra_inicial_partidas + 1;
                }

                //Bordes de subtotal, ivas, totales, observaciones
                $letraE = 4;
                for ($i=$final_partidas; $i < $final_partidas + 10; $i++) {
                    for ($f = 0; $f < sizeof($proveedores); $f++){
                        $sheet->cells($letras[$letraE] . "$i:" . $letras[$letraE+1] . "$i", function($cells){
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        $letraE = $letraE + 2;
                    }
                    $letraE = 4;
                }
                //Dar color a celdas ganadoras, no cotiza, no cumple
                foreach ($celdas as $sec => $celda_seccion) {
                    foreach ($celda_seccion as $key => $celda) {
                        $sheet->cell($celda, function($cell) use ($sec) {
                            if ($sec == 0) {
                                $cell->setBackground('#F5DF95');
                            }
                            elseif ($sec == 1) {
                                $cell->setBackground('#DA955B');
                            }
                            else {
                                $cell->setBackground('#72C786');
                            }
                        });
                    }
                }

                //Centrar firmas
                $inicio_firmas = $final_totales_adjudicados + 4;
                $final_firmas = $inicio_firmas + 3;
                $sheet->cells("E$inicio_firmas:" . "I$final_firmas", function($cells){
                    $cells->setAlignment('center');
                });

                // Bordes de informacion por proveedor
                $contador = 4;
                $final_borde = $final_obervaciones - 3;
                foreach ($proveedores as $key => $proveedor) {
                    $letraInicial = $letras[$contador];
                    $letraFinal = $letras[$contador + 1];
                    $sheet->cells($letraInicial . "7:" . $letraFinal . $final_borde, function($cells){
                        $cells->setBorder('medium', 'medium', 'medium', 'medium');
                    });
                    $contador = $contador + 2;
                }

                //$sheet->mergeCells("A2:$letraFinal" . "2");

                $sheet->with($datos_excel);
            });
        })->download('xlsx');
    }


    public function descargaProgramaAnual($programa_anual)
    {
        Excel::create("Cuadro Comparativo Proc", function($excel) use($programa_anual){
            $letras = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'W', 'X', 'Y', 'Z');
            $total = array();
            $trimestres = ['','','','','','','','1º Trimestre', '', '2º Trimestre', '', '3º Trimestre',  '', '4º Trimestre'];
            $info = ['No', 'Marca', 'U. Medida', 'Descripcion', 'Cant. Req. Total', 'Precio Unit.', 'Pres. Total Art.', 'Cantidad', 'Presupuesto', 'Cantidad', 'Presupuesto', 'Cantidad', 'Presupuesto', 'Cantidad', 'Presupuesto'];
            $datos = ['DEPENDENCIA: ' . $programa_anual->dependencia->nombre, null, null, null, null, null, null, 'PRESUPUESTO TOTAL ANUAL: ' . $programa_anual->presupuesto_total_anual];
            array_push($total, $datos);
            $datos = ['DOMICILIO: ' . $programa_anual->domicilio, null, null, null, null, null, null, 'PROGRAMA: ' . $programa_anual->programa];
            array_push($total, $datos);
            $datos = ['FUENTE DE FINANCIAMIENTO: ' . $programa_anual->fuente_financiamiento, null, null, null, null, null, null, 'SUBPROGRAMA: ' . $programa_anual->subprograma];
            array_push($total, $datos);
            $datos = [];
            array_push($total, $datos);
            $partida_presupuestal_array = array();
            $partidas = array();
            $celdas_merge = 6;
            $celdas_merge_array = array();
            foreach ($programa_anual->partidas_presupuestales as $key => $partida_presupuestal) {
                $partida_presupuestal_array = ['PARITDA PRESUPUESTAL: '. $partida_presupuestal->partida_presupuestal . '     CONCEPTO: ' . $partida_presupuestal->concepto, '', '', '', '', '', '', '', '', '', '', '', '', 'Acumulado:', '$' . $partida_presupuestal->partidas->sum('presupuesto_total_articulo')];
                array_push($total, $partida_presupuestal_array);
                $partida_presupuestal_array = array();
                array_push($total, $trimestres);
                array_push($total, $info);
                $datos_oferta_proveedor = [];
                foreach ($partida_presupuestal->partidas as $key => $partida) {
                    array_push($partidas, $key +1);
                    array_push($partidas, $partida->marca);
                    array_push($partidas, $partida->unidad_medida);
                    array_push($partidas, $partida->descripcion);
                    if (!is_numeric($partida->cantidad_ajuste)) {
                        array_push($partidas, $partida->cantidad_minima);
                    }
                    else {
                        array_push($partidas, $partida->cantidad_ajuste);
                    }
                    array_push($partidas, $partida->precio_unitario);
                    array_push($partidas, $partida->presupuesto_total_articulo);
                    //AQUI VAN TRIMESTRES
                    $periodos = $partida->periodos_pago()->orderBy('descripcion', 'asc')->get();
                    $nums = array();
                    foreach ($partida->periodos_pago as $key => $periodo) {
                        array_push($nums, $periodo->descripcion);
                    }
                    sort($nums);
                    $cont = 0;
                    for ($i=1; $i < 5; $i++) {
                        $valores = array();
                        $vals = array();
                        if (in_array($i, $nums)) {
                            array_push($partidas, $periodos[$cont]->cantidad_articulos);
                            array_push($partidas, $partida->precio_unitario * $periodos[$cont]->cantidad_articulos);
                            $cont = $cont + 1;
                        }
                        else {
                            array_push($partidas, '');
                            array_push($partidas, '');
                        }
                    }
                    //AQUI TERMINA
                    array_push($total, $partidas);
                    $partidas = array();
                    $celdas_merge = $celdas_merge + 1;
                }
                $celdas_merge = $celdas_merge + 4;
                array_push($celdas_merge_array, $celdas_merge);
                array_push($total, []);
            }

            $nombres = ['', '', '', '', '', '', '', '', '', Auth::user()->name, '', $programa_anual->dependencia->autoriza, '', $programa_anual->dependencia->titular, ''];
            array_push($total, $nombres);
            array_push($total, []);
            array_push($total, ['', '', '', '', '', '', '', '', '', 'ELABORO', '', 'AUTORIZA', '', 'VALIDA', '']);
            $excel->setTitle('Cuadro Comparativo');

            // Chain the setters
            $excel->setCreator('Carlos Cuamatzin Hernandez')
                  ->setCompany('SIAA');

            // Call them separately
            $excel->setDescription('A demonstration to change the file properties');
            $descripcion = "HOLA";
            $excel->sheet($descripcion, function($sheet) use($total, $celdas_merge_array, $programa_anual) {
                $objDrawing = new PHPExcel_Worksheet_Drawing;
                $objDrawing->setPath(public_path('images/encabezado.jpg')); //your image path
                $objDrawing->setCoordinates('A1');
                $objDrawing->setWorksheet($sheet);
                // Set size for a single cell
                $sheet->setSize('A1', 5, 150);
                $sheet->mergeCells('A1:O1');
                $sheet->mergeCells('H2:O2');
                $sheet->mergeCells('H3:O3');
                $sheet->mergeCells('H4:O4');
                //Datos de Dependencia
                // Set width for a single column
                $sheet->mergeCells('A2:G2');
                $sheet->mergeCells('A3:G3');  
                $sheet->mergeCells('A4:G4');
                //Primera Partida Presupuestal
                $sheet->mergeCells('A6:G6');
                //Primera informacion
                $sheet->cells("A8:O8", function($cells) {
                    $cells->setBackground('#DEDD97');
                    $cells->setAlignment('left');
                    $cells->setValignment('middle');
                });

                $sheet->cells("E4:Z4", function($cells) {
                    $cells->setAlignment('left');
                    $cells->setValignment('middle');
                });

                // Disable auto size for columns
                $sheet->setAutoSize(array(
                    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'
                ));

                //Primer Trimestre
                $sheet->mergeCells("H7:I7");
                $sheet->mergeCells("J7:K7");
                $sheet->mergeCells("L7:M7");
                $sheet->mergeCells("N7:O7");
                $sheet->cells("H7:O7", function($cells) {
                    $cells->setBackground('#DEDD97');
                });
                //Demas Partidas Presupuestales
                for ($i=0; $i < sizeof($celdas_merge_array) - 1; $i++) { 
                    $numero = $celdas_merge_array[$i];
                    $numero2 = $celdas_merge_array[$i] + 1;
                    $numero3 = $celdas_merge_array[$i] + 2;
                    //Combinamos celdas para partida presupuestal y concepto y se ponen de color
                    $sheet->mergeCells("A$numero:G$numero");
                    $sheet->cells("A$numero:O$numero", function($cells) {
                        $cells->setBackground('#92E87F');
                    });
                    //Coloreamos menus de inforamción
                    $sheet->cells("A$numero3:O$numero3", function($cells) {
                        $cells->setBackground('#DEDD97');
                    });

                    //Combinamos Trimestres
                    $sheet->mergeCells("H$numero2:I$numero2");
                    $sheet->mergeCells("J$numero2:K$numero2");
                    $sheet->mergeCells("L$numero2:M$numero2");
                    $sheet->mergeCells("N$numero2:O$numero2");
                    $sheet->cells("H$numero2:O$numero2", function($cells) {
                        $cells->setBackground('#DEDD97');
                    });
                    if (sizeof($celdas_merge_array) - 2 == $i) {
                        $numero4 = $celdas_merge_array[$i+1];
                        $numero5 = $celdas_merge_array[$i+1] + 2;
                        $sheet->mergeCells("J$numero4:K$numero4");
                        $sheet->mergeCells("L$numero4:M$numero4");
                        $sheet->mergeCells("N$numero4:O$numero4");
                        $sheet->mergeCells("J$numero5:K$numero5");
                        $sheet->mergeCells("L$numero5:M$numero5");
                        $sheet->mergeCells("N$numero5:O$numero5");
                    }
                }
                $sheet->cells('A2:O2', function($cells) {
                    $cells->setBackground('#95E684');
                });
                $sheet->cells('A3:O3', function($cells) {
                    $cells->setBackground('#95E684');
                });
                $sheet->cells('A4:O4', function($cells) {
                    $cells->setBackground('#95E684');
                });
                $sheet->cells('A6:O6', function($cells) {
                    $cells->setBackground('#92E87F');
                });
                if ($programa_anual->formato == "pdf") {
                    $sheet->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                    $sheet->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A3);
                    $sheet->setShowGridlines(false);
                    $sheet->getPageSetup()->setScale(50);
                }
                $sheet->with($total);
            });
        })->download($programa_anual->formato);
    }

    public function example()
    {
        Excel::create('New file', function($excel) {
            $excel->sheet('New sheet', function($sheet) {
                $sheet->loadView('excel.cuadroComparativo', ['hola' => 'yeeeeei']);
            });

        })->download('xlsx');
    }

    private function datos_de_archivo($excel)
    {
        // Set the title
        $excel->setTitle('Reporte');

        // Chain the setters
        $excel->setCreator('SIAA')
              ->setCompany('SIAA');

        // Call them separately
        $excel->setDescription('Reporte');

        return $excel;
    }

    private function crear_datos_archivo($procedimientos, $proveedor)
    {
        $datos_array = array();

        foreach ($procedimientos as $key => $procedimiento) {
            //Varios proveedores adjudicados
            $procedimiento = Requisicion::findOrFail($procedimiento['id']);
            $proveedoresAdjudicados = $procedimiento->procedimiento->proveedoresAdjudicados();
            if ($proveedor) {
                $proveedoresAdjudicados = $proveedoresAdjudicados->where('id', $proveedor);
            }
            if (sizeof($proveedoresAdjudicados) > 1) {
                foreach ($proveedoresAdjudicados as $key => $proveedorAdjudicado) {
                    if ($key == 0) {
                        $datos_factura = [$key+1, $procedimiento->procedimiento->numeroProcedimiento(), $procedimiento->presupuesto, $procedimiento->dependencia->nombre, $procedimiento->origenRecursos($procedimiento->origen_recursos), $procedimiento->partida_presupuestal, $procedimiento->descripcion, $procedimiento->procedimiento->status, $proveedorAdjudicado->nombre, $procedimiento->procedimiento->adjudicadoPorProveedor($proveedorAdjudicado->id) ,$procedimiento->procedimiento->totalAdjudicado(), '', '', $procedimiento->procedimiento->analista->name];
                    }
                    else {
                        $datos_factura = ['', '', '', '', '', '', '', '', $proveedorAdjudicado->nombre, $procedimiento->procedimiento->adjudicadoPorProveedor($proveedorAdjudicado->id), '', '', ''];
                    }
                    array_push($datos_array, $datos_factura);
                }
            }
            else {
                if ($proveedor) {
                    $nombre = $proveedoresAdjudicados->first()->nombre;
                    $montos = $procedimiento->procedimiento->adjudicadoPorProveedor($proveedoresAdjudicados->first()->id);
                }
                else {
                    $nombre = $procedimiento->procedimiento->proveedoresAdjudicadosFormated();
                    $montos = $procedimiento->procedimiento->totalAdjudicado();
                }
                $datos_factura = [$key+1, $procedimiento->procedimiento->numeroProcedimiento(), $procedimiento->presupuesto, $procedimiento->dependencia->nombre, $procedimiento->origenRecursos($procedimiento->origen_recursos), $procedimiento->partida_presupuestal, $procedimiento->descripcion, $procedimiento->procedimiento->status, $nombre, $montos, $procedimiento->procedimiento->totalAdjudicado(), '', '', $procedimiento->procedimiento->analista->name];
                array_push($datos_array, $datos_factura);
            }
        }
        $nombres_columnas = ['No', 'No. Procedimiento', 'Techo Presupuestal', 'Dependencia', 'Tipo de recurso', 'Partida Presupuestal', 'Concepto', 'Status', 'Nombre Proveedor Adjudicado', 'Monto Adj. por Proveedor' ,'Monto Adjudicado', 'Fecha de Pedido', 'Factura', 'Analista'];

        array_unshift($datos_array, $nombres_columnas);
        return $datos_array;
    }

    private function crear_hoja($excel, $datos)
    {
        $excel->sheet('Datos', function($sheet) use($datos){
            $sheet->with($datos);
        });

        return $excel;
    }

    public function descargarReporte($procedimientos, $proveedor)
    {
        Excel::create('reporteInforme', function($excel) use ($procedimientos, $proveedor) {

            $excel = $this->datos_de_archivo($excel);

            $datos = $this->crear_datos_archivo($procedimientos, $proveedor);

            $excel = $this->crear_hoja($excel, $datos);

        })->download('xlsx');;
    }

    public function descargarRequisiciones($requisiciones)
    {
        Excel::create('reporteRequisiciones', function($excel) use ($requisiciones) {

            $excel = $this->datos_de_archivo($excel);

            $datos = $this->crear_datos_archivo_requisiciones($requisiciones);

            $excel = $this->crear_hoja($excel, $datos);

        })->download('xlsx');;
    }

    public function crear_datos_archivo_requisiciones($requisiciones)
    {
        $datos_array = [];

        foreach ($requisiciones as $key => $requisicion) {
            $datos_requisicion = [
                $requisicion->id,
                $requisicion->mes . '_' . $requisicion->consecutivo . '-' . $requisicion->anio,
                strlen($requisicion->descripcion) > 60 ? substr($requisicion->descripcion, 0, 59) . '...' : $requisicion->descripcion,
                $requisicion->dependencia->nombre,
                $requisicion->usuario->name,
                $requisicion->status,
                $requisicion->presupuesto,
                $requisicion->origenRecursos($requisicion->origen),
                $requisicion->created_at
            ];
            array_push($datos_array, $datos_requisicion);
        }
        $nombres_columnas = ['Id', 'Codificación', 'Descripcion', 'Dependencia', 'Asesor', 'Status', 'Presupuesto', 'Tipo de Recurso' ,'Fecha Creación'];

        array_unshift($datos_array, $nombres_columnas);
        return $datos_array;
    }
}


