@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style("css/form.css"); }}
@stop

@section('content')
	<div id="logo-container">
		{{ HTML::image("images/tdrive.png", null, array('class' => 'auto')) }}
	</div>

	<h1 class="title center">Payment Information</h1>

	{{ Form::open(array('route' => array('games.carrier.post', $app_id))) }}
		<li>
			{{ Form::label('Credit Card Number:') }}
			{{ Form::text('card_number') }}
		</li>
		<li>
			{{ Form::label('CVC:') }}
			{{ Form::text('card_number') }}
		</li>
		<li>
			{{ Form::label('Expiration Date:') }}
			{{ Form::selectMonth(null) }}
			<br>
			<br>
			{{ Form::selectYear(null, 2015, 2030) }}
		</li>


	{{ Form::close() }}

@stop