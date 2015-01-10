@extends('admin._layouts.admin')

@section('content')
	
	<ul>
		{{ Form::open(array('route' => 'admin.faqs.store', 'class' => 'small-form')) }}
			<h2>Create New FAQ</h2>
			@if(Session::has('message'))
			    <div class="flash-success">
			        <p>{{ Session::get('message') }}</p>
			    </div>
			@endif
			<li>
				{{ Form::label('main_question', 'Question: ') }}
				{{ Form::text('main_question') }}
				{{ $errors->first('main_question', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('language_id', 'Languages: ') }}
				{{ Form::select('language_id[]', $languages, null, array('multiple' => 'multiple', 'class' => 'chosen-select', 'data-placeholder'=>'Choose language(s)...'))  }}
				{{ $errors->first('language_id', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('order', 'Order: ') }}
				{{ Form::text('order', null, array('id' => 'faq-order')) }}
				{{ $errors->first('order', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::submit('Save') }}
			</li>
		{{ Form::close() }}
	</ul>
	
	{{ HTML::script('js/chosen.jquery.js') }}
	{{ HTML::script('js/form-functions.js') }}
	<script>
	(function(){
		$(".chosen-select").chosen();
	})();
	</script>

@stop