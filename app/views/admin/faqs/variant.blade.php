@extends('admin._layouts.admin')

@section('content')
	{{ Form::model($faq, array('route' => array('admin.faqs.variant.store', $faq->id), 'method' => 'post', 'class' => 'medium-form')) }}
		<h2>Add Variant</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<ul>
			<li>
				{{ Form::label('main_question', 'Main Question ') }}
				<p>{{ $faq->main_question }}</p>
				{{ $errors->first('main_question', '<p class="error">:message</p>') }}
			</li>
			<br>
			<li>
				{{ Form::label('language', 'Language') }}
		  		{{ Form::select('language_id', $languages) }}				
				{{ $errors->first('language', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('question', 'Question ') }}
				{{ Form::text('question') }}
				{{ $errors->first('question', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('answer', 'Answer ') }}
				{{ Form::textarea('answer', null, array('class' => 'answer')) }}
				{{ $errors->first('answer', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('default', 'Set as Default')}}
				{{ Form::select('default', array('0' => 'No', '1' => 'Yes')) }}
			</li>
			<li>
				{{ Form::submit('Save') }}
			</li>
		</ul>

	{{ Form::close() }}
@stop