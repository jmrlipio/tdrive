@extends('admin._layouts.admin')

@section('content')
	{{ Form::model($variant, array('route' => array('admin.categories.variant.update', $variant->id), 'method' => 'put', 'class' => 'medium-form')) }}
		<h2>Add Variant</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<ul>
			<li>
				{{ Form::label('category', 'Category: ') }}
				<p>{{ $category->category }}</p>
			</li>
			<br>
			<li>
				{{ Form::label('language', 'Language:') }}
		  		<p>{{ $variant->language_id }}</p>			
			</li>
			<li>
				{{ Form::label('variant', 'Variant: ') }}
				{{ Form::textarea('variant', $variant->variant, array('class' => 'answer')) }}
				{{ $errors->first('variant', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::submit('Save') }}
				<a href="{{ URL::route('admin.categories.variant.delete', $variant->id) }}">Delete</a>
			</li>
		</ul>

	{{ Form::close() }}
@stop