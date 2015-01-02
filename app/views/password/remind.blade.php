@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style("css/form.css"); }}
@stop

@section('content')

	<h1 class="title">Reset password</h1>
	
	@if (Session::has('error'))

	  <p>{{ trans(Session::get('reason')) }}</p>

	@elseif (Session::has('success'))

	  <p>An email with the password reset has been sent.</p>

	@endif
	 
	{{ Form::open(array('route' => 'password.request', 'class' => 'forgot-password', 'id' => 'forgot-password-form')) }}  

		<div class="control">       
			{{ Form::text('email', null, array('placeholder'=>'email','required')) }}
		</div>

		<div class="control-item">
			 {{ Form::submit('Submit') }}
		</div>
	 
	{{ Form::close() }}

@stop
