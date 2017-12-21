@extends('layouts.app')

@section('head')
@stop

@section('content')


<div class="panel panel-primary">                                

	<div class="panel-heading">                    
		<h2> Clientes </h2>
	</div>
	<div class="panel-body">
		<h2> Compras de clientes </h2>
		<form class="form-inline" role="form" method="get" action="{{ route('clients_index') }}">
			{{ csrf_field() }}
			
			<div class="form-group{{ $errors->has('min') ? ' has-error' : '' }}">							
				<label for="min" class="control-label">Mínimo</label>
				<div class="">
					<input id="min" type="text" class="form-control" name="min" value="@isset($min){{$min}} @else {{ old('min') }} @endif" >

					@if ($errors->has('min'))
						<span class="help-block">
							<strong>{{ $errors->first('min') }}</strong>
						</span>
					@endif
				</div>
			</div>
			
			<div class="form-group{{ $errors->has('max') ? ' has-error' : '' }}">							
				<label for="max" class="control-label">Máximo</label>
				<div class="">
					<input id="max" type="text" class="form-control" name="max" value="@isset($max){{$max}} @else {{ old('max') }} @endif" >
					
					@if ($errors->has('max'))
						<span class="help-block">
							<strong>{{ $errors->first('max') }}</strong>
						</span>
					@endif
				</div>
			</div>
			
			
			<div class="form-group">
				<div class="">
				<br>
					<button type="submit" class="btn btn-primary">
						Filtrar
					</button>					
				</div>
			</div>
			&nbsp
			&nbsp
			&nbsp
			&nbsp
			<div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}">							
				<label for="discount" class="control-label">Descuento</label>
				<div class="">
					<select name="discount" class="form-control">
						<option value="0.05">5%</option>
						<option value="0.10">10%</option>
						<option value="0.15">15%</option>
						<option value="0.20">20%</option>
						<option value="0.25">25%</option>
						<option value="0.30">30%</option>
						<option value="0.35">35%</option>
						<option value="0.40">40%</option>
						<option value="0.45">45%</option>
						<option value="0.50">50%</option>
						<option value="0.55">55%</option>
						<option value="0.60">60%</option>
						<option value="0.65">65%</option>
						<option value="0.70">70%</option>
						<option value="0.75">75%</option>
						<option value="0.80">80%</option>
						<option value="0.85">85%</option>
						<option value="0.90">90%</option>
						<option value="0.95">95%</option>
						<option value="1">100%</option>
					</select>
					@if ($errors->has('discount'))
						<span class="help-block">
							<strong>{{ $errors->first('discount') }}</strong>
						</span>
					@endif
				</div>
			</div>
			
			<div class="form-group">
				<div class="">
				<br>
					<input type="submit" name="action" value="Enviar Descuento" class="btn btn-success">						
				</div>
			</div>
			
		</form>
		<br>
		<table class="table table-striped">
			<tr>
				<th>Cliente</th>
				<th>Email</th>
				<th>Compras</th>
			</tr>
			@foreach ($clients as $client)
												   
				<tr>
					<td >
						
						{{ $client->name }}
						
					</td>
					
					<td >
						
						{{ $client->email }}
						
					</td>
					
					<td >
						
						$ {{ $client->compras }}
						
					</td>
																										  					
				</tr>
					
				
			@endforeach                            
		</table>

		<table>
			<tr>
				<td class="col-md-4 ">
					<h5 align="left">
						
					</h5>
				</td>
			</tr>                                
		</table>
						  
	</div>
</div>
      
@stop