@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style("css/form.css"); }}
@stop

@section('content')

<div id="forgot-password">
		
	<h3 class="center">Please fill up this form to reset your password</h3>
	
	<div class="center">
		@if (Session::has('error') ) 
            
        	<h3 class="center flash-fail"> {{ trans(Session::get('error')) }}</h3> 

        @endif	 

		{{ Form::open(array('route' => 'password.update', 'class' => 'forgot-password', 'id' => 'forgot-password-form')) }}

			<div class="control">
			    {{ Form::text('email', null, array('placeholder'=>'email','required')) }}
			    {{ $errors->first('email', '<p class="error">:message</p>') }}
			</div>

			<div class="control">
			    {{ Form::password('password', array('placeholder'=>'password','required')) }}
			    {{ $errors->first('password', '<p class="error">:message</p>') }}
			</div>

			<div class="control">
			    {{ Form::password('password_confirmation', array('placeholder'=>'confirm password','required')) }}
			    {{ $errors->first('password_confirmation', '<p class="error">:message</p>') }}
			    {{ Form::hidden('token', $token) }}
			</div>

			<div class="control-group clearfix">                    

			    <div class="control-item">
			         {{ Form::submit('Submit',  ['class' => 'button button-pink']) }}
			    </div>
			</div>

		{{ Form::close() }}

	</div>
</div>

@stop