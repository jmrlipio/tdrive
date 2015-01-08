@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style("css/form.css"); }}
@stop

@section('content')

	<h1 class="title center">Select Carrier</h1>

	{{ Form::open(array('action' => 'HomeController@home')) }}

		{{ Form::token() }}

		<div class="control">
			<select name="selected_carrier" required>
				<option value="">Select Carrier</option>

				@foreach ($selected_carriers as $carrier)
					<option value="{{ $carrier->id }}">{{ $carrier->carrier }}</option>
				@endforeach

			</select>
		</div>

		{{ Form::hidden('country', $country) }}

		<div class="control-item fr">
			 {{ Form::submit('choose') }}
		</div>

	{{ Form::close() }}

@stop

@section('javascripts')
@stop
