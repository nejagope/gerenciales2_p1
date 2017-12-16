@extends('layouts.app')

@section('head')
@stop

@section('content')
<div class="panel panel-primary">                                

	<div class="panel-heading">                    
		<h3> Nueva pregunta </h3>
	</div>
	<div class="panel-body">                   					
		<form class="form-horizontal" role="form" method="POST" action="{{ route('questions_store') }}">
			{{ csrf_field() }}
			
			<div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">							
				<label for="question" class="col-md-4 control-label">Pregunta</label>
				<div class="col-md-6">
					<input id="question" type="text" class="form-control" name="question" value="{{ old('question') }}" required autofocus>

					@if ($errors->has('question'))
						<span class="help-block">
							<strong>{{ $errors->first('question') }}</strong>
						</span>
					@endif
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-md-8 col-md-offset-4">
					<button type="submit" class="btn btn-primary">
						Crear
					</button>
					<a class="btn btn-primary" href="#" onclick="window.history.back()"> 
						Cancelar
					</a>
				</div>
			</div>
		</form>
	</div>
</div>      
@stop