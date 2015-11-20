@extends('admin._layouts.admin')

@section('content')
	{{ Form::model($inquiry, array('route' => array('admin.reports.inquiries.reply', $inquiry->id), 'method' => 'post', 'class' => 'item-listing tab-container','id' => 'tab-container')) }}
		<h2>Inquiry </h2>

		<br>
		<div>
				
			<ul id="content" class="show-inquiry">
				<li>
					{{ Form::label('name', 'Name') }}
					<p>{{ $inquiry->name }}</p>
				</li>
				<li>
					{{ Form::label('email', 'Email') }}
					<p>{{ $inquiry->email }}</p>
				</li>
				<li>
					{{ Form::label('message', 'Message') }}
					<p>{{ $inquiry->message }}</p> 
				</li>
			</ul>

			<ul>
				<li>
					{{ Form::label('message', 'Reply Message') }}
					{{ Form::textarea('message', '', array('id' => 'text-content')) }}
				</li>
				<li>
					<a href="{{ URL::route('admin.reports.inquiries.index') }}" class="custom-back">Back</a>{{ Form::submit('Send', array('id' => 'save-news')) }}
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