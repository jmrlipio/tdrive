@extends('admin._layouts.admin')

@section('content')

@include('admin._partials.options-nav')

<div class='item-listing tab-container' id='tab-container'>
	
	<h2>Debug Settings</h2>
	<br><br>

	{{ Form::open(array('route' => array('admin.debug-settings.update'))) }}
		{{ Form::label('debug', 'Debug Settings: ') }}<br><br>
		
		@if(count($debug_settings) != null)

			@foreach($debug_settings as $debug)
				<input type="hidden" name="option_id" value="{{$debug->id}}">
					@if($debug->option_value == '1')
						<input checked name="settings" type="radio" value="1">Enable
					@else
						<input name="settings" type="radio" value="1">Enable
					@endif

					@if($debug->option_value == '0')
						<input checked name="settings" type="radio" value="0">Disable<br>
					@else
						<input name="settings" type="radio" value="0">Disable<br>
					@endif

			@endforeach

		@else

			<input name="settings" type="radio" value="1">Enable
			<input name="settings" type="radio" value="0">Disable<br>

		@endif
		

		{{ Form::submit('Submit') }}
	{{ Form::close() }}

</div>
	
@stop

@section('scripts')
{{ HTML::script('js/toastr.js') }}
{{ HTML::script('js/form-functions.js') }}
{{ HTML::script('js/jquery.dataTables.js') }}
{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}

<script>
$(document).ready(function() {

	<?php if( Session::has('message') ) : ?>
		var message = "{{ Session::get('message')}}";
		var success = '1';
		getFlashMessage(success, message);
	<?php endif; ?>
});
</script>
@stop