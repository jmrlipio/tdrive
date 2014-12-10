@extends('_layouts.login')
@section('content')

	<div id="register">
		
		{{ Form::open(array('route'=>'users.register', 'id' => 'signup-form')) }}
			<p class="text-lg">Create new account</p>

			{{ Form::label('email') }}
			{{ Form::text('email',null,array('placeholder'=>'Input email', 'class'=> 'form-control','required')) }}
			{{ $errors->first('email', '<p class="error">:message</p>') }}

			{{ Form::label('username') }}
			{{ Form::text('username',null,array('placeholder'=>'Input username', 'class'=> 'form-control','required')) }}
			{{ $errors->first('username', '<p class="error">:message</p>') }}

			{{ Form::label('first_name') }}
			{{ Form::text('first_name',null,array('placeholder'=>'Input name', 'class'=> 'form-control','required')) }}
			{{ $errors->first('first_name', '<p class="error">:message</p>') }}
			
			{{ Form::label('last_name') }}
			{{ Form::text('last_name',null,array('placeholder'=>'Input last name', 'class'=> 'form-control','required' )) }}
			{{ $errors->first('last_name', '<p class="error">:message</p>') }}
			
			{{ Form::label('password') }}
			{{ Form::password('password',array('placeholder'=>'Input password','class'=> 'form-control','required')) }}
			{{ $errors->first('password', '<p class="error">:message</p>') }}

			{{ Form::label('password_confirmation') }}
			{{ Form::password('password_confirmation',array('placeholder'=>'Confirm password', 'class'=> 'form-control')) }}
			
			{{ Form::submit('Create new Account', array('class' => 'button button-pink')) }}
		{{ Form::close() }}
	</div>
@stop