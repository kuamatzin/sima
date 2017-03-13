@if(Auth::user()->isAnalista())
<div class="form-group col-md-4">
    {!! Form::hidden('dependencia_id', Auth::user()->dependencia->id) !!}
</div>
@elseif(Auth::user()->isAnalistaUnidad())
<div class="form-group col-md-4">
    {!! Form::hidden('unidad_administrativa_id', Auth::user()->unidad_administrativa_id) !!}
</div>
@else
<div class="form-group col-md-4">
    {!! Form::label('dependencia_id', 'Dependencia') !!}
    {!! Form::select('dependencia_id', $dependencias, null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('dependencia_id') }}</small>
</div>
@endif
@if($edit)
<div class="form-group col-md-4">
    {!! Form::label('status', 'Status') !!}
    {!! Form::select('status', ['' => 'Selecciona', '1' => 'Previa', '2' => 'Definitiva', '3' => 'Cancelada'], $requisicion->getOriginal("status"), ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('status') }}</small>
</div>
<div class="form-group col-md-4">
    {!! Form::label('tipo_requisicion', 'Tipo de Requisición') !!}
    {!! Form::select('tipo_requisicion', ['' => 'Selecciona', '1' => 'Bien', '2' => 'Servicio'], $requisicion->getOriginal("tipo_requisicion"), ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('tipo_requisicion') }}</small>
</div>
@else
<div class="form-group col-md-4">
    {!! Form::label('status', 'Status') !!}
    {!! Form::select('status', ['' => 'Selecciona', '1' => 'Previa', '2' => 'Definitiva', '3' => 'Cancelada'], null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('status') }}</small>
</div>
<div class="form-group col-md-4">
    {!! Form::label('tipo_requisicion', 'Tipo de Requisición') !!}
    {!! Form::select('tipo_requisicion', ['' => 'Selecciona', '1' => 'Bien', '2' => 'Servicio'], null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('tipo_requisicion') }}</small>
