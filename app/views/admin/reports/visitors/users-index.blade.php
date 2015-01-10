@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="item-listing" id="categories-list">
		<h2>Game Sales</h2>
		<br>
		<table id="table">
			<thead>
			<tr>
				<th style="width: 300px;">User</th>
				<th style="width: 100px;">IP Address</th>
				<th style="width: 100px;">Platform</th>
				<th style="width: 300px;">Date</th>
			</tr>
			<thead>
			<tbody>
				@foreach($users as $user)

				<tr>
					<td style="width: 200px;">
						@if($user->username)
							{{ $user->username }}
						@else
							{{ Guest }}
						@endif
					</td>
					<td style="width: 200px;">{{ $user->client_ip }}</td>
					<td style="width: 200px;">{{ $user->kind }}/{{ $user->model }}/{{ $user->platform }}</td>
					<td style="width: 200px;">{{ Carbon::parse($user->created_at)->toDayDateTimeString() }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	{{ HTML::script('js/form-functions.js') }}
	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
	<script>
	$(document).ready(function() {
    	 $('#table').DataTable();
	});
	</script>
@stop