@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style("css/form.css"); }}
@stop

<style>
	
	#logo-container {
		margin-top: -30px;
		margin-bottom: 10px;
	}
	
</style>

@section('content')
<div id="logo-container">
	{{ HTML::image("images/tdrive.png", null) }}
</div>
	<br>
	{{ Form::open(array('action' => 'HomeController@home')) }}
		{{ Form::token() }}

		<div class="control">
			<select name="selected_carrier" required>
				<option value="">Select Carrier</option>

				@foreach ($selected_carriers as $carrier)
					<?php $selected = ''; ?>

					@if(Session::has('carrier'))
						<?php $selected = ($carrier->id == Session::get('carrier')) ? 'selected' : ''; ?>
					@endif

					<option value="{{ $carrier->id }}" {{ $selected }}>{{ $carrier->carrier }}</option>
				@endforeach

			</select>
		</div>
		<br>
		

		{{ Form::hidden('country_id', $country_id) }}

		<div class="control-item center">
			 {{ Form::submit('choose', array('class' => 'carrier-submit')) }}
		</div>

	{{ Form::close() }}

@stop

@section('javascripts')

@stop
