@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	
	{{ Form::open(array('route' => 'admin.languages.store', 'class' => 'small-form')) }}
		<h2>Create New Language</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<ul>
			<li>
				{{ Form::label('language', 'Language: ') }}
				{{ Form::text('language') }}
				{{ $errors->first('language', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::submit('Save') }}
			</li>
		</ul>

	{{ Form::close() }}
@stop