@extends('admin._layouts.admin')

@section('content')
	{{ Form::model($variant, array('route' => array('admin.categories.variant.update', $variant->id), 'method' => 'put', 'class' => 'medium-form')) }}
		<h2>Add Variant</h2>

		<ul>
			<li>
				{{ Form::label('category', 'Category: ') }}
				<p>{{ $category->category }}</p>
			</li>
			<br>
			<li>
				{{ Form::label('language', 'Language:') }}
		  		<p>{{ $variant->language_id }}</p>			
			</li>
			<li>
				{{ Form::label('variant', 'Variant: ') }}
				{{ Form::textarea('variant', $variant->variant, array('class' => 'answer')) }}
				{{ $errors->first('variant', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::submit('Save') }}
				<a href="{{ URL::route('admin.categories.variant.delete', $variant->id) }}">Delete</a>
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