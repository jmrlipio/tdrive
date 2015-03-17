@extends('admin._layouts.admin')

@section('content')
	{{ Form::open(array('route' => 'admin.users.store', 'class' => 'small-form')) }}
		<ul>
			<li>
				{{ Form::label('username', 'Username:') }}
				{{ Form::text('username') }}
				{{ $errors->first('username', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('password', 'Password:') }}
				{{ Form::password('password') }}
				{{ $errors->first('username', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('password_confirmation', 'Confirm Password:') }}
				{{ Form::password('password_confirmation')  }}
				{{ $errors->first('username', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('first_name', 'First Name:') }}
				{{ Form::text('first_name') }}
				{{ $errors->first('first_name', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('last_name', 'Last Name:') }}
				{{ Form::text('last_name') }}
				{{ $errors->first('last_name', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::submit('Save') }}

			</li>
		 
		</ul> 

	{{ Form::close() }}

@stop