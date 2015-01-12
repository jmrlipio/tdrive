@extends('admin._layouts.admin')

@section('content')
	{{ Form::open(array('route' => 'admin.faqs.store', 'class' => 'small-form')) }}
		<h2>Create New FAQ</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<ul>
			<li>
				{{ Form::label('question', 'Question: ') }}
				{{ Form::text('question') }}
				{{ $errors->first('question', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('answer', 'Answer: ') }}
				{{ Form::textarea('answer', null, array('class' => 'answer')) }}
				{{ $errors->first('answer', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('order', 'Order: ') }}
				{{ Form::text('order', null, array('id' => 'faq-order')) }}
				{{ $errors->first('order', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::submit('Save') }}
			</li>
		</ul>

	{{ Form::close() }}
	{{ HTML::script('js/form-functions.js') }}

@stop