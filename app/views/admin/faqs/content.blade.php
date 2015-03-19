@extends('admin._layouts.admin')

@section('content')
	
	{{ Form::open(array('route' => array('admin.faq.edit.content', $faq->id, $language_id), 'method' => 'post', 'id' => 'faq-content')) }}
		<h3>{{ $faq->main_title }}</h3>
		<h4>{{ $language->language }} Content</h4>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<br>
		<li>
			{{ Form::label('question', 'Question:') }}	
			{{ Form::text('question', $question) }}
		</li>
		<li>
			{{ Form::label('answer', 'Answer:') }}	
			{{ Form::textarea('answer', $answer, array('id' => 'content')) }}
		</li>

		{{ Form::submit('Update Content') }} <a href="{{ URL::route('admin.faqs.edit', $faq->id) . '#faq-content' }}">Back</a>
	{{ Form::close() }}
	
	<script type="text/javascript">
		CKEDITOR.replace('content');
	</script>
@stop

