@extends('layouts.app')

@section('head')
@stop

@section('content')


<div class="panel panel-primary">                                

	<div class="panel-heading">                    
		<h2> Productos </h2>
	</div>
	<div class="panel-body">
		
			 <table class="table table-striped">
				@foreach ($products as $product)
													   
							<tr>
								<td >									
									{{ $product->name }}									
								</td>
								
								<td >									
									{{ $product->price }}									
								</td>
								
								<td >									
									<img src="{{ $product->image_url }}" width="100" height="100">
								</td>
																													  

								<td width="10%">
									<form clas="form form-inline" method="post" action="{{ route('products_delete', ['activityType' => $product->id]) }}" >
										 {{ csrf_field() }}
										<input type="submit" class="btn btn-danger btn-sm"  value="Eliminar">
									</form>                                        
								</td>
								
							</tr>
						
					
				@endforeach                            
			</table>
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
				</li>
			</ul>                         
						  
	</div>
</div>
      
@stop