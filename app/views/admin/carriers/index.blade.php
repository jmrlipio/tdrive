@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.options-nav')
	<div class="item-listing" id="carriers-list">
		<h2>Carriers</h2>
		
		@if(Auth::user()->role != 'admin')
			<a href="{{ URL::route('admin.carriers.create') }}" class="mgmt-link">New Carrier</a>
		@endif
		
		<br>
		<table class="table table-striped table-bordered table-hover">
			<tr>
				<th>ID</th>
				<th>Carrier Name</th>
			</tr>
			@if(!$carriers->isEmpty())
				@foreach($carriers as $carrier)
					<tr>
						<td>{{ str_pad($carrier->id, 2, '0', STR_PAD_LEFT) }}</td>
						<td>
							<a href="{{ URL::route('admin.carriers.edit', $carrier->id) }}">{{ $carrier->carrier }}</a>
							@if(Auth::user()->role != 'admin')
								<ul class="actions">
									<li><a href="{{ URL::route('admin.carriers.edit', $carrier->id) }}">Edit</a></li>
									<li>
										{{ Form::open(array('route' => array('admin.carriers.destroy', $carrier->id), 'method' => 'delete', 'class' => 'delete-form')) }}
											{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
										{{ Form::close() }}
									</li>
								</ul>
							@endif
						</td>
					</tr>
				@endforeach
			@else
				<td><center>You haven't created any carriers yet.</center></td>
			@endif
		</table>
		<br>
		
	</div>

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