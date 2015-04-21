@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.options-nav')

	<div class="small-form">
		<h2>IP Filters</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<table id="filters">
			<tr>
				<th>IP Addresses</th>
			</tr>
			@if(!$filters->isEmpty())
				@foreach($filters as $filter)
					<tr>
						<td>
							{{ $filter->ip_address }}
							{{ Form::open(array('route' => array('admin.ip-filters.delete', $filter->id), 'method' => 'delete', 'class' => 'delete-form fright')) }}
								{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
							{{ Form::close() }}
						</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td><p class="center">No IP addresses added.</p></td>
				</tr>
			@endif
		</table>

		{{ Form::open(array('route' => array('admin.ip-filters.create'), 'method' => 'post', 'id' => 'add-ip')) }}
			{{ Form::label('ip_address', 'IP Address: ', array('class' => 'fleft')) }}
			{{ Form::text('ip_address', null, array('class' => 'ip-address-tb')) }}
			{{ Form::submit('Add IP') }}
		{{ Form::close() }}
	</div>
	
@stop