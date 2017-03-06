<?php namespace App\Services;
use Carbon\Carbon;
use App\Services\NumerosLetras;

/**
* Clase que se encarga de todo Word
*/

class WordGenerator
{
    function __construct()
    {
        # code...
    }

    private function download($document, $filename = "reporte.docx")
    {
        $document->saveAs($filename);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        flush();
        readfile($filename);
        unlink($filename);
    }

    public function createDocument($requisicion)
    {
        $now = Carbon::now();
        $req_sin_cantidad_max = false;
        if ($requisicion->anio ==  '2017') {
            if ($requisicion->partidas->sum('cantidad_maxima') == 0) {
                $document = new \PhpOffice\PhpWord\TemplateProcessor('req2017_sin_cantidad_max.docx');
                $req_sin_cantidad_max = true;
            }
            else {
                $document = new \PhpOffice\PhpWord\TemplateProcessor('req2017.docx');
            }
        }
        else {
            $document = new \PhpOffice\PhpWord\TemplateProcessor('req.docx');
        }
        $document->setValue('contratante', htmlspecialchars($requisicion->dependencia->nombre));
        $document->setValue('tipo_procedimiento', htmlspecialchars($requisicion->value_procedimiento_adjudicacion()));
        $document->setValue('garantia', htmlspecialchars($requisicion->garantia));
        if ($requisicion->unidad_administrativa != null) {
            $document->setValue('unidad_responsable', htmlspecialchars($requisicion->unidad_administrativa->nombre));
        }
        else {
            $document->setValue('unidad_responsable', htmlspecialchars($requisicion->dependencia->nombre));
        }
        $document->setValue('domicilio', htmlspecialchars($requisicion->dependencia->calle . " " . $requisicion->dependencia->numero_exterior . "-" . $requisicion->dependencia->numero_interior . ". " . $requisicion->dependencia->colonia));
        $document->setValue('nombre', htmlspecialchars($requisicion->asesor));
        $document->setValue('cargo', htmlspecialchars($requisicion->cargo_asesor));
        $document->setValue('email_asesor', htmlspecialchars($requisicion->email_asesor));
        $document->setValue('req_descripcion', htmlspecialchars($requisicion->descripcion));
        $document->setValue('tiempo_entrega', htmlspecialchars($requisicion->tiempo_entrega));
        $document->setValue('codificacion', htmlspecialchars($requisicion->codificacion));
        $document->setValue('dias_pago', htmlspecialchars($requisicion->dias_pago));
        $document->setValue('datos_facturacion', htmlspecialchars($requisicion->datos_facturacion));
        $document->setValue('origen_recursos', htmlspecialchars($requisicion->origenRecursos($requisicion->origen_recursos)));
        $document->setValue('monto', htmlspecialchars("$$requisicion->presupuesto"));
        $document->setValue('partida_presupuestal', htmlspecialchars($requisicion->partida_presupuestal));
        $document->setValue('codigo', htmlspecialchars($requisicion->mes . "_" . $requisicion->consecutivo));
        $document->setValue('anio', htmlspecialchars($requisicion->anio));
        $document->setValue('dia', htmlspecialchars($now->day));
        $document->setValue('mes', htmlspecialchars($requisicion->mes));
        $document->setValue('elaboro', htmlspecialchars($requisicion->usuario->name));
        $document->setValue('autorizo', htmlspecialchars($requisicion->dependencia->autoriza));
        $document->setValue('cargo_autoriza', htmlspecialchars($requisicion->dependencia->cargo_autoriza));
        $document->setValue('visto_bueno', htmlspecialchars($requisicion->dependencia->valida));
        $document->setValue('cargo_valida', htmlspecialchars($requisicion->dependencia->cargo_valida));
        $document->setValue('requisitos_informativos', htmlspecialchars($requisicion->requisitos_informativos));
        $document->setValue('requisitos_economicos', htmlspecialchars($requisicion->requisitos_economicos));
        $document->setValue('observaciones', htmlspecialchars($requisicion->observaciones));
        $document->setValue('lugar_entrega', htmlspecialchars($requisicion->lugar_entrega));
        $document->setValue('condiciones_pago', htmlspecialchars($requisicion->condiciones_pago));

        $requisicion->requisitos_tecnicos != '' ? $document->setValue('requisitos_tecnicos', htmlspecialchars("-" . $requisicion->requisitos_tecnicos)) : $document->setValue('requisitos_tecnicos', htmlspecialchars(''));

        if ($requisicion->anio == '2017') {
            $vigencia = $requisicion->vigencia ==false ? "NO" : "SI";
            $document->setValue('vigencia', htmlspecialchars($vigencia));
            $vigencia_especificacion = $vigencia == "NO" ? "" : $requisicion->vigencia_especificacion;
            $document->setValue('vigencia_especificacion', htmlspecialchars($vigencia_especificacion));
            $requisicion->anticipo != '' ? $document->setValue('anticipo', htmlspecialchars('SI ' . $requisicion->anticipo)) : $document->setValue('anticipo', htmlspecialchars('NO'));
            $document->setValue('dias_credito', htmlspecialchars($requisicion->dias_pago));
            $dias_entrega = $requisicion->dias_entrega_lunes_viernes ? "Lunes - Viernes" : $requisicion->dias_entrega_texto;
            $document->setValue('dias_entrega', htmlspecialchars($dias_entrega));
            $document->setValue('hora_entrega_inicial', htmlspecialchars($requisicion->hora_entrega_inicial));
            $document->setValue('hora_entrega_final', htmlspecialchars($requisicion->hora_entrega_final));
            $instalacion = $requisicion->instalacion ? "INCLUYE INSTALACIÓN Y PUESTA EN FUNCIONAMIENTO AL 100 %." : "";
            $document->setValue('instalacion', htmlspecialchars($instalacion));
            $empacado = $requisicion->empacado ? "ENTREGAR EMPACADO DE ACUERDO A LA DESCRIPCIÓN DE CADA PARTIDA" : "";
            $document->setValue('empacado', htmlspecialchars($empacado));
            $requisitos_lista = "";
            if ($requisicion->lista_requisitos != '' && $requisicion->lista_requisitos != null) {
                foreach ($requisicion->lista_requisitos as $key => $requisito) {
                    $requisitos_lista = $requisitos_lista . "-$requisito" . "lineBreak";
                }
                $document->setValue('requisitos_lista', htmlspecialchars($requisitos_lista));
            }
            else {
                $document->setValue('requisitos_lista', htmlspecialchars(''));
            }
        }

        $document->cloneRow('no_partida', $requisicion->partidas->count());
        foreach ($requisicion->partidas as $key => $partida) {
             $value = $key + 1;
             if ($requisicion->anio == '2017') {
                $document->setValue("clave#$value", htmlspecialchars($partida->clave));
                if (!$req_sin_cantidad_max) {
                    $document->setValue("cantidad_maxima#$value", htmlspecialchars($partida->cantidad_maxima));
                }
            }
             $document->setValue("no_partida#$value", htmlspecialchars($value));
             $document->setValue("cantidad#$value", htmlspecialchars($partida->cantidad_minima));
             $document->setValue("unidad_medida#$value", htmlspecialchars($partida->unidad_medida));
             $document->setValue("descripcion#$value", htmlspecialchars($partida->descripcion));
             $document->setValue("marca#$value", htmlspecialchars($partida->marca));
        }
        $this->download($document);
    }

