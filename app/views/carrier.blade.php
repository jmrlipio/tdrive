@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style("css/form.css"); }}
@stop

<style>
	
	#logo-container {
		
		margin-bottom: 10px;
	}

	#carrier {background: #fff;}
</style>

@section('content')
<div id="logo-container">
	{{ HTML::image("images/tdrive.png", null) }}
	@if (Session::has('success') ) 
            
        <h3 class="center flash-success">{{ Session::get('success') }}</h3> 

    @elseif(Session::has('fail') )   

    	<h3 class="center flash-fail">{{ Session::get('fail') }}</h3>    

    @endif
</div>
	<br>
	{{ Form::open(array('action' => 'HomeController@home')) }}
		{{ Form::token() }}

		<div class="control">
			<select name="selected_carrier" required id="carrier">
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
<script>
	$( document ).ready(function() {
		$('form').submit(function(){

	    var required = $('[required]'); // change to [required] if not using true option as part of the attribute as it is not really needed.
	    var error = false;

	    for(var i = 0; i <= (required.length - 1);i++)
	    {
	        if(required[i].value == '') // tests that each required value does not equal blank, you could put in more stringent checks here if you wish.
	        {
	            required[i].style.backgroundColor = 'rgb(255,155,155)';
	            error = true; // if any inputs fail validation then the error variable will be set to true;     
	        }
	    }

		    if(error) // if error is true;
		    {
		        return false; // stop the form from being submitted.
		    }
		});
	});
</script>
@stop
