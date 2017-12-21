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
			
		<script>
			function aplicarDescuento(){
				try{					
					var total = $("#lblTotal").text();
					descuento = $("#gift").text().split(' ')[6];
					
					if (isNaN(descuento))
						return;
					descuento = Math.round(total * descuento) /100;
					var granTotal = Math.round((total - descuento) * 100)/100 ;
					$("#lblGranTotal").text(granTotal);
					$("#lblDescuento").text(descuento);
					descuento = null;
				}catch(ex){
					$("#lblGranTotal").text($("#lblTotal").text());
					$("#lblDescuento").text(0);
				}
			}
		</script>
		<table>
			<tr>
				<td><label>Total compra: $</label> <label id="lblTotal">{{$totalCompra}}</label> </td>
			</tr>
			<tr>
				<td><label>Descuento: $</label>  <label id="lblDescuento">0</label> </td>
			</tr>			
			<tr>				
				<td> 
					_____________________________<br>
					<label>Total a pagar: $</label> <label id="lblGranTotal">${{$totalCompra}}</label> 
				</td>
			</tr>
			
			@if ($totalCompra > 0)
				<tr>
					<td>
						<form class="form form-horizontal" method="post" action="{{ route('products_create_order') }}" >
							 {{ csrf_field() }}						 
							<input type="submit" class="btn btn-success btn-sm"  value="Confirmar Órden">
							<br>
							<br>
							
								<label>Selecciona una tarjeta de descuento si eseas utilizarala en esta compra. </label>  
								<select name="gift" id="gift" class="form-control" oninput="aplicarDescuento()">
									<option value="0">Selecciona un descuento</option>
									@foreach($gifts as $gift)
										<option value="{{$gift->id}}">Tarjeta de regalo #{{$gift->id}}: {{$gift->discount*100}} % de descuento</option>
									@endforeach
								</select>								
							
						</form>                                        
					</td>
				</tr>                                
			@endif
		</table>
					  
	</div>
</div>
      
@stop