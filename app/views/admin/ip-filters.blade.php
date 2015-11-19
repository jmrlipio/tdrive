@extends('admin._layouts.admin')

@section('content')

	@include('admin._partials.options-nav')

<div class="item-listing">

	<a href="{{ URL::route('admin.ip-filters.get-create') }}" class="mgmt-link">Add IP</a>
	
	<div class="user_tbl_container">
		<h2>IP Address Whitelist</h2><br>
		<p><i>IP Address Whitelist are list of IPs that can access the website in desktop view and can access all carrier.</i></p>
		<br><br>

		<table class="table table-striped table-bordered table-hover" id="filter-table">
			<thead>
				<tr>
					<th>IP Addresses</th>
					<th>Action</th>
					<th>Added by</th>
					<th>Create Date</th>
				</tr>
			</thead>
			<tbody>
				@if(!$filters->isEmpty())
					@foreach($filters as $filter)
						<tr>
							<td>
								{{ $filter->ip_address }}
							</td>
							<td>
								{{ Form::open(array('route' => array('admin.ip-filters.delete', $filter->id), 'method' => 'delete', 'class' => 'delete-form fright')) }}
									{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
								{{ Form::close() }}
							</td>
							<td>{{ ($filter->added_by != 0 ? $filter->user->first_name. ' '. $filter->user->last_name : 'n/a') }}</td>
							<td>
								@if($filter->created_at != null)
									{{ Carbon::parse($filter->created_at)->format('M j, Y') }} <br>
									{{ Carbon::parse($filter->created_at)->format('g:i A') }}
								@else
									n/a
								@endif
							</td>
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan='4'><p class="center">No IP addresses added.</p></td>
					</tr>
				@endif
			</tbody>
		</table>

	</div>
</div>
	
@stop

@section('scripts')
{{ HTML::script('js/toastr.js') }}
{{ HTML::script('js/form-functions.js') }}
{{ HTML::script('js/jquery.dataTables.js') }}
{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}

<script>
$(document).ready(function() {
	$('#filter-table').DataTable({
		"order": [[ 3, "desc" ]],
		"oLanguage": {
            "sSearch": "<span>Search  </span> _INPUT_", //search
        }
	});

	<?php if( Session::has('message') ) : ?>
		var message = "{{ Session::get('message')}}";
		var success = '1';
		getFlashMessage(success, message);
	<?php endif; ?>
});
</script>
@stop