    public function reportePedido($procedimiento, $ofertas, $numero_pedido)
    {
        $numero_partida = $numero_pedido;
        $requisicion = $procedimiento->requisiciones[0];
        $now = Carbon::now();
        $oferta_primera;
        foreach ($ofertas as $key => $oferta) {
            $oferta_primera = $oferta;
            break;
        }
        $ofertas_calculo = $procedimiento->ofertasGanadoras();
        $conta = $numero_pedido - 1;
        $numero_pedido = 0;
        if ($conta == 0) {
            $numero_pedido = 1;
        }
        else {
            foreach ($ofertas_calculo as $key => $oferta) {
                if ($key == 0) {
                    $numero_pedido++;
                }
                else{
                    if ($oferta->proveedor->nombre != $ofertas_calculo[$key-1]->proveedor->nombre) {
                        $numero_pedido++;
                    }
                    if ($conta == $key) {
                        break;
                    }
                }
            }
        }
        $document = new \PhpOffice\PhpWord\TemplateProcessor('pedido2017.docx');
        $document->setValue('proveedor', htmlspecialchars($oferta_primera->proveedor->nombre));
        $document->setValue('nombre_a_facturar', htmlspecialchars($procedimiento->requisiciones[0]->datos_facturacion));
        $document->setValue('direccion_proveedor', htmlspecialchars($oferta_primera->proveedor->direccion));
        $document->setValue('dependencia', htmlspecialchars($requisicion->dependencia->nombre));
        $document->setValue('lugar_entrega', htmlspecialchars($requisicion->lugar_entrega));
        $document->setValue('atendio', htmlspecialchars($requisicion->asesor));
        $document->setValue('telefono_dependencia', htmlspecialchars($requisicion->dependencia->lada . " - " . $requisicion->dependencia->telefono));
        $document->setValue('responsable_proveedor', htmlspecialchars($oferta_primera->proveedor->representante));
        $document->setValue('telefono_proveedor', htmlspecialchars($oferta_primera->proveedor->telefono));
        //AQUI FALTA
        $document->setValue('pedido_no', htmlspecialchars('1'));
        //AQUI FALTA
        $document->setValue('fecha_entrega', htmlspecialchars($requisicion->tiempo_entrega));
        $document->setValue('terminos_pago', htmlspecialchars($requisicion->condiciones_pago));
        $document->setValue('pedido', htmlspecialchars($requisicion->mes . "_" . $requisicion->consecutivo . "-" .  $numero_pedido . "-" . $requisicion->anio));
        $document->setValue('requisicion', htmlspecialchars($requisicion->mes . "_" . $requisicion->consecutivo . "-" . $requisicion->anio));
        $document->setValue('condiciones_entrega', htmlspecialchars($requisicion->lugar_entrega));
        $document->setValue('observaciones', htmlspecialchars($requisicion->observaciones));
        $document->setValue('partida_pre', htmlspecialchars($requisicion->partida_presupuestal));
        $document->setValue('partida_presupuestal_concepto', htmlspecialchars('Aqui va ir el concepto de la partida presupuestal'));
        $document->setValue('elaboro', htmlspecialchars($requisicion->procedimiento->analista->name));
        $document->setValue('anio', htmlspecialchars($now->year));
        $document->setValue('dia', htmlspecialchars($now->day));
        $document->setValue('mes', htmlspecialchars($now->month));
        $document->cloneRow('no_partida', $ofertas->count());
        $i = 0;
        
        foreach ($ofertas as $key => $oferta) {
            $value = $i + 1;
            $document->setValue("no_partida#$value", htmlspecialchars($oferta->numero));
            if (!is_numeric($oferta->partida->cantidad_ajuste)) {
                $document->setValue("cantidad#$value", htmlspecialchars($oferta->partida->cantidad_minima));
            } 
            else {
                $document->setValue("cantidad#$value", htmlspecialchars($oferta->partida->cantidad_ajuste));
            }
            $document->setValue("unidad_medida#$value", htmlspecialchars($oferta->partida->unidad_medida));
            $document->setValue("descripcion#$value", htmlspecialchars($oferta->partida->descripcion));
            $document->setValue("marca#$value", htmlspecialchars($oferta->marca));
            $document->setValue("precio#$value", htmlspecialchars("$" . number_format($oferta->precio_unitario, 2)));
            $document->setValue("importe#$value", htmlspecialchars("$" . number_format($oferta->importe_sin_iva, 2)));
            $i++;
            $numero_partida++;
        }

        $document->setValue('subtotal', htmlspecialchars("$" . number_format($ofertas->sum('importe_sin_iva'), 2)));
        $iva = $ofertas->sum('importe_con_iva') - $ofertas->sum('importe_sin_iva');
        $document->setValue('iva', htmlspecialchars("$" . number_format($iva, 2)));
        $document->setValue('total', htmlspecialchars("$" . number_format($ofertas->sum('importe_con_iva'), 2)));

        $letras = new NumerosLetras;
        $importe_letras = $ofertas->sum('importe_con_iva');
        $importe_letras = number_format($importe_letras, 2);
        $importe_letras = str_replace(',', '', $importe_letras);
        $importe_letras = explode(".", $importe_letras);
        if (sizeof($importe_letras) == 1) {
            $importe_letras = $letras->convertNumber($importe_letras[0]);
        }
        else {
            $importe_letras = str_replace(',', '', $importe_letras);
            $primera_cantidad = $letras->convertNumber($importe_letras[0]);
            $segunda_cantidad = $letras->convertNumber($importe_letras[1]);
        }
        $document->setValue('importe_letra', htmlspecialchars("(" . $primera_cantidad . "PESOS $importe_letras[1]/100 M.N.)"));
        $this->download($document);
    }

