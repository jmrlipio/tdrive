@extends('admin._layouts.admin')

@section('content')
	
	{{ Form::open(array('route' => array('admin.news.edit.content', $news->id, $language_id), 'method' => 'post', 'id' => 'game-content-form')) }}
		<h3>{{ $news->main_title }}</h3>
		<h4>{{ $language->language }} Content</h4>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<br>
		<li>
			{{ Form::label('title', 'Title:') }}	
			{{ Form::text('title', $title) }}
		</li>
		<li>
			{{ Form::label('content', 'Content:') }}	
			{{ Form::textarea('content', $content, array('id' => 'content')) }}
		</li>
		<li>
			{{ Form::label('excerpt', 'Excerpt:') }}	
			{{ Form::textarea('excerpt', $excerpt) }}
		</li>

		{{ Form::submit('Update Content') }} <a href="{{ URL::route('admin.news.edit', $news->id) . '#news-content' }}">Back</a>
	{{ Form::close() }}
	
	<script type="text/javascript">
		CKEDITOR.replace('content');
	</script>
@stop

