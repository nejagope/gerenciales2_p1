@extends('layouts.app')

@section('head')
@stop

@section('content')
<div class="panel panel-primary">                                

	<div class="panel-heading">                    
		<h3> Nuevo motivo </h3>
	</div>
	<div class="panel-body">                   					
		<form class="form-horizontal" role="form" method="POST" action="{{ route('reasons_store') }}">
			{{ csrf_field() }}
			
			<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">							
				<label for="description" class="col-md-4 control-label">Descripción</label>
				<div class="col-md-6">
					<input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" required autofocus>

					@if ($errors->has('description'))
						<span class="help-block">
							<strong>{{ $errors->first('description') }}</strong>
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