    public function createCotizacion($ofertas, $invitacion, $tipoCotizacion = 0)
    {
        $now = Carbon::now();
        $procedimiento = $invitacion->procedimiento;
        $requisicion = $procedimiento->requisiciones[0];
        $document = new \PhpOffice\PhpWord\TemplateProcessor('invitacionEnvia.docx');
        $document->setValue('unidad_responsable', htmlspecialchars($requisicion->dependencia->nombre));
        $document->setValue('domicilio', htmlspecialchars($requisicion->dependencia->calle . " " . $requisicion->dependencia->numero_exterior . "-" . $requisicion->dependencia->numero_interior . ". " . $requisicion->dependencia->colonia));
        $document->setValue('anio', htmlspecialchars($now->year));
        $document->setValue('dia', htmlspecialchars($now->day));
        $document->setValue('mes', htmlspecialchars($now->month));
        $document->setValue('contratante', htmlspecialchars($requisicion->dependencia->nombre));
        $document->setValue('descripcion', htmlspecialchars($requisicion->descripcion));
        $document->setValue('tiempo_entrega', htmlspecialchars($requisicion->tiempo_entrega));
        $document->setValue('garantia', htmlspecialchars($requisicion->garantia));
        $document->setValue('numero_procedimiento', htmlspecialchars($requisicion->mes . "_" . $requisicion->consecutivo . "-" .  $requisicion->anio));
        $document->setValue('nombre_proveedor', htmlspecialchars($invitacion->proveedor->nombre));
        $document->setValue('representante', htmlspecialchars($invitacion->proveedor->representante));
        $document->setValue('elaboro', htmlspecialchars($requisicion->usuario->name));
        $document->setValue('autorizo', htmlspecialchars($requisicion->dependencia->autoriza));
        $document->setValue('visto_bueno', htmlspecialchars($requisicion->dependencia->valida));
        $document->setValue('requisitos_tecnicos', htmlspecialchars($requisicion->requisitos_tecnicos));
        $document->setValue('requisitos_informativos', htmlspecialchars($requisicion->requisitos_informativos));
        $document->setValue('requisitos_economicos', htmlspecialchars($requisicion->requisitos_economicos));
        $document->setValue('observaciones', htmlspecialchars($requisicion->observaciones));
        $document->setValue('lugar_entrega', htmlspecialchars($requisicion->lugar_entrega));
        $document->setValue('condiciones_pago', htmlspecialchars($requisicion->condiciones_pago));
        $document->setValue('datos_facturacion', htmlspecialchars($requisicion->datos_facturacion));
        $document->cloneRow('no_partida', $requisicion->partidas->count());
        $document->setValue('elaboro', htmlspecialchars($requisicion->usuario->name));
        $document->setValue('autorizo', htmlspecialchars($requisicion->dependencia->autoriza));
        $document->setValue('cargo_autoriza', htmlspecialchars($requisicion->dependencia->cargo_autoriza));
        $document->setValue('visto_bueno', htmlspecialchars($requisicion->dependencia->valida));
        $document->setValue('cargo_valida', htmlspecialchars($requisicion->dependencia->cargo_valida));

        $subtotal = 0;
        $total = 0;
        if ($tipoCotizacion == 0) {
            foreach ($invitacion->procedimiento->requisiciones[0]->partidas as $key => $partida) {
                $value = $key + 1;
                $subtotal = $subtotal + $ofertas->{$partida->id . '_importe_sin_iva'};
                $total = $total + $ofertas->{$partida->id . '_monto_total'};
                $document->setValue("no_partida#$value", htmlspecialchars($value));
                $document->setValue("cantidad#$value", htmlspecialchars($ofertas->{$partida->id . '_cantidad'}));
                $document->setValue("unidad_medida#$value", htmlspecialchars($partida->unidad_medida));
                $document->setValue("descripcion_partida#$value", htmlspecialchars($partida->descripcion));
                $document->setValue("clave#$value", htmlspecialchars($ofertas->{$partida->id . '_clave'}));
                $document->setValue("marca#$value", htmlspecialchars($ofertas->{$partida->id . '_marca'}));
                $document->setValue("precio_unitario#$value", htmlspecialchars('$' . $ofertas->{$partida->id . '_precio_unitario'}));
                $document->setValue("importe#$value", htmlspecialchars('$' . $ofertas->{$partida->id . '_importe_sin_iva'}));
                if ($key == $requisicion->partidas->count() - 1) {
                    $iva = $total - $subtotal;
                    $document->setValue("subtotal", number_format($subtotal, 2));
                    $document->setValue("iva_total", number_format($iva, 2));
                    $document->setValue("montos", number_format($total, 2));
                }
            }
        }
        else {
            foreach ($invitacion->procedimiento->requisiciones[0]->partidas as $key => $partida) {
                $oferta = $ofertas->where('partida_id', $partida->id)->first();
                $value = $key + 1;
                $subtotal = $subtotal + $oferta->importe_sin_iva;
                $total = $total + $oferta->monto_total;
                
                $document->setValue("no_partida#$value", htmlspecialchars($value));
                $document->setValue("cantidad#$value", htmlspecialchars($oferta->cantidad));
                $document->setValue("unidad_medida#$value", htmlspecialchars($partida->unidad_medida));
                $document->setValue("descripcion_partida#$value", htmlspecialchars($partida->descripcion));
                $document->setValue("marca#$value", htmlspecialchars($oferta->marca));
                $document->setValue("precio_unitario#$value", htmlspecialchars('$' . $oferta->precio_unitario));
                $document->setValue("importe#$value", htmlspecialchars('$' . $oferta->importe_sin_iva));
                if ($key == $requisicion->partidas->count() - 1) {
                    $iva = $total - $subtotal;
                    $document->setValue("subtotal", number_format($subtotal, 2));
                    $document->setValue("iva_total", number_format($iva, 2));
                    $document->setValue("montos", number_format($total, 2));
                }
            }
        }

        $this->download($document);
    }

