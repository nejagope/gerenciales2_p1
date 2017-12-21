@extends('layouts.app')

@section('head')
@stop

@section('content')
<script>
	function evaluar(question_id, score){
		$("#btnScore" + score + "-" + question_id).prop("disabled", true);
		$("#btnScore" + score + "-" + question_id).siblings().remove();
		let redirigir = false;
		if($(".btnScore:enabled" ).length == 0){
			$("#labelGracias").show();
			$("#tablaPreguntas").hide();
		}
		
		$.ajax({			
			url: "{{ route('answers_store') }}",
			//data: "answer=" + $("#opcionScore" + question_id).val() + "&" + "question="+question_id,
			data: "answer=" + score + "&" + "question="+question_id + "&redirigir=" + redirigir,
			beforeSend: function(){
				//alert($("#opcionScore").val());
				//alert("#btnScore" + score + "-" + question_id);
				
			},
			success: function (response) {
				
					
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
			<h4>Ayúdanos a mejorar nuestro servicio</h4>
			<p>Tu opinión es muy impotante. Selecciona la emoción que tienes ante cada pregunta. No es obligatorio responder todas.</p>
		@endif	
		@if (Auth::user()->is_admin)	
			<h2> Preguntas para encuestas</h2>
		@endif	
	</div>
	<div class="panel-body">
		
		<table class="table table-striped" id="tablaPreguntas">
			@foreach ($questions as $question)
												   
				<tr id="td{{$question->id}}">
					<td >						
						<label>{{$loop->iteration}} - {{ $question->question }}</label>
						
						<div>
							@if (!Auth::user()->is_admin)
						
								<button id="btnScore1-{{$question->id}}" class="btn btn-sm btn-default btnScore" onclick="evaluar({{$question->id}}, 1)">
									<img src="{{asset('images/1.png')}}" width="48" height="48">
								</button>
								<button id="btnScore2-{{$question->id}}" class="btn btn-sm btn-default btnScore" onclick="evaluar({{$question->id}}, 2)">
									<img src="{{asset('images/2.png')}}" width="48" height="48">
								</button>
								<button id="btnScore3-{{$question->id}}" class="btn btn-sm btn-default btnScore" onclick="evaluar({{$question->id}}, 3)">
									<img src="{{asset('images/3.png')}}" width="48" height="48">
								</button>
								<button id="btnScore4-{{$question->id}}" class="btn btn-sm btn-default btnScore" onclick="evaluar({{$question->id}}, 4)">
									<img src="{{asset('images/4.png')}}" width="48" height="48">
								</button>
								<button id="btnScore5-{{$question->id}}" class="btn btn-sm btn-default btnScore" onclick="evaluar({{$question->id}}, 5)">
									<img src="{{asset('images/5.png')}}" width="48" height="48">
								</button>
								<br>
							@endif	
							
						</div>
					</td>											
					
					
					@if (Auth::user()->is_admin)
					<td width="10%">
						<form clas="form form-inline" method="post" action="{{ route('questions_delete', ['question' => $question->id]) }}" >
							 {{ csrf_field() }}
							<input type="submit" class="btn btn-danger btn-sm"  value="Eliminar">
						</form>                                        
					</td>
					@endif	
					
				</tr>
										
			@endforeach                            
		</table>
		
		<label id="labelGracias" hidden="true">Gracias por sus respuestas! </label>
		
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