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
					$countries = ['Indonesia', 'Thailand', 'Malaysia', 'Singapore', 'Philippines', 'Vietnam', 'Myanmar', 'Brunei', 'Cambodia', 'Laos']; ?>
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
					<!-- <input list="os-version" type="text" placeholder="select OS version"> -->
					<select id="os-type" name="os-type" required>
						<option value="1">Select OS</option>
						<option value="iOS">iOS</option>
						<option value="Android">Android</option>
						<!-- Apple -->
						<!-- <optgroup label="iOS">
							<option value="iOS 8.3">iOS 8.3</option>
							<option value="iOS 8.2">iOS 8.2</option>
							<option value="iOS 8.1">iOS 8.1</option>
							<option value="iOS 7.1">iOS 7.1</option>
							<option value="iOS 7.0.6">iOS 7.0.6</option>
							<option value="iOS 7.0.5">iOS 7.0.5</option>
							<option value="iOS 7.0.4">iOS 7.0.4</option>
							<option value="iOS 7.0.3">iOS 7.0.3</option>
							<option value="iOS 7.0.2">iOS 7.0.2</option>
							<option value="iOS 7">iOS 7</option>
						</optgroup>
						
						Android
						<optgroup label="Android">
							<option value="Android 5.0, Lollipop">Android 5.0, Lollipop</option>
							<option value="Android 4.4, KitKat">Android 4.4, KitKat</option>
							<option value="Android 4.1, Jelly Bean">Android 4.1, Jelly Bean</option>
							<option value="Android 4.0, Ice Cream Sandwich">Android 4.0, Ice Cream Sandwich</option>
							<option value="Android 3.0, Honeycomb">Android 3.0, Honeycomb</option>
							<option value="Android 2.3, Gingerbread">Android 2.3, Gingerbread</option>
							<option value="Android 2.2, Froyo">Android 2.2, Froyo</option>
							<option value="Android 2.0, Eclair">Android 2.0, Eclair</option>
							<option value="Android 1.6, Donut">Android 1.6, Donut</option>						
						</optgroup>
						
						<optgroup label="other">
							<option value="other">Others</option>
						</optgroup> -->
					</select>
				</div>
			</div>

			<div class="control clearfix wbg">
				<input type="text" name="os-version" id="os-version" placeholder="{{ trans('global.os version') }}" required>

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
