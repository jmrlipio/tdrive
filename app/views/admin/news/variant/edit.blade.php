@extends('admin._layouts.admin')

@section('content')
	<ul id='game-content-form'>
	{{ Form::open(array('route' => array('admin.news.variant.update', $news->id, $language_id), 'method' => 'put')) }}
		<h3>Edit Variant</h3>

		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<br>
		<li>
			{{ Form::label('main_title', 'Main Title:') }}
			{{ $news->main_title }}
		</li>
		<br>
		<li>
			{{ Form::label('language', 'Language:') }}
	  		{{ Form::select('language_id', $languages, $language_id) }}				
			{{ $errors->first('language', '<p class="error">:message</p>') }}
		</li>
		<br>
		<li>
			{{ Form::label('title', 'Variant Title:') }}	
			{{ Form::text('title', $data['title']) }}
		</li>
		<li>
			{{ Form::label('content', 'Content:') }}	
			{{ Form::textarea('content', $data['content'], array('id' => 'content')) }}
		</li>
		<li>
			{{ Form::label('excerpt', 'Excerpt:') }}	
			{{ Form::textarea('excerpt', $data['excerpt']) }}
		</li>

		{{ Form::submit('Update Variant', array('class' => 'fleft')) }}
	{{ Form::close() }}
	
	{{ Form::open(array('route' => array('admin.news.variant.delete', $news->id, $language_id), 'method' => 'delete', 'class' => 'delete-form')) }}
		{{ Form::submit('Delete', array('id' => 'delete-variant')) }}
	{{ Form::close() }}
	

	</ul>
	
	<script type="text/javascript">
		CKEDITOR.replace('content');

		$('#delete-variant').on('click', function(e) {
			if(!confirm("Are you sure you want to delete this item?")) e.preventDefault();
		});
	</script>
@stop

