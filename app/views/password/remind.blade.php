@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style("css/form.css"); }}
@stop

@section('content')

	
	@if (Session::has('error'))

	  <p>{{ trans(Session::get('reason')) }}</p>

	@endif

	@if(Session::has('message'))

	  <h3 class="center">{{ Session::get('message') }}</h3>

	@endif

	<h3>reset password</h3>
	 
	{{ Form::open(array('route' => 'password.request', 'class' => 'forgot-password', 'id' => 'forgot-password-form')) }}  

		<div class="control">       
			{{ Form::text('email', null, array('placeholder'=>'email','required')) }}
		</div>

		<div class="control-item">
			 {{ Form::submit('Submit') }}
		</div>
	 
	{{ Form::close() }}

@stop
