<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SIMA 2.0</title>
	<link href="/css/app.css" rel="stylesheet">
	<meta name="google-site-verification" content="_K2lrUdI8pCClJtVvupYQtOBdwTnP2a6sh5WC6mUd2g" />
	@yield('styles')
	<!-- Fonts -->
	<!--<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>-->

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<div id="wrap">
		<div class="container-fluid">
			{!! Html::image('images/logo_nuevo.png' , 'Secretaria de Salud', array('width' => '150px' ,'class' => 'img-responsive inline-block')) !!}
			<h1 class="nav-title">GOBIERNO DEL ESTADO DE TLAXCALA</h1>
			{!! Html::image('images/siaa.png' , 'Secretaria de Salud', array('width' => '150px' ,'class' => 'img-responsive pull-right inline-block')) !!}
		</div>
		<nav class="navbar navbar-default navbar-siaa">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						@if (!Auth::guest() && Auth::user()->isAManager())
							<li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Programa Anual <i class="fa fa-file"></i><span class="caret"></span></a>
					          <ul class="dropdown-menu" role="menu">
					            <li><a href="/programa_anual">Listado</a></li>
					            <li><a href="/programa_anual/create">Crear programa anual</a></li>
					          </ul>
					        </li>
							<li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Requisiciones <i class="fa fa-file"></i><span class="caret"></span></a>
					          <ul class="dropdown-menu" role="menu">
					            <li><a href="/requisiciones">Listado</a></li>
					            @if(Auth::user()->isAMonitor() || Auth::user()->isAManager())
					            <li><a href="/requisiciones/create">Crear requisición</a></li>
					            @endif
					            
					          </ul>
					        </li>
					        <li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dependencias <i class="fa fa-building-o"></i><span class="caret"></span></a>
					          <ul class="dropdown-menu" role="menu">
					            <li><a href="/dependencias">Listado</a></li>
					            <li><a href="/dependencias/create">Crear dependencia</a></li>
					          </ul>
					        </li>
				        
							<li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Usuarios <i class="fa fa-user"></i><span class="caret"></span></a>
					          <ul class="dropdown-menu" role="menu">
					            <li><a href="/usuarios">Listado</a></li>
					            <li><a href="/usuarios/create">Crear usuario</a></li>
					          </ul>
					        </li>

					        <li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Procedimientos <i class="fa fa-book"></i><span class="caret"></span></a>
					          <ul class="dropdown-menu" role="menu">
					          	<li><a href="/usuarios_procedimientos">Usuarios Procedimientos</a></li>
					            <li><a href="/procedimientos">Listado</a></li>
					            <li><a href="/procedimientos/create">Crear procedimiento</a></li>
					            <li><a href="/procedimientos/create">Dictamen Técnico</a></li>
					          </ul>
					        </li>
					        <li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Proveedores <i class="fa fa-truck"></i><span class="caret"></span></a>
					          <ul class="dropdown-menu" role="menu">
					            <li><a href="/proveedores">Listado</a></li>
					            <li><a href="/proveedores/create">Crear proveedor</a></li>
					          </ul>
					        </li>
					        <li><a href="/reportes_procedimientos">Reportes <i class="fa fa-flag" aria-hidden="true"></i></a></li>
						@endif

						@if (!Auth::guest() && Auth::user()->isAMonitor())
							<li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Programa Anual <i class="fa fa-file"></i><span class="caret"></span></a>
					          <ul class="dropdown-menu" role="menu">
					            <li><a href="/programa_anual">Listado</a></li>
					            <li><a href="/programa_anual/create">Crear programa anual</a></li>
					          </ul>
					        </li>
							<li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Requisiciones <i class="fa fa-file"></i><span class="caret"></span></a>
					          <ul class="dropdown-menu" role="menu">
					            <li><a href="/requisiciones">Listado</a></li>
					            <li><a href="/requisiciones/create">Crear requisición</a></li>
					          </ul>
					        </li>
					        <li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dependencias <i class="fa fa-building-o"></i><span class="caret"></span></a>
					          <ul class="dropdown-menu" role="menu">
					            <li><a href="/dependencias">Listado</a></li>
					            <li><a href="/dependencias/create">Crear dependencia</a></li>
					          </ul>
					        </li>
					        <li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Procedimientos <i class="fa fa-book"></i><span class="caret"></span></a>
					          <ul class="dropdown-menu" role="menu">
					          	<li><a href="/usuarios_procedimientos">Usuarios Procedimientos</a></li>
					            <li><a href="/procedimientos">Listado</a></li>
					            <li><a href="/procedimientos/create">Crear procedimiento</a></li>
					            <li><a href="/procedimientos/create">Dictamen Técnico</a></li>
					          </ul>
					        </li>
					        <li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Proveedores <i class="fa fa-truck"></i><span class="caret"></span></a>
					          <ul class="dropdown-menu" role="menu">
					            <li><a href="/proveedores">Listado</a></li>
					            <li><a href="/proveedores/create">Crear proveedor</a></li>
					          </ul>
					        </li>
					        <li><a href="/reportes_procedimientos">Reportes <i class="fa fa-flag" aria-hidden="true"></i></a></li>
					        <li><a href="/reportes_procedimientos">Reportes <i class="fa fa-flag" aria-hidden="true"></i></a></li>
						@endif

						@if (!Auth::guest())
							@if(Auth::user()->isAnalista() || Auth::user()->isAnalistaUnidad())
								<li class="dropdown">
						          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Programa Anual <i class="fa fa-file"></i><span class="caret"></span></a>
						          <ul class="dropdown-menu" role="menu">
						            <li><a href="/programa_anual">Listado</a></li>
						            <!--
						            <li><a href="/programa_anual/create">Crear programa anual</a></li>
						            -->
						          </ul>
						        </li>
								<li class="dropdown">
						          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Requisiciones <i class="fa fa-file"></i><span class="caret"></span></a>
						          <ul class="dropdown-menu" role="menu">
						            <li><a href="/requisiciones">Listado</a></li>
						            <li><a href="/requisiciones/create">Crear requisición</a></li>
						          </ul>
						        </li>
							@endif
						@endif
					</ul>

					<ul class="nav navbar-nav navbar-right">
						@if (Auth::guest())
							<li><a href="/auth/login">Login</a></li>
							<!--<li><a href="/auth/register">Register</a></li>-->
						@else
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<!--<li><a href="">Configuración <i class="fa fa-cog icon-nav pull-right"></i></a></li>-->
									<li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
								</ul>
							</li>
						@endif
					</ul>
				</div>
			</div>
		</nav>
		<br>
		<div class="container">
			@include('flash::message')
			@yield('content')
		</div>
		@yield('content2')
	</div>
	<br>
	<div id="footer">
      <div class="container">
		<p style="padding-top: 20px; text-align: center">Copyright © 2015 - SIAA 2.0</p>
      </div>
    </div>
	
	<!-- Scripts -->
	<script src="{{ asset('/js/vendor.js') }}"></script>
	@yield('scripts')
</body>
</html>
