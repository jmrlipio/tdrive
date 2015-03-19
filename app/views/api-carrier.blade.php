@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style("css/form.css"); }}
@stop

@section('content')
<div id="logo-container">
	{{ HTML::image("images/tdrive.png", null, array('class' => 'auto')) }}
</div>

	@if (Session::has('success') ) 
            
        <h3 class="title center">{{ Session::get('success') }}</h3>              

    @endif

	<h1 class="title center">Select Carrier</h1>

	{{ Form::open(array('route' => array('games.carrier.post', $app_id))) }}

		<div class="control">
			{{ Form::select('carrier_id', $carriers, null) }}
		</div>

		<div class="control-item fr">
			 {{ Form::submit('choose') }}
		</div>

	{{ Form::close() }}

@stop

@section('javascripts')

@stop
