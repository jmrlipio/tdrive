@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style("css/form.css"); }}
@stop

@section('content')

	@if (Session::has('fail'))

	  <p class="flash-fail">{{ trans(Session::get('reason')) }}</p>

	@endif

	@if(Session::has('success'))

	  <h3 class="center flash-success">{{ Session::get('success') }}</h3>

	@endif

	<h3 class="center">reset password</h3>
	 
	{{ Form::open(array('route' => 'password.request', 'class' => 'forgot-password', 'id' => 'forgot-password-form')) }}  

		<div class="control">       
			{{ Form::text('email', null, array('placeholder'=>'email','required')) }}
		</div>

		<div class="control-item">
			 {{ Form::submit('Submit') }}
		</div>
	 
	{{ Form::close() }}

@stop
