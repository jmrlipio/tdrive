@extends('admin._layouts.admin')

@section('content')

	{{ Form::model($user, array('route' => array('admin.users.update', $user->id), 'method' => 'put', 'class' => 'small-form')) }}
		<h2>Edit User</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<ul>
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
				{{ Form::label('email', 'Email: ') }}
				{{ Form::text('email') }}
				{{ $errors->first('email') }}
			</li>
			<li>
				{{ Form::submit('Save') }}
			</li>
		</ul>
	{{ Form::close() }}
@stop