@extends('layouts.app')

@section('head')
@stop

@section('content')
<div class="panel panel-primary">                                

	<div class="panel-heading">                    
		<h3> Nuevo Producto</h3>
	</div>
	<div class="panel-body">                   					
		<form class="form-horizontal" role="form" method="POST" action="{{ route('products_store') }}">
			{{ csrf_field() }}
			
			<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">							
				<label for="name" class="col-md-4 control-label">Nombre</label>
				<div class="col-md-6">
					<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

					@if ($errors->has('name'))
						<span class="help-block">
							<strong>{{ $errors->first('name') }}</strong>
						</span>
					@endif
				</div>
			</div>
			
			<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">							
				<label for="price" class="col-md-4 control-label">Precio</label>
				<div class="col-md-6">
					<input id="price" type="text" class="form-control" name="price" value="{{ old('price') }}" required>

					@if ($errors->has('price'))
						<span class="help-block">
							<strong>{{ $errors->first('price') }}</strong>
						</span>
					@endif
				</div>
			</div>
			
			<div class="form-group{{ $errors->has('image_url') ? ' has-error' : '' }}">							
				<label for="image_url" class="col-md-4 control-label">Imagen</label>
				<div class="col-md-6">
					<input id="image_url" type="text" class="form-control" name="image_url" value="{{ old('image_url') }}">

					@if ($errors->has('image_url'))
						<span class="help-block">
							<strong>{{ $errors->first('image_url') }}</strong>
						</span>
					@endif
				</div>
			</div>
			
			<div class="form-group">							
				<label for="category" class="col-md-4 control-label">Categoría</label>
				<div class="col-md-6">
					<select class="form-control {{ $errors->has('category') ? ' has-error' : '' }}" id="category" name="category">
						<option value=""> Seleccione...</option>
						@foreach ($categories as $_category)
							<option value="{{$_category->id}}"
							@isset ($category)
								@if ($category->id == $_category->id)
									selected="selected"
								@endif
							@endisset
							>{{$_category->description}}</option>
						@endforeach
					</select>
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