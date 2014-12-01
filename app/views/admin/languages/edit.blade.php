@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	
	{{ Form::model($language, array('route' => array('admin.languages.update', $language->id), 'method' => 'put', 'class' => 'small-form')) }}
		<h2>Edit Language</h2>
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