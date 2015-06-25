@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style('css/form.css') }}
@stop

@section('content')
    <h1 class="title">{{ trans('global.Contact Us') }}</h1>
	
		<p>{{ trans('global.Your comments and suggestions are important to us. You can reach us via the contact points below. Please use English.') }}</p>
		{{ Form::open(array('route'=>'contact-us.user-inquiry', 'method' => 'post', 'id'=> 'register')) }}

			@if(Session::has('message'))
				@if(Session::get('message') == 'Your inquiry has been sent.')
					<br>
					<p class="form-success">{{ Session::get('message') }}</p>
				@else
					<br>
					<p class="form-error">{{ Session::get('message') }}</p>
				@endif
			@endif

			<div class="control clearfix">
				<input type="text" name="name" id="name" placeholder="{{ trans('global.name') }}" required>

				{{ $errors->first('name', '<p class="form-error">:message</p>') }}
			</div>

			<div class="control clearfix">
				<input type="email" name="email" id="email" placeholder="{{ trans('global.email') }}" required>

				{{ $errors->first('email', '<p class="form-error">:message</p>') }}
			</div>
			<div class="select wbg">
				<select name="app_store" required id="carrier">
					<option value="">Select App Store</option>

					@foreach ($carriers as $carrier)			
						<option value="{{ $carrier->carrier }}">{{ $carrier->carrier }}</option>
					@endforeach
				</select>
			</div>
		
			<div class="control">
				<div class="select clearfix wbg">
					<?php 
					$countries = ['Indonesia', 'Thailand', 'Malaysia', 'Singapore', 'Philippines', 'Vietnam', 'Myanmar', 'Brunei', 'Cambodia', 'Laos']; sort($countries);?>
					<select name="country" class="clearfix" id="country" required>
						<option value="{{ $default_location['name'] }}">{{ $default_location['name'] }}</option>
						
						@for($x = 0; $x < count($countries); $x++)
							@if($countries[$x] != $default_location['name'])
								<option value="{{$countries[$x]}}">{{$countries[$x]}}</option>
							@endif
						@endfor
						
					</select>

					{{ $errors->first('country', '<p class="form-error">:message</p>') }}
				</div>
			</div>
			
			<div class="control">
				<div class="select clearfix wbg">
					<select name="game_title" class="clearfix" id="game" required>
						<option value="General Inquiry">{{ trans('global.General Inquiry') }}</option>
						@foreach($games as $game)
							<option value="{{ $game->main_title }}">{{ $game->main_title }}</option>
						@endforeach
					</select>

					{{ $errors->first('game_title', '<p class="form-error">:message</p>') }}
				</div>
			</div>

			<div class="control">
			
				<div id="os-selection" class="select clearfix">
					<select id="os-type" name="os-type" required>
						<option value="1">Select OS</option>
						<option value="iOS">iOS</option>
						<option value="Android">Android</option>
					</select>
				</div>
			</div>

			<div class="control clearfix wbg">
				<input type="text" name="os-version" id="os-version" placeholder="{{ trans('global.os version') }}">

				{{ $errors->first('os-version', '<p class="form-error">:message</p>') }}
			</div>

			<div class="captcha control clearfix">
				{{ HTML::image(Captcha::img(), 'Captcha image') }}
				<?php $test = trans('global.type what you see...'); ?>
				{{ Form::text('captcha', null, array('placeholder' => trans('global.type what you see...'), 'required' => 'required')) }}
				{{ $errors->first('captcha', '<p class="form-error">:message</p>') }}
			</div>

			<div class="control clearfix">
				<textarea name="message" id="contact-message" placeholder="{{ trans('global.message') }}" required></textarea>

				{{ $errors->first('message', '<p class="form-error">:message</p>') }}
			</div>

			<div class="control clearfix">
				<input type="submit" value="{{ trans('global.submit') }} &raquo;">
			</div>
		{{ Form::close() }}


@stop

@section('javascripts')
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}
	@include('_partials/scripts')
	{{ HTML::script('js/chosen.jquery.js') }}

	<script>

	$( document ).ready(function() {
		$(".chosen-select").chosen();
	   /*var other_os = '<input type="text" name="other_os" id="other_os" placeholder="Input os" required>';
	
	    $("#os-version").change(function(){
		  var val = $(this).find("option:selected").val();

			if(val == "other")
		    {	
		    	$('#os-selection').append(other_os);
		    
		    } else {
		    	
		    	$('input#other_os').detach();
		    }
		});*/

	});

	</script>
@stop
