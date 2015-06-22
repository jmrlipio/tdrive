@extends('admin._layouts.admin')

@section('content')
	{{ Form::model($app, array('route' => array('admin.games.appslink.update', $app->id), 'method' => 'put', 'class' => 'medium-form')) }}
		<h2>Add Variant</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<ul>
			<li>
				{{ Form::label('Apps', 'Apps: ') }}
				<p>{{ $app->title }}</p>
			</li>
			<br>
			<li>
				{{ Form::label('link_name', 'Link name: ') }}
		  		{{ Form::text('link_name', $link->link_name, array('class' => 'link-name')) }}			
			</li>
			<li>
				{{ Form::label('url', 'Url: ') }}
				{{ Form::text('url', $link->url, array('class' => 'link-name')) }}
			</li>
			<li>
				{{ Form::submit('Save') }}
				<a href="{{ URL::route('admin.games.appslink.delete', $link->id) }}">Delete</a>
			</li>
		</ul>

	{{ Form::close() }}
@stop