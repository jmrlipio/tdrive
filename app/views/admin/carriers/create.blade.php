@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')

	{{ Form::open(array('route' => 'admin.carriers.store', 'class' => 'small-form')) }}
		<h2>Add New Carrier</h2>

		<ul>
			<li>
				{{ Form::label('id', 'Carrier ID:') }}
				{{ Form::text('id', null) }}
				{{ $errors->first('id', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('carrier', 'Carrier: ') }}
				{{ Form::text('carrier') }}
				{{ $errors->first('carrier', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('country_id', 'Countries: ') }}
				{{ Form::select('country_id[]', $countries, null, array('multiple' => 'multiple', 'class' => 'chosen-select', 'data-placeholder'=>'Choose country(s)...'))  }}
				{{ $errors->first('country_id', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('language_id', 'Default Language: ') }}
				{{ Form::select('language_id', $languages, null, array('placeholder' => 'Choose default language...')) }}
				{{ $errors->first('langauge_id', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::submit('Save') }}
			</li>
		</ul>

	{{ Form::close() }}

@stop

@section('scripts')
{{ HTML::script('js/toastr.js') }}
{{ HTML::script('js/chosen.jquery.js') }}
{{ HTML::script('js/form-functions.js') }}

<script type="text/javascript">
$(document).ready(function(){
	$(".chosen-select").chosen();

	<?php if( Session::has('message') ) : ?>
		var message = "{{ Session::get('message')}}";
		var success = '1';
		getFlashMessage(success, message);
	<?php endif; ?>

});	
</script>
@stop