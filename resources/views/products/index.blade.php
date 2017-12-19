@extends('layouts.app')

@section('head')
@stop

@section('content')
<script>
	function addToOrder(product_id){
		$.ajax({
			url: "{{ route('products_add_to_order') }}",
			data: "product=" + product_id,
			beforeSend: function(){
				
			},
			success: function(total_products){				
				$("#carritoSize").text(total_products);
			},
			error: function(){
				alert('error')
			}
		});
	}
</script>

<div class="panel panel-primary">                                

	<div class="panel-heading">                    
		<h2> Productos </h2>		
	</div>
	<div class="panel-body">				
		<h5>Categorías</h5>
		<ul class="list-inline">
			<li class="list-inline-item">
				<a href="{{route('products_index')}}">
					Todas
				</a>					
			</li>
			@foreach ($categories as $category)
				<li class="list-inline-item">					
					<a href="{{route('products_index', ['category' => $category->id])}}">
						{{ $category->description }}
					</a>					
				</li>
			@endforeach
		</ul>
		
		@isset($category_selected)			
			<h2>Categoría: {{$category_selected->description}}</h2>			
		@endisset
		
		 <table class="table table-striped">
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
					
					@if (!Auth::user()->is_admin)
						<td width="10%">
							<button class="btn btn-success btn-sm" onclick="addToOrder({{ $product->id }})">
								<span class="glyphicon glyphicon-shopping-cart"></span>
								Agregar al Carrito
							</button>
						</td>					
					@endif
					
					@if (Auth::user()->is_admin)
						<td width="10%">
							<form clas="form form-inline" method="post" action="{{ route('products_delete', ['activityType' => $product->id]) }}" >
								 {{ csrf_field() }}
								<input type="submit" class="btn btn-danger btn-sm"  value="Eliminar">
							</form>                                        
						</td>
					@endif
				</tr>
									
			@endforeach                            
		</table>
		
		<div class="text-center">{{ $products->links() }}</div>
		@if (Auth::user()->is_admin)
			<table>
				<tr>
					<td class="col-md-4 ">
						<h5 align="left">
							<a href="{{ route('products_create') }}"> 
							   Nuevo
							</a>
						</h5>
					</td>
				</tr>                                
			</table>
		@endif
	</div>
</div>
      
@stop