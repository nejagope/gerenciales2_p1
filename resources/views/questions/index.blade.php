@extends('layouts.app')

@section('head')
@stop

@section('content')


<div class="panel panel-primary">                                

	<div class="panel-heading">                    
		<h2> Preguntas para encuestas</h2>
	</div>
	<div class="panel-body">
		
		<table class="table table-striped">
			@foreach ($questions as $question)
												   
				<tr>
					<td >
						
						{{ $question->question }}
						
					</td>
																										  

					<td width="10%">
						<form clas="form form-inline" method="post" action="{{ route('questions_delete', ['question' => $question->id]) }}" >
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
						<a href="{{ route('questions_create') }}"> 
						   Nuevo
						</a>
					</h5>
				</td>
			</tr>                                
		</table>
						  
	</div>
</div>
      
@stop