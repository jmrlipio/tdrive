@extends('_layouts.single')
@section('content')

	<br>
    <h1 class="center">{{ trans('global.Contact Us') }}</h1><br>

	<div id="contact" class="container">		
		<p>{{ trans('global.Your comments and suggestions are important to us. You can reach us via the contact points below.') }}</p>
		{{ Form::open(array('route'=>'contact-us.user-inquiry', 'method' => 'post')) }}
			@if(Session::has('message'))
				<br>
				<p class="form-success">{{ Session::get('message') }}</p>
			@endif

			<div class="control clearfix">
				<input type="text" name="name" id="name" placeholder="{{ trans('global.name') }}" required>

				{{ $errors->first('name', '<p class="form-error">:message</p>') }}
			</div>

			<div class="control clearfix">
				<input type="email" name="email" id="email" placeholder="{{ trans('global.email') }}" required>

				{{ $errors->first('email', '<p class="form-error">:message</p>') }}
			</div>

			<div class="select clearfix">
				<select name="country" class="clearfix" id="country" required>
					<option value="{{ $default_location['id'] }}">{{ $default_location['name'] }}</option>
					<option value="Indonesia">Indonesia</option>
					<option value="Thailand">Thailand</option>
					<option value="Malaysia">Malaysia</option>
					<option value="Singapore">Singapore</option>
					<option value="Philippines">Philippines</option>
					<option value="Vietnam">Vietnam</option>
					<option value="Myanmar">Myanmar</option>
					<option value="Brunei">Brunei</option>
					<option value="Cambodia">Cambodia</option>
					<option value="Laos">Laos</option>
					<!-- @foreach($countries as $country)
						<option value="{{ $country->name }}">{{ $country->name }}</option>
					@endforeach -->
				</select>

				{{ $errors->first('country', '<p class="form-error">:message</p>') }}
			</div>

			<div class="select clearfix">
				<select name="game_title" class="clearfix" id="game" required>
					<option value="General Inquiry">{{ trans('global.General Inquiry') }}</option>
					@foreach($games as $game)
						<option value="{{ $game->main_title }}">{{ $game->main_title }}</option>
					@endforeach
				</select>

				{{ $errors->first('game_title', '<p class="form-error">:message</p>') }}
			</div>
			
			<div id="os" class="select clearfix">
				<!-- <input list="os-version" type="text" placeholder="select OS version"> -->
				<select id="os-version" name="os-version">
					<!-- Apple -->
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
					
					<!-- Android -->
					<option value="Android 5.0, Lollipop">Android 5.0, Lollipop</option>
					<option value="Android 4.4, KitKat">Android 4.4, KitKat</option>
					<option value="Android 4.1, Jelly Bean">Android 4.1, Jelly Bean</option>
					<option value="Android 4.0, Ice Cream Sandwich">Android 4.0, Ice Cream Sandwich</option>
					<option value="Android 3.0, Honeycomb">Android 3.0, Honeycomb</option>
					<option value="Android 2.3, Gingerbread">Android 2.3, Gingerbread</option>
					<option value="Android 2.2, Froyo">Android 2.2, Froyo</option>
					<option value="Android 2.0, Eclair">Android 2.0, Eclair</option>
					<option value="Android 1.6, Donut">Android 1.6, Donut</option>
					<option value="other">Other</option>
	
				</select>
			</div>

			<div class="captcha control clearfix">
				{{ HTML::image(Captcha::img(), 'Captcha image') }}
				<?php $test = trans('global.type what you see...'); ?>
				{{ Form::text('captcha', null, array('placeholder' => trans('global.type what you see...'), 'required' => 'required')) }}
				{{ $errors->first('captcha', '<p class="form-error">:message</p>') }}
			</div>

			<div class="control clearfix">
				<textarea name="message" id="message" placeholder="{{ trans('global.message') }}" required></textarea>

				{{ $errors->first('message', '<p class="form-error">:message</p>') }}
			</div>

			<div class="control clearfix">
				<input type="submit" value="{{ trans('global.submit') }} &raquo;">
			</div>
		{{ Form::close() }}
	</div><!-- end #contact -->

@stop

@section('javascripts')
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}
	
	@include('_partials/scripts')

	<script>

	$( document ).ready(function() {
	   // var os = $('#aos-version :selected').val();
	   var other = '<input type="other" name="other" id="other" placeholder="Input os" required>';
	    $("#os-version").change(function(){
		  var val = $(this).find("option:selected").val();

			if(val == "other")
		    {
		    	$('#os').append(other);
		    }
		});
	});
	</script>
	
@stop
