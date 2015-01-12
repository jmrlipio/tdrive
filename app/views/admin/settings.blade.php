@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.options-nav')
	{{ Form::open(array('route' => array('admin.general-settings.update'), 'method' => 'post', 'class' => 'small-form', 'id' => 'general-settings')) }}
	<h2>General Settings</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<?php $count = 0; ?>
		@foreach($settings as $setting)
			<li>
				{{ Form::label($setting->setting, $setting->setting) }}
				{{ Form::text('settings[' . $count .'][value]', $setting->value) }}
				{{-- $errors->first('value', '<p class="error">:message</p>') --}}
				{{ Form::hidden('settings[' . $count . '][id]', $setting->id) }}
			</li>
			<?php $count++; ?>
		@endforeach
		{{ Form::submit('Update Settings') }}
	{{ Form::close() }}
@stop