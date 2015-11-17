@extends('admin._layouts.admin')

@section('content')

	@include('admin._partials.options-nav')
	
	<div class="item-listing">
		
		<div id="user_tbl_container">
			<h2>Create IP Address Whitelist</h2>

			{{ Form::open(array('route' => array('admin.ip-filters.create'), 'method' => 'post', 'id' => 'add-ip')) }}
				{{ Form::label('ip_address', 'IP Address: ', array('class' => 'fleft')) }}
				{{ Form::text('ip_address', null, array('class' => 'ip-address-tb')) }}
				{{ Form::submit('Add IP') }}
			{{ Form::close() }}

		</div>

	</div>

@stop