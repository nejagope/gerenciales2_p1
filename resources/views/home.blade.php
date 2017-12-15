@extends('layouts.app')

@section('content')
<div class="panel panel-default">	

	<div class="panel-body">
		@if (session('status'))
			<div class="alert alert-success">
				{{ session('status') }}
			</div>
		@endif
		
		<img src="{{ asset('images/tienda-online.png') }}" alt="tienda-online" style="opacity:0.5;" width="100%">
	</div>
</div>
@endsection
