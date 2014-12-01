@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')

	{{ Form::open(array('route' => 'admin.platforms.store', 'class' => 'small-form')) }}
		<h2>Add New Platform</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<ul>
			<li>
				{{ Form::label('platform', 'Platform: ') }}
				{{ Form::text('platform', null, array('class' => 'slug-reference')) }}
				{{ $errors->first('platform', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('slug', 'Slug: ') }}
				{{ Form::text('slug', null, array('class' => 'slug')) }}
				{{ $errors->first('slug', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::submit('Save') }}
			</li>
		</ul>

	{{ Form::close() }}
	{{ HTML::script('js/form-functions.js') }}

@stop