@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style("css/form.css"); }}
@stop

@section('content')

	{{ Form::token() }}

	<h1 class="title">{{ trans('global.Create new account') }}</h1>

	{{ Form::open(array('route'=>'users.register', 'id' => 'register')) }}

		<div id="token">{{ Form::token() }}</div>

		<div class="control">
			{{ Form::label('email', trans('global.email')) }}
			{{ Form::text('email', null, array('class'=> 'form-control', 'required')) }}
			{{ $errors->first('email', '<p class="error">:message</p>') }}
		</div>

		<div class="control">
			{{ Form::label('username', trans('global.username')) }}
			{{ Form::text('username', null, array('class'=> 'form-control', 'required')) }}
			{{ $errors->first('username', '<p class="error">:message</p>') }}
		</div>

		<div class="control">
			{{ Form::label('first_name', trans('global.first_name')) }}
			{{ Form::text('first_name', null, array('class'=> 'form-control', 'required')) }}
			{{ $errors->first('first_name', '<p class="error">:message</p>') }}
		</div>
		
		<div class="control">
			{{ Form::label('last_name', trans('global.last_name')) }}
			{{ Form::text('last_name', null, array('class'=> 'form-control', 'required' )) }}
			{{ $errors->first('last_name', '<p class="error">:message</p>') }}
		</div>

		<div class="control">
			{{ Form::label('mobile_no', trans('global.mobile_no')) }}
			{{ Form::text('mobile_no') }}
			{{ $errors->first('mobile_no', '<p class="error">:message</p>') }}
		</div>
		
		<div class="control">
			{{ Form::label('password', trans('global.password')) }}
			{{ Form::password('password', array('required')) }}
		</div>
		
		<!--<input class="button button-pink" type="button" value="Generate password" onClick="randomString();"><br/>-->
		
		{{ $errors->first('password', '<p class="error">:message</p>') }}

		<div class="control">
			{{ Form::label('confirm password', trans('global.confirm password')) }}
			{{ Form::password('password_confirmation') }}
		</div>
		
		{{--
		<div class="control">
			{{ Form::label('prof_pic', 'Profile Image:') }}
			{{ Form::file('prof_pic') }}
			{{ $errors->first('homepage_image', '<p class="error">:message</p>') }}
		</div>
		--}}
		
		{{ Form::submit(trans('global.Create new account'), array('class' => 'no-radius')) }}

	{{ Form::close() }}

@stop

@section('javascripts')
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}

	@include('_partials/scripts')

	<script>
		var token = $('input[name="_token"]').val();
	</script>
@stop
