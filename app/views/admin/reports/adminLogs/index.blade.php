@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="item-listing">
		<h2>Admin Login Activity</h2>
		<br>
		<table class="table table-striped table-bordered table-hover" id="logs_table">
			<thead>
				<tr>
					<th>Username</th>
					<th>Activity</th>
					<th>Date/Time</th>
				</tr>
			</thead>
			<tbody>
				@foreach($logs as $log)
					<tr>
						<td>
							@foreach($users as $user)
								@if($user->id == $log->user_id)
									{{ $user->username }}
								@endif
							@endforeach

						</td>
						<td>{{ $log->activity }}</td>
						<td>
							{{ Carbon::parse($log->created_at)->format('M j, Y') }} <br>
							{{ Carbon::parse($log->created_at)->format('g:i A') }}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="clear"></div>
	</div>
@stop

@section('scripts')
	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
	
	<script>
	(function(){
		$('#logs_table').DataTable( {
			"order": [[ 2, "desc" ]],
	         "oLanguage": {
                "sSearch": "<span>Search  </span> _INPUT_", //search
            }

		});
	})();
	</script>
@stop