</div>
@endif
<div class="form-group col-md-12">
    {!! Form::label('descripcion', 'Descripción') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'CONCEPTO DE ACUERDO AL CLASIFICADOR DE GASTO POR OBJETO VIGENTE
']) !!}
    <small class="text-danger">{{ $errors->first('descripcion') }}</small>
</div>
<div class="form-group col-md-4">
    {!! Form::label('partida_presupuestal', 'Partida Presupuestal') !!}
    {!! Form::text('partida_presupuestal', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('partida_presupuestal') }}</small>
</div>
<div class="form-group col-md-4">
    {!! Form::label('codificacion', 'Codificación') !!}
    {!! Form::text('codificacion', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('codificacion') }}</small>
</div>
@if($edit)
<div class="form-group col-md-4">
    {!! Form::label('presupuesto', 'Presupuesto') !!}
    {!! Form::text('presupuesto', $requisicion->getOriginal("presupuesto"), ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('presupuesto') }}</small>
</div>
@else
<div class="form-group col-md-4">
    {!! Form::label('presupuesto', 'Presupuesto') !!}
    {!! Form::text('presupuesto', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('presupuesto') }}</small>
</div>
@endif
<div class="row">
    <div class="form-group col-md-6">
        {!! Form::label('origen_recursos', 'Origen de recursos') !!}
        {!! Form::select('origen_recursos', ['' => 'Origen de recursos', '1' => 'Estatales', '2' => 'Propios', '3' => 'Federales'], null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('origen_recursos') }}</small>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('procedimiento_adjudicacion', 'Procedimiento de adjudicación') !!}
        {!! Form::select('procedimiento_adjudicacion', ['' => 'Procedimiento de adjudicación', '1' => 'Adjudicación Directa', '2' => 'Invitación a cuando menos tres', '3' => 'Licitación Pública'], null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('procedimiento_adjudicacion') }}</small>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-4">
        {!! Form::label('tiempo_entrega', 'Tiempo de entrega') !!}
        {!! Form::text('tiempo_entrega', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('tiempo_entrega') }}</small>
    </div>
    <div class="form-group col-md-4">
        {!! Form::label('lugar_entrega', 'Lugar de entrega') !!}
        {!! Form::text('lugar_entrega', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('lugar_entrega') }}</small>
    </div>
    <div class="form-group col-md-4 {{ $errors->has('dias_entrega_lunes_viernes') ? ' has-error' : '' }}">
        {!! Form::label('dias_entrega_lunes_viernes', 'Dias de entrega') !!}
        {!! Form::select('dias_entrega_lunes_viernes', ['Lunes-Viernes' => 'Lunes-Viernes', 'Otro' => 'Otro'], null, ['id' => 'dias_entrega_lunes_viernes', 'class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('dias_entrega_lunes_viernes') }}</small>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-8{{ $errors->has('dias_entrega_texto') ? ' has-error' : '' }}">
        {!! Form::label('dias_entrega_texto', 'Dias de entrega (En caso de haber seleccionado "Otro")') !!}
        {!! Form::text('dias_entrega_texto', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('dias_entrega_texto') }}</small>
    </div>
    <div class="form-group col-md-4{{ $errors->has('hora_entrega_inicial') ? ' has-error' : '' }}">
        {!! Form::label('hora_entrega_inicial', 'Horario de entrega') !!}
        <div class="row">
            <div class="col-md-5">
                {!! Form::text('hora_entrega_inicial', null, ['class' => 'form-control', 'placeholder' => '8 am']) !!}
                <small class="text-danger">{{ $errors->first('hora_entrega_inicial') }}</small>
            </div>
            <div class="col-md-2">
                <p>a</p>
            </div>
            <div class="col-md-5">
                {!! Form::text('hora_entrega_final', null, ['class' => 'form-control', 'placeholder' => '3 pm']) !!}
                <small class="text-danger">{{ $errors->first('hora_entrega_final') }}</small>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <div class="checkbox{{ $errors->has('instalacion') ? ' has-error' : '' }}">
            <label for="instalacion">
                {!! Form::checkbox('instalacion', '1', null, ['id' => 'instalacion']) !!} Incluye Instalación y puesta en funcionamiento al 100%
            </label>
        </div>
        <small class="text-danger">{{ $errors->first('instalacion') }}</small>
    </div>
    <div class="form-group col-md-6">
        <div class="checkbox{{ $errors->has('empacado') ? ' has-error' : '' }}">
            <label for="empacado">
                {!! Form::checkbox('empacado', '1', null, ['id' => 'empacado']) !!} Entregar empacado de acuerdo a la descripción de cada partida
            </label>
        </div>
        <small class="text-danger">{{ $errors->first('empacado') }}</small>
    </div>
</div>
<hr>
<div class="row">
    <div class="form-group col-md-4{{ $errors->has('garantia') ? ' has-error' : '' }}">
        {!! Form::label('garantia', 'Garantía') !!}
        {!! Form::select('garantia', ['3 meses' => '3 meses', '6 meses' => '6 meses', '12 meses' => '12 meses', '24 meses' => '24 meses', '36 meses' => '36 meses', 'Durante el evento' => 'Durante el evento', 'Durante el contrato' => 'Durante el contrato', 'Durante la entrega' => 'Durante la entrega'], null, ['id' => 'garantia', 'class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('garantia') }}</small>
    </div>
    <div class="form-group col-md-4">
        {!! Form::label('asesor', 'Asesor') !!}
        {!! Form::text('asesor', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('asesor') }}</small>
    </div>
    <div class="form-group col-md-4">
        {!! Form::label('cargo_asesor', 'Cargo del asesor') !!}
        {!! Form::text('cargo_asesor', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('cargo_asesor') }}</small>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-4">
        {!! Form::label('email_asesor', 'Email') !!}
        {!! Form::text('email_asesor', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('email_asesor') }}</small>
    </div>
    <div class="form-group col-md-4 {{ $errors->has('dias_pago') ? ' has-error' : '' }}">
        {!! Form::label('dias_pago', 'Dias de pago') !!}
        {!! Form::select('dias_pago', ['15 días' => 'Crédito 15 dias', '30 días' => 'Crédito 30 dias', '45 días' => 'Crédito 45 dias', '60 días' => 'Crédito 60 dias', '90 días' => 'Crédito 90 dias', 'Contra Entrega' => 'Contra Entrega'], null, ['id' => 'dias_pago', 'class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('dias_pago') }}</small>
    </div>
    <div class="form-group col-md-4 {{ $errors->has('anticipo') ? ' has-error' : '' }}">
        {!! Form::label('anticipo', 'Anticipo (Dejar vacio si no hay anticipo)') !!}
        {!! Form::text('anticipo', null, ['class' => 'form-control', 'placeholder' => 'Por ejemplo: 50%']) !!}
        <small class="text-danger">{{ $errors->first('anticipo') }}</small>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        {!! Form::label('observaciones', 'Observaciones') !!}
        {!! Form::text('observaciones', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('observaciones') }}</small>
    </div>
</div>
<hr>
<p><strong>Requsitos Técnicos</strong></p>
<div class="form-group col-md-12">
    <div class="checkbox{{ $errors->has('lista_requisitos[1]') ? ' has-error' : '' }}">
        <label for="lista_requisitos[1]">
            {!! Form::checkbox('lista_requisitos[1]', 'PRESENTAR MUESTRA FÍSICA DE CADA PARTIDA.', isset($requisicion) ? is_array($requisicion->lista_requisitos) ? array_search('PRESENTAR MUESTRA FÍSICA DE CADA PARTIDA.', $requisicion->lista_requisitos) > 0 ? true : false : false : false, ['id' => 'lista_requisitos[1]']) !!} PRESENTAR MUESTRA FÍSICA DE CADA PARTIDA.
        </label>
    </div>
    <small class="text-danger">{{ $errors->first('lista_requisitos[1]') }}</small>
</div>
<div class="form-group col-md-12">
    <div class="checkbox{{ $errors->has('lista_requisitos[2]') ? ' has-error' : '' }}">
        <label for="lista_requisitos[2]">
            {!! Form::checkbox('lista_requisitos[2]', 'CARTA BAJO PROTESTA DE DECIR VERDAD EN LA QUE EL LICITANTE SE COMPROMETE, EN CASO DE RESULTAR ADJUDICADO A GARANTIZAR LOS BIENES EN CALIDAD Y VICIOS OCULTOS', isset($requisicion) ? is_array($requisicion->lista_requisitos) ? array_search('CARTA BAJO PROTESTA DE DECIR VERDAD EN LA QUE EL LICITANTE SE COMPROMETE, EN CASO DE RESULTAR ADJUDICADO A GARANTIZAR LOS BIENES EN CALIDAD Y VICIOS OCULTOS', $requisicion->lista_requisitos) > 0 ? true : false : false : false, ['id' => 'lista_requisitos[2]']) !!} CARTA BAJO PROTESTA DE DECIR VERDAD EN LA QUE EL LICITANTE SE COMPROMETE, EN CASO DE RESULTAR ADJUDICADO A GARANTIZAR LOS BIENES EN CALIDAD Y VICIOS OCULTOS
        </label>
    </div>
    <small class="text-danger">{{ $errors->first('lista_requisitos[2]') }}</small>
</div>
<div class="form-group col-md-12">
    <div class="checkbox{{ $errors->has('lista_requisitos[3]') ? ' has-error' : '' }}">
        <label for="lista_requisitos[3]">
            {!! Form::checkbox('lista_requisitos[3]', 'FOLLETOS O CATÁLOGOS DE CADA PARTIDA, ORIGINALES DEDIDAMENTE IDENTIFICADAS, CON CARACTERÍSTICAS DEL BIEN LAS CUALES DEBERÁN COINCIDIR CON SU PROPUESTA TÉCNICA, MARCA, MODELO Y FOTOGRAFÍA DEL BIEN.', isset($requisicion) ? is_array($requisicion->lista_requisitos) ? array_search('FOLLETOS O CATÁLOGOS DE CADA PARTIDA, ORIGINALES DEDIDAMENTE IDENTIFICADAS, CON CARACTERÍSTICAS DEL BIEN LAS CUALES DEBERÁN COINCIDIR CON SU PROPUESTA TÉCNICA, MARCA, MODELO Y FOTOGRAFÍA DEL BIEN.', $requisicion->lista_requisitos) > 0 ? true : false : false : false, ['id' => 'lista_requisitos[3]']) !!} FOLLETOS O CATÁLOGOS DE CADA PARTIDA, ORIGINALES DEDIDAMENTE IDENTIFICADAS, CON CARACTERÍSTICAS DEL BIEN LAS CUALES DEBERÁN COINCIDIR CON SU PROPUESTA TÉCNICA, MARCA, MODELO Y FOTOGRAFÍA DEL BIEN.
        </label>
    </div>
    <small class="text-danger">{{ $errors->first('lista_requisitos[3]') }}</small>
</div>
<div class="form-group col-md-12">
    <div class="checkbox{{ $errors->has('lista_requisitos[4]') ? ' has-error' : '' }}">
        <label for="lista_requisitos[4]">
            {!! Form::checkbox('lista_requisitos[4]', 'AVISO DE FUNCIONAMIENTO O LICENCIA SANITARIA.', isset($requisicion) ? is_array($requisicion->lista_requisitos) ? array_search('AVISO DE FUNCIONAMIENTO O LICENCIA SANITARIA.', $requisicion->lista_requisitos) > 0 ? true : false : false : false, ['id' => 'lista_requisitos[4]']) !!} AVISO DE FUNCIONAMIENTO O LICENCIA SANITARIA.
        </label>
    </div>
    <small class="text-danger">{{ $errors->first('lista_requisitos[4]') }}</small>
</div>
<div class="form-group col-md-12">
    <div class="checkbox{{ $errors->has('lista_requisitos[5]') ? ' has-error' : '' }}">
        <label for="lista_requisitos[5]">
            {!! Form::checkbox('lista_requisitos[5]', 'REGISTROS SANITARIOS DE CADA PARTIDA DEBIDAMENTE IDENTIFICADOS CON EL NÚMERO DE PARTIDA.', isset($requisicion) ? is_array($requisicion->lista_requisitos) ? array_search('REGISTROS SANITARIOS DE CADA PARTIDA DEBIDAMENTE IDENTIFICADOS CON EL NÚMERO DE PARTIDA.', $requisicion->lista_requisitos) > 0 ? true : false : false : false, ['id' => 'lista_requisitos[5]']) !!} REGISTROS SANITARIOS DE CADA PARTIDA DEBIDAMENTE IDENTIFICADOS CON EL NÚMERO DE PARTIDA.
        </label>
    </div>
    <small class="text-danger">{{ $errors->first('lista_requisitos[5]') }}</small>
</div>
<div class="form-group col-md-12">
    <div class="checkbox{{ $errors->has('lista_requisitos[6]') ? ' has-error' : '' }}">
        <label for="lista_requisitos[6]">
            {!! Form::checkbox('lista_requisitos[6]', 'OPINIÓN DE CUMPLIMIENTO POSITIVA EMITIDA POR EL SAT DEL MES ANTERIOR A LA COTIZACION.', isset($requisicion) ? is_array($requisicion->lista_requisitos) ? array_search('OPINIÓN DE CUMPLIMIENTO POSITIVA EMITIDA POR EL SAT DEL MES ANTERIOR A LA COTIZACION.', $requisicion->lista_requisitos) > 0 ? true : false : false : false, ['id' => 'lista_requisitos[6]']) !!} OPINIÓN DE CUMPLIMIENTO POSITIVA EMITIDA POR EL SAT DEL MES ANTERIOR A LA COTIZACION.
        </label>
    </div>
    <small class="text-danger">{{ $errors->first('lista_requisitos[6]') }}</small>
</div>
<div class="form-group col-md-12">
    <div class="checkbox{{ $errors->has('lista_requisitos[7]') ? ' has-error' : '' }}">
        <label for="lista_requisitos[7]">
            {!! Form::checkbox('lista_requisitos[7]', 'CERTIFICADOS DE CALIDAD ISO, FDE, ETC.', isset($requisicion) ? is_array($requisicion->lista_requisitos) ? array_search('CERTIFICADOS DE CALIDAD ISO, FDE, ETC.', $requisicion->lista_requisitos) > 0 ? true : false : false : false, ['id' => 'lista_requisitos[7]']) !!} CERTIFICADOS DE CALIDAD ISO, FDE, ETC.
        </label>
    </div>
    <small class="text-danger">{{ $errors->first('lista_requisitos[7]') }}</small>
</div>
<div class="form-group col-md-12">
    <div class="checkbox{{ $errors->has('lista_requisitos[8]') ? ' has-error' : '' }}">
        <label for="lista_requisitos[8]">
            {!! Form::checkbox('lista_requisitos[8]', 'CERTIFICADO DE CUMPLIENTO DE AL MENOS EL 30% DE COMPOSICIÓN DE FIBRAS SINTÉTICAS (MATERIAL DE MADERA).', isset($requisicion) ? is_array($requisicion->lista_requisitos) ? array_search('CERTIFICADO DE CUMPLIENTO DE AL MENOS EL 30% DE COMPOSICIÓN DE FIBRAS SINTÉTICAS (MATERIAL DE MADERA).', $requisicion->lista_requisitos) > 0 ? true : false : false : false, ['id' => 'lista_requisitos[8]']) !!} CERTIFICADO DE CUMPLIENTO DE AL MENOS EL 30% DE COMPOSICIÓN DE FIBRAS SINTÉTICAS (MATERIAL DE MADERA).
        </label>
    </div>
    <small class="text-danger">{{ $errors->first('lista_requisitos[8]') }}</small>
</div>
<hr>
<div class="form-group col-md-12">
    <div class="checkbox{{ $errors->has('lista_requisitos[9]') ? ' has-error' : '' }}">
        <label for="lista_requisitos[9]">
            {!! Form::checkbox('lista_requisitos[9]', 'CARTA DE APOYO DE FABRICANTE O DISTRIBUIDOR MAYORISTA.', isset($requisicion) ? is_array($requisicion->lista_requisitos) ? array_search('CARTA DE APOYO DE FABRICANTE O DISTRIBUIDOR MAYORISTA.', $requisicion->lista_requisitos) > 0 ? true : false : false : false, ['id' => 'lista_requisitos[9]']) !!} CARTA DE APOYO DE FABRICANTE O DISTRIBUIDOR MAYORISTA.
        </label>
    </div>
    <small class="text-danger">{{ $errors->first('lista_requisitos[9]') }}</small>
</div>
<div class="form-group col-md-12">
    {!! Form::label('requisitos_tecnicos', 'Requisitos técnicos (Otros)') !!}
    {!! Form::text('requisitos_tecnicos', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('requisitos_tecnicos') }}</small>
</div>
<div class="form-group col-md-12">
    {!! Form::label('requisitos_economicos', 'Requisitos económicos') !!}
    {!! Form::text('requisitos_economicos', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('requisitos_economicos') }}</small>
</div>
<div class="form-group col-md-12">
    {!! Form::label('requisitos_informativos', 'Requisitos informativos') !!}
    {!! Form::text('requisitos_informativos', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('requisitos_informativos') }}</small>
</div>
<div class="form-group col-md-6">
    <div class="checkbox{{ $errors->has('vigencia') ? ' has-error' : '' }}">
        <label for="vigencia">
            {!! Form::checkbox('vigencia', '1', null, ['id' => 'vigencia']) !!} Vigencia de contrato
        </label>
    </div>
    <small class="text-danger">{{ $errors->first('vigencia') }}</small>
</div>
<div class="form-group col-md-6 {{ $errors->has('vigencia_especificacion') ? ' has-error' : '' }}">
    {!! Form::label('vigencia_especificacion', 'Vigencia de contrato (Especificar solo en caso haber palomeado)') !!}
    {!! Form::text('vigencia_especificacion', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('vigencia_especificacion') }}</small>
</div>
<div class="form-group col-md-12">
    {!! Form::label('condiciones_pago', 'Condiciones de pago') !!}
    {!! Form::text('condiciones_pago', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('condiciones_pago') }}</small>
</div>
<div class="form-group col-md-12">
    {!! Form::label('datos_facturacion', 'Datos de facturación') !!}
    {!! Form::text('datos_facturacion', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('datos_facturacion') }}</small>
</div>
<div class="form-group col-md-12">
    <div class="checkbox">
        <label for="regularizar">
            {!! Form::checkbox('regularizar', null, null, ['id' => 'regularizar']) !!} Regularizar
        </label>
    </div>
    <small class="text-danger">{{ $errors->first('regularizar') }}</small>
</div>
<div class="form-group" style="display:none" id="reg">
    {!! Form::label('fecha_regularizacion', 'Publicar en') !!}
    {!! Form::input('datetime-local', 'fecha_regularizacion', date("Y-m-d"), ['class' => '', 'placeholder' => 'Publicado en']) !!}
    <small class="text-danger">{{ $errors->first('fecha_regularizacion') }}</small>
</div>
<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
</div>