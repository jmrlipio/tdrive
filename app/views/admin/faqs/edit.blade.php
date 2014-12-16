@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	
	{{ Form::model($faq, array('route' => array('admin.faqs.update', $faq->id), 'method' => 'put', 'class' => 'small-form')) }}
		<h2>Edit FAQ</h2>
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
@stop