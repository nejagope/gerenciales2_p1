@extends('layouts.app')

@section('head')
@stop

@section('content')
<script>
	function evaluar(question_id){
		$.ajax({
			url: "{{ route('answers_store') }}",
			data: "answer=" + $("#opcionScore" + question_id).val() + "&" + "question="+question_id,
			beforeSend: function(){
				//alert($("#opcionScore").val());
			},
			success: function (response) {
				alert('funciono')
			},
			error: function(){
				alert('error')
			}
		});
	}
</script>
<div class="panel panel-primary">                                

	<div class="panel-heading">    
		@if (!Auth::user()->is_admin)	
			<h2> Encuesta</h2>
			<h4>Ayudanos a Mejorar nuestro sitio WEB</h4>
		@endif	
		@if (Auth::user()->is_admin)	
			<h2> Preguntas para encuestas</h2>
		@endif	
	</div>
	<div class="panel-body">
		
		<table class="table table-striped">
			@foreach ($questions as $question)
												   
				<tr>
					<td >						
						{{ $question->question }}						
					</td>											
					
					
					@if (Auth::user()->is_admin)
					<td width="10%">
						<form clas="form form-inline" method="post" action="{{ route('questions_delete', ['question' => $question->id]) }}" >
							 {{ csrf_field() }}
							<input type="submit" class="btn btn-danger btn-sm"  value="Eliminar">
						</form>                                        
					</td>
					@endif	
					@if (!Auth::user()->is_admin)
						<td width="10%">
						<!-- AQUI -->
						<!--<form clas="form form-inline" method="post" action="{{ route('answers_store')}}" > -->
							<select id="opcionScore{{$question->id}}" name="rating">
								<option value="">Select a rating</option>
								<option value="5">Excellent</option>
								<option value="4">Very Good</option>
								<option value="3">Average</option>
								<option value="2">Poor</option>
								<option value="1">Terrible</option>
							</select>	
											
							<button  class="btn btn-success btn-sm" onclick="evaluar({{$question->id}})">
								Enviar
							</button>
						
						<!-- </form>  -->
						</td>
					@endif	
				</tr>
										
			@endforeach                            
		</table>
		
		<table>
			<tr>
				@if (Auth::user()->is_admin)
					<td class="col-md-4 ">
						<h5 align="left">
							<a href="{{ route('questions_create') }}"> 
							   Nuevo
							</a>
						</h5>
					</td>				
				@endif				
			</tr>           
		</table>
						  
	</div>
</div>
      
@stop