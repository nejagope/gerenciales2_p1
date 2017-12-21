@extends('layouts.app')

@section('head')
@stop

@section('content')


<div class="panel panel-primary">                                

	<div class="panel-heading">                    
		<h2> Órdenes @if (Auth::user()->is_admin) pendientes @endif</h2>
	</div>
	<div class="panel-body">
		
		<table class="table table-striped">
			<tr>
				<th> # </th>
				<th> A nombre de </th>
				<th> Fecha de órden </th>
				<th> Fecha de despacho </th>
			</tr>
			@foreach ($orders as $order)
												   
				<tr>
					<td>
						{{$order->id}}
					</td>
					<td >
						
						{{ $order->user->name }}
						
					</td>
					
					<td >
						
						{{ $order->created_at }}						
					</td>
					
					<td >
						
						@if ($order->shippings->first())
							{{$order->shippings->first()->created_at}}
						@endif							
					</td>
					
					<td>
						<a href="{{route('orders_view', ['order' => $order])}}" class="btn btn-info btn-sm">Ver detalles</td>
					</td>
																										  
					@if (Auth::user()->is_admin)
						<td width="10%">
							<form clas="form form-inline" method="post" action="{{ route('orders_dispatch', ['order' => $order->id]) }}" >
								 {{ csrf_field() }}
								<input type="submit" class="btn btn-success btn-sm"  value="Despachar">
							</form>                                        
						</td>
					@endif
				</tr>
					
				
			@endforeach                            
		</table>		
		<div class="text-center">{{ $orders->links() }}		</div>
	</div>
</div>
      
@stop