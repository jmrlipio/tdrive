@extends('admin._layouts.admin')

@section('content')
	{{ Form::model($faq, array('route' => array('admin.faqs.variant.store', $faq->id), 'method' => 'post', 'class' => 'medium-form')) }}
		<h2>Add Variant</h2>

		<ul>
			<li>
				{{ Form::label('main_question', 'Main Question: ') }}
				<p>{{ $faq->main_question }}</p>
				{{ $errors->first('main_question', '<p class="error">:message</p>') }}
			</li>
			<br>
			<li>
				{{ Form::label('language', 'Language:') }}
		  		{{ Form::select('language_id', $languages) }}				
				{{ $errors->first('language', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('variant', 'Variant: ') }}
				{{ Form::textarea('variant', null, array('class' => 'answer')) }}
				{{ $errors->first('variant', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::submit('Save') }}
			</li>
		</ul>

	{{ Form::close() }}
@stop

@section('scripts')
{{ HTML::script('js/toastr.js') }}
{{ HTML::script('js/form-functions.js') }}

<script type="text/javascript">
$(document).ready(function(){
	
	<?php if( Session::has('message') ) : ?>
		var message = "{{ Session::get('message')}}";
		var success = '1';
		getFlashMessage(success, message);
	<?php endif; ?>

});	
</script>
@stop