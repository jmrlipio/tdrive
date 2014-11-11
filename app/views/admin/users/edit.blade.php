@extends('admin._layouts.admin')

@section('content')
	{{ Form::model($user, array('route' => array('admin.users.update', $user->id), 'method' => 'put')) }}
		<li>
			{{ Form::label('first_name', 'First Name: ') }}
			{{ Form::text('first_name') }}
			{{ $errors->first('first_name') }}
		</li>
		<li>
			{{ Form::label('last_name', 'Last Name: ') }}
			{{ Form::text('last_name') }}
			{{ $errors->first('last_name') }}
		</li>
		<li>
			<a href="#">Change Password</a>
		</li>

		<li>
			{{ Form::submit('Save') }}
		</li>

	{{ Form::close() }}
@stop