    public function createInvitacion($procedimiento)
    {
        $now = Carbon::now();
        $requisicion = $procedimiento->requisiciones[0];
        $document = $requisicion->anio == '2017' ? new \PhpOffice\PhpWord\TemplateProcessor('inv2017.docx') : new \PhpOffice\PhpWord\TemplateProcessor('inv.docx');
        $document->setValue('unidad_responsable', htmlspecialchars($requisicion->dependencia->nombre));
        $document->setValue('domicilio', htmlspecialchars($requisicion->dependencia->calle . " " . $requisicion->dependencia->numero_exterior . "-" . $requisicion->dependencia->numero_interior . ". " . $requisicion->dependencia->colonia));
        $document->setValue('anio', htmlspecialchars($now->year));
        $document->setValue('dia', htmlspecialchars($now->day));
        $document->setValue('mes', htmlspecialchars($now->month));
        $document->setValue('contratante', htmlspecialchars($requisicion->dependencia->nombre));
        $document->setValue('descripcion', htmlspecialchars($requisicion->descripcion));
        $document->setValue('tiempo_entrega', htmlspecialchars($requisicion->tiempo_entrega));
        $document->setValue('garantia', htmlspecialchars($requisicion->garantia));
        $document->setValue('numero_procedimiento', htmlspecialchars($requisicion->mes . "_" . $requisicion->consecutivo . "-" .  $requisicion->anio));
        $document->setValue('elaboro', htmlspecialchars($requisicion->usuario->name));
        $document->setValue('autorizo', htmlspecialchars($requisicion->dependencia->autoriza));
        $document->setValue('visto_bueno', htmlspecialchars($requisicion->dependencia->valida));
        $document->setValue('requisitos_tecnicos', htmlspecialchars($requisicion->requisitos_tecnicos));
        $document->setValue('requisitos_informativos', htmlspecialchars($requisicion->requisitos_informativos));
        $document->setValue('requisitos_economicos', htmlspecialchars($requisicion->requisitos_economicos));
        $document->setValue('observaciones', htmlspecialchars($requisicion->observaciones));
        $document->setValue('lugar_entrega', htmlspecialchars($requisicion->lugar_entrega));
        $document->setValue('condiciones_pago', htmlspecialchars($requisicion->condiciones_pago));
        $document->setValue('datos_facturacion', htmlspecialchars($requisicion->datos_facturacion));
        $document->cloneRow('no_partida', $requisicion->partidas->count());
        $document->setValue('elaboro', htmlspecialchars($requisicion->usuario->name));
        $document->setValue('autorizo', htmlspecialchars($requisicion->dependencia->autoriza));
        $document->setValue('cargo_autoriza', htmlspecialchars($requisicion->dependencia->cargo_autoriza));
        $document->setValue('visto_bueno', htmlspecialchars($requisicion->dependencia->valida));
        $document->setValue('cargo_valida', htmlspecialchars($requisicion->dependencia->cargo_valida));
        $requisitos_lista = '';
        if ($requisicion->lista_requisitos != '' && $requisicion->lista_requisitos != null) {
            foreach ($requisicion->lista_requisitos as $key => $requisito) {
                $requisitos_lista = $requisitos_lista . "-$requisito" . "lineBreak";
            }
            $document->setValue('requisitos_lista', htmlspecialchars($requisitos_lista));
        }
        else {
            $document->setValue('requisitos_lista', htmlspecialchars(''));
        }

        foreach ($requisicion->partidas as $key => $partida) {
            $value = $key + 1;
            $document->setValue("no_partida#$value", htmlspecialchars($value));
            $document->setValue("cantidad#$value", htmlspecialchars($partida->cantidad_minima));
            $document->setValue("unidad_medida#$value", htmlspecialchars($partida->unidad_medida));
            $document->setValue("descripcion_partida#$value", htmlspecialchars($partida->descripcion));
            if ($requisicion->anio == '2017') {
                $document->setValue("modelo#$value", htmlspecialchars($partida->clave));
            }
            $document->setValue("marca#$value", htmlspecialchars($partida->marca));
            $document->setValue("precio_unitario#$value", htmlspecialchars(""));
            $document->setValue("importe#$value", htmlspecialchars(""));
        }

        $this->download($document);
    }

