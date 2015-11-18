@extends('admin._layouts.admin')

@section('content')
@include('admin._partials.options-nav')

{{ Form::open(array('route' => array('admin.reports.inquiries.save-settings'), 'method' => 'post', 'class' => 'large-form tab-container','id' => 'tab-container')) }}
	<h2>Auto Responder Settings </h2>

	<br>
<div >
		
	<ul>
		<li>
			{{ Form::label('subject', 'Subject') }}
			{{ Form::text('email_subject', $data['email_subject']); }}
			
			{{ Form::label('message', 'Automated Message' ) }}
			{{ Form::textarea('email_message', $data['email_message'], array('id' => 'text-content')) }}
		</li>
		<li>
			{{ Form::submit('Save', array('id' => 'save-news')) }}
		</li>
	</ul>

</div>
		
	{{ Form::close() }}

	
@stop

@section('scripts')
{{ HTML::script('js/toastr.js') }}
{{ HTML::script('js/tinymce/tinymce.min.js') }}

<script>
$(document).ready(function() {
	        // Initializes textarea editor for content and excerpt
    tinymce.init({
		mode : "specific_textareas",
		selector: "#text-content",
		height : 300
	});

	<?php if( Session::has('message') ) : ?>
		var message = "{{ Session::get('message')}}";
		var success = '1';
		getFlashMessage(success, message);
	<?php endif; ?>

});

</script>

@stop