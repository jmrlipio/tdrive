@extends('admin._layouts.admin')

@section('content')
	
	{{ Form::open(array('route' => array('admin.news.variant.store', $news->id), 'method' => 'post','class' => 'large-form tab-container', 'id' => 'game-content-form')) }}
		<h2>Add Variant</h2>

		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<br>

		<li>
			{{ Form::label('main_title', 'Main Title') }}
			{{ $news->main_title }}
		</li>
		<br>
		<li>
			{{ Form::label('language', 'Language') }}
	  		{{ Form::select('language_id', $languages) }}				
			{{ $errors->first('language', '<p class="error">:message</p>') }}
		</li>
		<br>
		<li>
			{{ Form::label('title', 'Variant Title') }}	
			{{ Form::text('title') }}
		</li>
		<li>
			{{ Form::label('content', 'Content') }}	
			{{ Form::textarea('content', null, array('id' => 'content')) }}
		</li>
		<li>
			{{ Form::label('excerpt', 'Excerpt') }}	
			{{ Form::textarea('excerpt') }}
		</li>

		<a class="custom-back" href="{{ URL::route('admin.news.index') }}">Back</a>
		{{ Form::submit('Add Variant') }} 
				
	{{ Form::close() }}

	<script type="text/javascript">
		CKEDITOR.replace('content');
	</script>
@stop

