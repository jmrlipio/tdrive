@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	
	{{ Form::model($language, array('route' => array('admin.languages.update', $language->id), 'method' => 'put', 'class' => 'small-form')) }}
		<h2>Edit Language</h2>

		<ul>
			<li>
				{{ Form::label('language', 'Language: ') }}
				{{ Form::text('language') }}
				{{ $errors->first('language', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('iso_code', 'ISO code: ') }}
				{{ Form::text('iso_code') }}
				{{ $errors->first('iso_code', '<p class="error">:message</p>') }}
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