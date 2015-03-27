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
			<div class="control">
				{{ Form::label(trans('global.email')) }}
				{{ Form::text(trans('global.email'), null, array('required')) }}
				{{ $errors->first('email', '<p class="error">:message</p>') }}
			</div>
			<li>
				{{ Form::label('mobile_no', 'Mobile No.:') }}
				{{ Form::text('mobile_no') }}
				{{ $errors->first('mobile_no', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::submit('Save') }}

			</li>
		 
		</ul> 

	{{ Form::close() }}

@stop