<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>    
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	<style>
		body{
			background: #0B4C5F;
		}
	</style>
</head>
<body>
    <div id="app">
		
		<nav class="navbar navbar-inverse navbar-static-top">
			<div class="container">
				<div class="navbar-header">

					<!-- Collapsed Hamburger -->
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>

					<!-- Branding Image -->
					<a class="navbar-brand" href="{{ url('/') }}">
						{{ config('app.name', 'Laravel') }}
					</a>					
				</div>

				<div class="collapse navbar-collapse" id="app-navbar-collapse">
					<!-- Left Side Of Navbar -->
					<ul class="nav navbar-nav">
						&nbsp;
					</ul>

					<!-- Right Side Of Navbar -->
					<ul class="nav navbar-nav navbar-right">
						<!-- Authentication Links -->
						@guest
							<li><a href="{{ route('login') }}">Login</a></li>
							<li><a href="{{ route('register') }}">Register</a></li>
						@else
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
									{{ Auth::user()->name }} <span class="caret"></span>
								</a>

								<ul class="dropdown-menu">
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
						@endguest
					</ul>
				</div>
			</div>
		</nav>
		
		<div class="container">
			<div class="row">
				@guest
				@else
					<div class="col-md-3">
						<ul class="list-group">
						
							<li class="list-group-item list-group-item-info">
								<img src="{{ asset('images/logo-tienda.png') }}" alt="fiusac" style="opacity:0.9;" width="240" heigth="175">
							</li>

						
							<li class="list-group-item list-group-item-info">
								<a href="{{route('home')}}"> 									
									<h4> 
										<span class="glyphicon glyphicon-home"></span> 
										Inicio
									</h4>							
								</a>
							</li>
							
							<li class="list-group-item list-group-item-info">
								<a href="{{route('products_index')}}"> 									
									<h4> 
										<span class="glyphicon glyphicon-barcode"></span> 
										Productos
									</h4>
									
								</a>
							</li>
							
							@if (!Auth::user()->is_admin)
								<li class="list-group-item list-group-item-info">
									<h4>
									<a href="{{route('products_shopping_cart')}}">Mi carrito <span class="glyphicon glyphicon-shopping-cart"><span class="badge" id="carritoSize">{{sizeof(Session::get('order', []))}}</span></span></a>
									</h4>
								</li>
							@endif
						
							
							@if (Auth::user()->is_admin)
								<li class="list-group-item list-group-item-info">
									<a href="{{route('categories_index')}}"> 									
										<h4> 
											<span class="glyphicon glyphicon-list-alt"></span> 
											Categorías de Productos
										</h4>
										
									</a>
								</li>
							
							
							
								<li class="list-group-item list-group-item-info">
									<a href="{{route('reasons_index')}}"> 									
										<h4> 
											<span class="glyphicon glyphicon-repeat"></span> 
											Motivos de devolucición
										</h4>
										
									</a>
								</li>
								
								<li class="list-group-item list-group-item-info">
									<a href="{{route('questions_index')}}"> 									
										<h4> 
											<span class="glyphicon glyphicon-question-sign"></span> 
											Preguntas para Encuestas
										</h4>
										
									</a>
								</li>
								
								<li class="list-group-item list-group-item-info">
									<a href="{{route('reports_index')}}"> 									
										<h4> 
											<span class="glyphicon glyphicon-stats"></span> 
											Reportes
										</h4>
										
									</a>
								</li>
							@endif
											  
						</ul>
					</div>
				@endguest

				<div class="col-md-9">				
					@yield('content')
				</div>
							
			</div>
		</div>
    </div>
	
    <!-- Scripts -->
    
</body>
</html>
