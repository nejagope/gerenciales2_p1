@extends('layouts.app')

@section('head')
@stop

@section('content')

<div class="panel panel-primary">                                

	<div class="panel-heading">                    
		<h2> Mi Carrito </h2>		
	</div>
	<div class="panel-body">
				
		 <table class="table table-striped">
			<tr>
				<th colspan="2">Producto</th>
				<th>Cantidad</th>				
				<th></th>
				
			</tr>
			@foreach ($products as $product)			
				<tr>
				
					<td >									
						<img src="{{ $product->image_url }}" width="100" height="100">
						<br>
						<strong> $ {{ $product->price }} <strong>
					</td>
					
					<td >									
						<h4> {{ $product->name }} </h4>
						<p> <i> {{ $product->description }} </i></p>
					</td>
					
					<td>
						<h4>
							{{ $cantidades[$product->id] }}
						</h4>
					</td>
					
					<td width="10%">
						<form class="form form-inline" method="post" action="{{ route('products_remove_from_order', ['product' => $product->id]) }}" >
							 {{ csrf_field() }}
							<input type="submit" class="btn btn-danger btn-sm"  value="Quitar">
						</form>                                        
					</td>
					
				</tr>
									
			@endforeach                            
		</table>
			
		
		<table>
			<tr>
				<td> <label> Total compra: ${{$totalCompra}} </label> </td>
			</tr>
			@if ($totalCompra > 0)
				<tr>
					<td>
						<form class="form form-horizontal" method="post" action="{{ route('products_create_order') }}" >
							 {{ csrf_field() }}						 
							<input type="submit" class="btn btn-success btn-sm"  value="Confirmar Órden">
							<br>
							<label>Número de tarjeta de descuento: </label>  <input type="text" name="gift" id="gift">
							<button class="btn btn-info btn-sm">Aplicar descuento</button>
						</form>                                        
					</td>
				</tr>                                
			@endif
		</table>
					  
	</div>
</div>
      
@stop