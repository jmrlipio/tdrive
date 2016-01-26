@extends('admin._layouts.admin')

@section('content')

	@include('admin._partials.options-nav')
	
		
	<div class='panel-container'>
		
		{{ Form::open(array('route' => array('admin.ip-filters.create'), 'method' => 'post', 'id' => 'add-ip', 'class' => 'small-form')) }}
			<h2>Add IP address</h2>
			
			{{ Form::label('ip_address', 'IP Address') }}<br>
			{{ Form::text('ip_address', null, array('class' => 'ip-address-tb')) }}<br>
			
			<a class="custom-back" href="{{ URL::route('admin.ip-filters') }}">Back</a>
			
			{{ Form::submit('Save', array('class' => 'auto-width')) }}
		{{ Form::close() }}
	</div>

@stop