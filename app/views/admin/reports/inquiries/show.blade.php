@extends('admin._layouts.admin')

@section('content')
@include('admin._partials.reports-nav')
{{ Form::model($inquiry, array('route' => array('admin.reports.inquiries.reply', $inquiry->id), 'method' => 'post', 'class' => 'large-form tab-container','id' => 'tab-container')) }}
	<h2>Inquiry </h2>
	@if(Session::has('message'))
        <div class="flash-success">
            <p>{{ Session::get('message') }}</p>           
        </div>
    @endif

	<br>
<div class='panel-container'>
		
	<ul id="content">
		<li>
			Name: {{ $inquiry->name }}
		</li>
		<li>
			Email: {{ $inquiry->email }}
		</li>
		<li>
			Message: {{ $inquiry->message }}
		</li>
	</ul>

	<ul>
		<li>
			{{ Form::label('message', 'Reply Message:') }}
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