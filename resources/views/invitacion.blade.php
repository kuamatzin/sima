<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cotización</title>
    <link href="/css/app.css" rel="stylesheet">

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
</head>
<body>
    <div id="wrap">
        <div class="container-fluid">
            {!! Html::image('images/logo_completo.png' , 'Secretaria de Salud', array('width' => '150px' ,'class' => 'img-responsive inline-block')) !!}
            <h1 class="nav-title">GOBIERNO DEL ESTADO DE TLAXCALA </h1>
            {!! Html::image('images/siaa.png' , 'Secretaria de Salud', array('width' => '110px' ,'class' => 'img-responsive pull-right inline-block')) !!}
        </div>
        <div class="container">
            @yield('content')
        </div>
    </div>

    <div id="footer">
        
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    @yield('scripts')
</body>
</html>