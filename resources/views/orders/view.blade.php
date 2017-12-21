@extends('layouts.app')

@section('head')
@stop

@section('content')

<div class="panel panel-primary">                                

	<div class="panel-heading">                    
		<h2> Detalle de órden </h2>		
	</div>
	<div class="panel-body">
				
		 <table class="table table-striped">
			<tr>
				<th colspan="2">Producto</th>
				<th>Cantidad</th>				
				<th></th>
				
			</tr>
			@foreach ($order->products as $product)			
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
							{{ $product->pivot->amount }}
						</h4>
					</td>
					
					@if (!Auth::user()->is_admin && $order->shippings->first())
						@forelse($order->devolutions as $devolution)
							@if($devolution->product_id == $product->id)
								<td>Producto devuelto</td>
								@break
							@endif
							@if ($loop->last)
								<td width="10%">
									<form class="form form-inline" method="post" action="{{ route('orders_return', ['product' => $product->id, 'order' => $order->id]) }}" >
										 {{ csrf_field() }}
										<input type="submit" class="btn btn-danger btn-sm"  value="Devolver">
									</form>                                        
								</td>
							@endif
						@empty
							<td width="10%">
									<form class="form form-inline" method="post" action="{{ route('orders_return', ['product' => $product->id, 'order' => $order->id]) }}" >
										 {{ csrf_field() }}
										<input type="submit" class="btn btn-danger btn-sm"  value="Devolver">
									</form>                                        
								</td>
						@endforelse
					@endif
				</tr>
									
			@endforeach                            
		</table>
			
		
		<table>
			<tr>
				<td> <label> Total compra: ${{$totalCompra}} </label> </td>				
			</tr>			
			<tr>
				<td> <label> Total descuento: ${{$discount}} </label> </td>
			</td>
			
			<tr>
				<td> <label> Gran Total: ${{$totalCompra - $discount}} </label> </td>
			</td>
		</table>
					  
	</div>
</div>
      
@stop