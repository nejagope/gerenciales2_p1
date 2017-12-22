@extends('layouts.app')

@section('head')
@stop

@section('content')


<div class="panel panel-primary">                                

	<div class="panel-heading">                    
		<h2> Tablero de Indicadores </h2>
	</div>
	<div class="panel-body">
	
		<ul class="list-inline">
			<li class="list-inline-item">
				<h4>Años:</h4>
			</li>
			<li class="list-inline-item">
				<a href="{{ route('reports_index') }}"> 
				   Todos
				</a>
			</li>
			@foreach ($years as $year)
				<li class="list-inline-item">
					<a href="{{ route('reports_index', ['year' => $year->year]) }}"> 
					   {{$year->year}}
					</a>
				</li>		  
			@endforeach
		</ul>
		
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
		  google.charts.load('current', {'packages':['corechart']});
		  google.charts.load('current', {'packages':['table']});
		  google.charts.load('current', {packages: ['corechart', 'bar']});
		  google.charts.setOnLoadCallback(drawCharts);
		  
		  function drawCharts(){
			  drawChartAmountsByCategory();
			  drawChartOrdersShippings();
			  drawChartProductsByCategory();
			  drawChartProductsOrderedDevolutions();
			  drawChartTop10Products();
			  drawChartAnswers();
			  drawChartReasons() ;
		  }

		  function drawChartAmountsByCategory() {

			var data = google.visualization.arrayToDataTable([
			  ['Categoría', 'Total Ventas'],
			  @foreach ($amounts_orders as $amount)
				  [ '{{ $amount->category }}' , {{ $amount->amount_ordered }} ],
			  @endforeach
			]);
			
			var formatter = new google.visualization.NumberFormat({prefix: '$'});

			// Reformat our data.
			formatter.format(data, 1);

			var options = {
			  title: 'Total de Órdenes por Categoría'
			};
			
			var chart = new google.visualization.PieChart(document.getElementById('amountsCategories'));

			chart.draw(data, options);
		  }
		  
		  function drawChartOrdersShippings() {

			var data = google.visualization.arrayToDataTable([
			  ['Estado', 'Total Órdenes'],
			  
			  [ 'Órdenes Despachadas' , {{ $total_shippings }} ],
			  [ 'Órdenes En Proceso' , {{ $total_orders - $total_shippings }} ],
			  
			]);
			
			var options = {
			  title: 'Órdenes despachadas vs Órdenes en Proceso',
			  is3D : true
			};
			
			var chart = new google.visualization.PieChart(document.getElementById('chartOrdersShippings'));

			chart.draw(data, options);
		  }
		  
		  function drawChartProductsByCategory() {

			var data = google.visualization.arrayToDataTable([
			  ['Categoría', 'Productos Ordenados', 'Productos Devueltos'],
			  @foreach($ordered_products as $products)
					[ '{{ $products->category }}' , {{ $products->ordered_products }}, 
			  
					@foreach ($devolutions as $devolution)
					
						@if ($devolution->category == $products->category)
							{{ $devolution->devolutions }}  
							@break
						@endif
						
						@if ($loop->last)
							0
						@endif
					@endforeach
				  ],			  							 
			  @endforeach
			]);						

			var options = {
			  title: 'Productos ordenados y devueltos por categoría',
			   hAxis: {
				  title: 'Total Productos',
				  minValue: 0
				},
				vAxis: {
				  title: 'Categoría'
				},
				series: {
				  0: {axis: 'Productos ordenados'},
				  1: {axis: 'Productos devueltos'}
				},
				axes: {
				  x: {
					'Productos ordenados': {label: 'Productos ordenados', side: 'top'},
					'Productos devueltos': {label: 'Productos devueltos'}
				  }
				}
			};
			
			var chart = new google.visualization.BarChart(document.getElementById('chartOrderedProducts'));

			chart.draw(data, options);
		  }
		  
		  			
		function drawChartProductsOrderedDevolutions() {

			var data = google.visualization.arrayToDataTable([
			  ['Estado', 'Total productos'],
			  
			  [ 'Productos Vendidos' , {{ $total_ordered_products - $total_devolutions }} ],
			  [ 'Productos Devueltos' , {{ $total_devolutions }} ],
			  
			]);
			
			var options = {
			  title: ' Prodductos vendidos vs Productos devueltos',
			  is3D : true
			};
			
			var chart = new google.visualization.PieChart(document.getElementById('chartSoldProducts'));

			chart.draw(data, options);
		  }
		
		
		function drawChartTop10Products() {

			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Product');
			data.addColumn('number', 'Unidades vendidas');
			
			data.addRows(
			[			  
			  @foreach ($top10_products as $product)
				['{{$product->product}}', {{$product->ordered_products}}],
				@if ($loop->iteration == 10)
					@break
				@endif
			  @endforeach
			  
			]);
			
			var options = {
			  title: 'Top 10 Prodductos más vendidos',
			  showRowNumber: true, 
			  width: '60%', 
			  height: '100%'			  
			};
			
			var chart = new google.visualization.Table(document.getElementById('chartTop10Products'));

			chart.draw(data, options);
		  }
		  
		  function drawChartAnswers() {

			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Pregunta');
			data.addColumn('number', 'Respuesta Promedio');
			data.addRows([			  
			  @foreach($answers as $answer)
		  ['{{$answer->question}}' , {{$answer->score}}],
			  @endforeach
			]);
			
			var options = {
			    title: 'Resultado de encuestas',	
				hAxis:{
					title: 'Pregunta'
				},
				vAxis:{
					title: 'Respuesta (1-5)',
					viewWindow:{
						min:0,
						max:6
					}
				}
			};
			
			var chart = new google.visualization.ColumnChart(document.getElementById('chartAnswers'));

			chart.draw(data, options);
		  }
		  
		  
		  function drawChartReasons() {

			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Motivo de devolucion');
			data.addColumn('number', 'Total devoluciones');
			data.addRows([			  
			  @foreach($devolutions_reasons as $reason)
					['{{$reason->reason}}' , {{$reason->total}}],
			  @endforeach
			]);
			
			var options = {
			    title: 'Devoluciones por motivo',	
				hAxis:{
					title: 'Motivo'
				},
				vAxis:{
					title: 'Total devoluciones',
					
				}
			};
			
			var chart = new google.visualization.ColumnChart(document.getElementById('chartReasons'));

			chart.draw(data, options);
		  }
		</script>
		
		<div id="amountsCategories" style="width: 100%; height: 500px;"></div>
		<div id="chartOrdersShippings" style="width: 100%; height: 500px;"></div>
		<div id="chartOrderedProducts" style="width: 100%; height: 500px;"></div>
		<div id="chartSoldProducts" style="width: 100%; height: 500px;"></div>
		<h3 class="text-center">Top 10 productos vendidos</h3>
		<div id="chartTop10Products" style="width: 100%; height: 500px;" class="text-center"></div>
		<div id="chartAnswers" style="width: 100%; height: 500px;"></div>
		<div id="chartReasons" style="width: 100%; height: 500px;"></div>
		<div>
			<label>Total pérdidas por devoluciones = $ {{$total_monto_devuelto}}</label>
		</div>
		
	</div>
</div>
      
@stop