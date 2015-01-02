@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style("css/form.css"); }}
@stop

@section('content')

	<h1 class="title center">Sign In</h1>

   {{ Form::open(array('route' => 'login.post', 'class' => 'login', 'id' => 'login-form')) }}

		<div class="control">
			{{ Form::text('username', null, array('placeholder'=>'username')) }}                   
		</div>

		<div class="control">
			{{ Form::password('password', array('placeholder'=>'password')) }}                    
		</div>

		<div class="control-group clearfix">
			<div class="control-item fl">
				{{ Form::checkbox('remember', 1 , null, ['id'=>'remember']); }}
			   <label for="remember">Remember me</label>
			</div>

			<div class="control-item fr">
				 {{ Form::submit('login') }}
			</div>
		</div>

	{{ Form::close() }}

	<div class="button">
		<a href="{{ route('password.remind') }}">Forgot your password?</a>
	</div>

	<br>

	<div class="center">
		<h3>Not yet a member? <a href="{{ route('users.register') }}" class="link">Register</a></h3>
	</div>

@stop

@section('javascripts')
@stop
