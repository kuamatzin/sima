<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <style>
        body {
            background-color: #eef1f2;
        }

        p {
            font-size: 17px;
            color: #999999;
        }
        .image {
            float:left;
        }
        .inline-block{
          display:inline-block
        }
    </style>
    <title>Document</title>
</head>
<body>
    <div id="wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    {!! Html::image('http://tlaxcala.reqsiaa.com/images/tlaxcala_nuevo.png' , 'Secretaria de Salud', array('class' => 'img-responsive')) !!}
                </div>
                <div class="col-md-6">
                    <h3 class="nav-title text-center">GOBIERNO DEL ESTADO DE TLAXCALA <br> OFICIALÍA MAYOR DE GOBIERNO <br> DIRECCIÓN  DE RECURSOS MATERIALES, SERVICIOS Y ADQUISICIONES</h3>
                </div>
                <div class="col-md-3">
                    {!! Html::image('http://tlaxcala.reqsiaa.com/images/oficialia.png' , 'Secretaria de Salud', array('class' => 'img-responsive pull-right inline-block')) !!}
                </div>
            </div>
        </div>
        <div class="container">
            <br><br>
            <p>
                BUEN DIA <br>
                SR. PROVEEDOR DE GOBIERNO DEL ESTADO <br>
                ENVÍO INVITACIÓN A COTIZAR CON NUMERO {{$codificacion}} AD REFERENTE A {{$descripcion}}. FAVOR DE CAPTURAR SU PROPUESTA ECONÓMICA EN EL ICONO QUE SE LOCALIZA AL FINAL DEL TEXTO, ASÍ COMO ADJUNTAR SU PROPUESTA EN HOJA MEMBRETADA Y FIRMADA, APEGÁNDOSE A LAS CARACTERÍSTICAS DE LO SOLICITADO EN LA INVITACIÓN.
            </p>
            <br>
            <p class="text-center">
                <strong>
                    NOTA. FAVOR DE COTIZAR TODOS LOS PRODUCTOS SOLICITADOS
                </strong>
            </p>
            <br>
            <a href="{{$_ENV['SET_DOMAIN']}}/cotizacion/{{$url}}">
                <button type="button" class="btn btn-success center-block">CAPTURAR PROPUESTA</button>
            </a>
            <br>
            <p class="text-center">LIC. JOSÉ MANUEL GARCÍA VALENCIA</p>
            <p class="text-center">DIRECTOR DE RECURSOS MATERIALES, SERVICIOS Y ADQUISICIONES</p>
            <p class="text-center">PARA CUALQUIER DUDA COMUNICARSE AL DEPARTAMENTO DE ADQUISICIONES</p>
            <p class="text-center">
                LEONARDA GOMEZ BLANCO No. 60 ALTOS, ACXOTLA DEL RIO, TOTOLAC, TLAX. C.P. 90160
TELEFONOS 246 46 50 900- 46 5 29 60 EXT. 1811 Y 1812.
CORREO: (DE USUARIO COMPRADOR)
            </p>
        </div>
    </div>

    <div id="footer">
        
    </div>
    
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</body>
</html>