    public function listaInvitaciones($invitaciones)
    {
        $now = Carbon::now();
        $procedimiento = $invitaciones[0]->procedimiento;
        $requisicion = $procedimiento->requisiciones[0];
        $document = new \PhpOffice\PhpWord\TemplateProcessor('invitaciones.docx');
        $document->setValue('unidad_responsable', htmlspecialchars($requisicion->dependencia->nombre));
        $document->setValue('domicilio', htmlspecialchars($requisicion->dependencia->calle . " " . $requisicion->dependencia->numero_exterior . "-" . $requisicion->dependencia->numero_interior . ". " . $requisicion->dependencia->colonia));
        $document->setValue('anio', htmlspecialchars($now->year));
        $document->setValue('dia', htmlspecialchars($now->day));
        $document->setValue('mes', htmlspecialchars($now->month));
        $document->setValue('contratante', htmlspecialchars($requisicion->dependencia->nombre));
        $document->setValue('descripcion_partida', htmlspecialchars($requisicion->descripcion));
        $document->setValue('descripcion', htmlspecialchars($requisicion->descripcion));
        $document->setValue('tiempo_entrega', htmlspecialchars($requisicion->tiempo_entrega));
        $document->setValue('garantia', htmlspecialchars($requisicion->garantia));
        $document->setValue('numero_procedimiento', htmlspecialchars($requisicion->mes . "_" . $requisicion->consecutivo . "-" .  $requisicion->anio));

        $document->cloneRow('numero', $invitaciones->count());

        foreach ($invitaciones as $key => $invitacion) {
            $value = $key + 1;
            $document->setValue("numero#$value", htmlspecialchars($value));
            $document->setValue("nombre#$value", htmlspecialchars($invitacion->proveedor->nombre));
            $document->setValue("actividad#$value", htmlspecialchars($invitacion->proveedor->actividad));
            $document->setValue("rfc#$value", htmlspecialchars($invitacion->proveedor->rfc));
            $document->setValue("email#$value", htmlspecialchars($invitacion->proveedor->email));
            $document->setValue("telefono#$value", htmlspecialchars($invitacion->proveedor->telefono));
            $document->setValue("representante#$value", htmlspecialchars($invitacion->proveedor->representante));
            if ($invitacion->servidor_envia_mail) {
                $document->setValue("invitacion#$value", htmlspecialchars("Enviada"));
            }
            else {
                $document->setValue("invitacion#$value", htmlspecialchars("No enviada"));
            }
        }

        $this->download($document);
    }

