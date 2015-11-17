@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="item-listing table" >
		<h2>User Login Activity</h2>
		<br>
		<table id="table">
			<thead>
			<tr>
				<th style="width: 300px;">Date</th>
				<th>User</th>
				<th>Action</th>
				<th>Carrier</th>
				<th>Country</th>
				<th>Activity Message</th>
			</tr>
			<thead>
			<tbody>
				@foreach($activities as $activity)
					<tr>
						<td style="width: 20%;">{{ Carbon::parse($activity->created_at)->toDayDateTimeString() }}</td>
						<td style="width: 10%">{{ $activity->user->username }}</td>
						<td style="width: 10%">{{ $activity->action }}</td>
						<td style="width: 15%">{{ $activity->carrier }}</td>
						<td style="width: 15%">{{ $activity->country }}</td>
						<td style="width: 30%">{{ $activity->activity }}</td>
						
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="clear"></div>
	</div>
	{{ HTML::script('js/form-functions.js') }}
	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
	<script>
	$(document).ready(function() {
    	 $('#table').DataTable({
	        "order": [[ 0, "desc" ]]
	    });
	});
	</script>
@stop