@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style("css/form.css"); }}
@stop

@section('content')

	<h1 class="title">Create new account</h1>

	{{ Form::open(array('route'=>'users.register', 'id' => 'register')) }}

		<div class="control">
			{{ Form::label('email') }}
			{{ Form::text('email', null, array('class'=> 'form-control', 'required')) }}
			{{ $errors->first('email', '<p class="error">:message</p>') }}
		</div>

		<div class="control">
			{{ Form::label('username') }}
			{{ Form::text('username', null, array('class'=> 'form-control', 'required')) }}
			{{ $errors->first('username', '<p class="error">:message</p>') }}
		</div>

		<div class="control">
			{{ Form::label('first_name') }}
			{{ Form::text('first_name', null, array('class'=> 'form-control', 'required')) }}
			{{ $errors->first('first_name', '<p class="error">:message</p>') }}
		</div>
		
		<div class="control">
			{{ Form::label('last_name') }}
			{{ Form::text('last_name', null, array('class'=> 'form-control', 'required' )) }}
			{{ $errors->first('last_name', '<p class="error">:message</p>') }}
		</div>
		
		<div class="control">
			{{ Form::label('password') }}
			{{ Form::password('password', array('required')) }}
		</div>
		
		<!--<input class="button button-pink" type="button" value="Generate password" onClick="randomString();"><br/>-->
		
		{{ $errors->first('password', '<p class="error">:message</p>') }}

		<div class="control">
			{{ Form::label('password_confirmation') }}
			{{ Form::password('password_confirmation') }}
		</div>
		
		{{ Form::submit('Create new account') }}

	{{ Form::close() }}

@stop

@section('javascripts')
@stop
