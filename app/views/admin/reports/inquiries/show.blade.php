@extends('admin._layouts.admin')

@section('content')
{{ Form::model($inquiry, array('route' => array('admin.reports.inquiries.reply', $inquiry->id), 'method' => 'post', 'class' => 'large-form tab-container','id' => 'tab-container')) }}
	<h2>Inquiry </h2>
	@if(Session::has('message'))
        <div class="flash-success">
            <p>{{ Session::get('message') }}</p>           
        </div>
    @endif

	<br>
<div>
		
	<ul id="content" class="show-inquiry">
		<li>
			<h3>Name: <span>{{ $inquiry->name }}</span></h3> 
		</li>
		<li>
			<h3>Email: <span>{{ $inquiry->email }}</span></h3> 
		</li>
		<li>
			<h3>Message: <span>{{ $inquiry->message }}</span></h3> 
		</li>
	</ul>

	<ul>
		<li>
			{{ Form::label('message', 'Reply Message') }}
			{{ Form::textarea('message', '', array('id' => 'text-content')) }}
		</li>
		<li>
			<a href="{{ URL::route('admin.reports.inquiries.index') }}" class="custom-back">Back</a>{{ Form::submit('Reply', array('id' => 'save-news')) }}
		</li>
	</ul>

</div>
		
	{{ Form::close() }}

@stop

@section('scripts')
	{{ HTML::script('js/toastr.js') }}
	{{ HTML::script('js/form-functions.js') }}	
	{{ HTML::script('js/tinymce/tinymce.min.js') }}

	<script>
	$(document).ready(function() {
		// Initializes textarea editor for content and excerpt
        tinymce.init({
			mode : "specific_textareas",
			selector: "#text-content",
			height : 300
		});

		<?php if( Session::has('error') ) : ?>
			var message = "{{ Session::get('error')}}";
			var success = '0';
			getFlashMessage(success, message);

		<?php endif; ?>

	});

    </script>
@stop