    public function partidasProc($procedimiento, $ofertas)
    {
        $ofertas = $ofertas->lists('partida_id');
        $partidas_regresar = "";
        foreach ($procedimiento->requisiciones[0]->partidas as $key => $partida) {
            $value = $key + 1;
            if (in_array($partida->id, $ofertas)) {
                $partidas_regresar = $partidas_regresar . "$value, ";
            }
        }
        return rtrim($partidas_regresar, ", ");
    }

    public function dictamen_tecnico($procedimiento)
    {
        $now = Carbon::now();
        $requisicion = $procedimiento->requisiciones[0];
        $document = new \PhpOffice\PhpWord\TemplateProcessor('dictamen.docx');
        $document->setValue('codigo', htmlspecialchars($requisicion->mes . "_" . $requisicion->consecutivo));
        $document->setValue('anio', htmlspecialchars($now->year));
        $document->setValue('dia', htmlspecialchars($now->day));
        $document->setValue('mes', htmlspecialchars($now->month));
        $document->setValue('unidad_responsable', htmlspecialchars($requisicion->dependencia->nombre));
        $document->setValue('domicilio', htmlspecialchars($requisicion->dependencia->calle . " " . $requisicion->dependencia->numero_exterior . "-" . $requisicion->dependencia->numero_interior . ". " . $requisicion->dependencia->colonia));
        $document->setValue('nombre', htmlspecialchars($requisicion->dependencia->cargo_titular));
        $document->setValue('cargo', htmlspecialchars($requisicion->dependencia->cargo_titular));
        $document->setValue('origen_recursos', htmlspecialchars($requisicion->origenRecursos($requisicion->origen_recursos)));
        $document->setValue('monto', htmlspecialchars($requisicion->dependencia->presupuesto));
        // Table with a spanned cell
        $document->cloneRow('proveedor', $procedimiento->proveedores->count());
        foreach ($procedimiento->proveedores as $key => $proveedor) {
            $value = $key + 1;
            $document->setValue("proveedor#$value", htmlspecialchars($proveedor->nombre));

            $ofertas_aceptadas = $procedimiento->ofertas->where('proveedor_id', $proveedor->id)->where('status', 1);
            $ofertas_no_cotiza = $procedimiento->ofertas->where('proveedor_id', $proveedor->id)->where('status', 5);
            $ofertas_no_cumple = $procedimiento->ofertas->where('proveedor_id', $proveedor->id)->where('status', 2);

            $document->setValue("p_a#$value", htmlspecialchars($ofertas_aceptadas->count()));
            $document->setValue("p_c#$value", htmlspecialchars($ofertas_no_cotiza->count()));
            $document->setValue("p_u#$value", htmlspecialchars($ofertas_no_cumple->count()));

            $document->setValue("partidas_aceptadas#$value", htmlspecialchars($this->partidasProc($procedimiento, $ofertas_aceptadas)));
            $document->setValue("partidas_no_cotiza#$value", htmlspecialchars($this->partidasProc($procedimiento, $ofertas_no_cotiza)));
            $document->setValue("partidas_no_cumple#$value", htmlspecialchars($this->partidasProc($procedimiento, $ofertas_no_cumple)));
        }
        $this->download($document);
    }
}