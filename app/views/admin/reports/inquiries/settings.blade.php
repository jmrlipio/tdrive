@extends('admin._layouts.admin')

@section('content')
@include('admin._partials.reports-nav')
{{ Form::open(array('route' => array('admin.reports.inquiries.save-settings'), 'method' => 'post', 'class' => 'large-form tab-container','id' => 'tab-container')) }}
	<h2>Inquiry </h2>
	@if(Session::has('message'))
        <div class="flash-success">
            <p>{{ Session::get('message') }}</p>           
        </div>
    @endif

	<br>
<div class='panel-container'>
		
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

	{{ HTML::script('js/tinymce/tinymce.min.js') }}

	<script>
	$(document).ready(function() {
		        // Initializes textarea editor for content and excerpt
        tinymce.init({
			mode : "specific_textareas",
			selector: "#text-content",
			height : 300
		});

	});

    </script>
@stop