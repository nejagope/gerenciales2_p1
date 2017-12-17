@extends('layouts.app')

@section('head')
@stop

@section('content')


<div class="panel panel-primary">                                

	<div class="panel-heading">                    
		<h2> Categorías de productos </h2>
	</div>
	<div class="panel-body">
		
		<table class="table table-striped">
			@foreach ($categories as $category)
												   
				<tr>
					<td >
						
						{{ $category->description }}
						
					</td>
																										  

					<td width="10%">
						<form clas="form form-inline" method="post" action="{{ route('categories_delete', ['activityType' => $category->id]) }}" >
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
						<a href="{{ route('categories_create') }}"> 
						   Nuevo
						</a>
					</h5>
				</td>
			</tr>                                
		</table>
						  
	</div>
</div>
      
@stop