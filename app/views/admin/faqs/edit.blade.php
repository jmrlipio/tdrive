@extends('admin._layouts.admin')

@section('content')
		<ul class='medium-form'>
			{{ Form::model($faq, array('route' => array('admin.faqs.variant.update', $faq->id, $language_id), 'method' => 'put')) }}
				<h2>Edit Variant</h2>
				@if(Session::has('message'))
				    <div class="flash-success">
				        <p>{{ Session::get('message') }}</p>
				    </div>
				@endif
				<li>
					{{ Form::label('main_question', 'Main Question: ') }}
					{{ Form::text('main_question') }}
					{{ $errors->first('main_question', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('order', 'Order: ') }}
					{{ Form::text('order', null, array('id' => 'faq-order')) }}
					{{ $errors->first('order', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('language', 'Language:') }}
			  		{{ Form::select('language_id', $languages, $language_id) }}				
					{{ $errors->first('language', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('question', 'Question: ') }}
					{{ Form::text('question', $question) }}
					{{ $errors->first('question', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('answer', 'Answer: ') }}
					{{ Form::textarea('answer', $answer, array('class' => 'answer')) }}
					{{ $errors->first('answer', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('default', 'Set as Default:')}}
					{{ Form::select('default', array('0' => 'No', '1' => 'Yes'), $default) }}
				</li>
				{{ Form::submit('Save', array('class' => 'fleft')) }}
			{{ Form::close() }}

			{{ Form::open(array('route' => array('admin.faqs.variant.delete', $faq->id, $language_id), 'method' => 'delete', 'class' => 'delete-form')) }}
				{{ Form::submit('Delete', array('id' => 'delete-variant')) }}
			{{ Form::close() }}
		</ul>
		

	
	
@stop

@section('scripts')
	<script>
		$('#delete-variant').on('click', function(e) {
			if(!confirm("Are you sure you want to delete this item?")) e.preventDefault();
		});
	</script>
@stop