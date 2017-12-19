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
		  google.charts.setOnLoadCallback(drawCharts);
		  
		  function drawCharts(){
			  drawChartAmountsByCategory();
			  drawChartOrdersShippings();
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
		</script>
		<div id="amountsCategories" style="width: 100%; height: 500px;"></div>
		<div id="chartOrdersShippings" style="width: 100%; height: 500px;"></div>
		</div>
		
	</div>
</div>
      
@stop