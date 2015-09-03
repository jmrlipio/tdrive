@extends('admin._layouts.admin')

@section('content')
	<div id="user-account">
		<h2>Account Information</h2>
		<table border="1" class="account-table">
			<tr>
				<td><strong>Email:</strong></td>
				<td>{{ $user->email }}</td>
			</tr>
			<tr>
				<td><strong>Username:</strong></td>
				<td>{{ $user->username }}</td>
			</tr>
			<tr>
				<td><strong>First Name:</strong></td>
				<td>{{ $user->first_name }}</td>
			</tr>
			<tr>
				<td><strong>Last Name:</strong></td>
				<td>{{ $user->last_name }}</td>
			</tr>
			<tr>
				<td><strong>Role:</strong></td>
				<td>{{ $user->role }}</td>
			</tr>
		</table>
		<h2>Game Purchased</h2>
		@if(!empty($downloaded_games))
		<?php $ctr = 0; ?>	
			<div class="purchased_cont">
				<table class="table table-striped table-bordered table-hover purchased_games"  id="purchased_games">
					<thead>
						<tr>
							<th>Game Title</th>
							<th>Carrier</th>							
							<th>Price</th>
							<th>Purchase Date</th>
						</tr>
					</thead>

					<tbody>
						@foreach($downloaded_games["data"] as $app)							
							<tr>
								<td>{{ $app->title }}</td>
								<td>{{ $app->carrier->carrier }}</td>								
								<td>{{ $app->price.$app->currency_code }}</td>
								<td>{{ $downloaded_games["purchased_date"][$ctr] }}</td>									
							</tr>
							<?php $ctr++ ?>				
						@endforeach						
					</tbody>
				</table>
			</div>
		@else
			<p class="ml5">You have not purchased any games yet.</p>
		@endif

		<br/>

		<h2>Login History</h2>
		@if($histories)
			<div class="purchased_cont">
				<table class="table table-striped table-bordered table-hover purchased_games"  id="login_history">
					<thead>
						<tr>
							<th>Date</th>
							<th>Time Difference</th>
						</tr>
					</thead>

					<tbody>
						@foreach($histories as $history)
							<tr>
								<td>{{ Carbon::parse($history->logins)->format('M d, Y') }}</td>
								<!-- <td>{{ Carbon::parse($history->logins)->toDayDateTimeString(); }}</td> -->
								<td>{{ Carbon::parse($history->logins)->diffForHumans() }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@else
			<p class="ml5">This user has no login history.</p>
		@endif

		<br/>

		<h2>Activity History</h2>
		@if($activities)
			<div class="purchased_cont">
				<table class="table table-striped table-bordered table-hover purchased_games"  id="activity_history">
					<thead>
						<tr>
							<th>Activity</th>
							<th>Action</th>
							<th>Date Created</th>
							<th>Time Difference</th>
						</tr>
					</thead>

					<tbody>
						@foreach($activities as $activity)
							<tr>
								<td>{{ $activity->activity }}</td>
								<td>{{ $activity->action }}</td>
								<td>{{ Carbon::parse($activity->created_at)->format('M d, Y') }}</td>
								<td>{{ Carbon::parse($activity->created_at)->diffForHumans() }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@else
			<p class="ml5">This user has no activity history.</p>
		@endif

		<br/>
		<br/>
		<!-- <p class="ml5">This user has no activity history.</p> -->

		<!-- <a href="#login_hx" id="inline" class="link ml5" ><span>Login History</span></a> |
	    <a href="#activity_hx" id="inline2" class="link ml5" ><span>Activity History</span></a>

	    <div style="display:none">
		    <div id="login_hx" style="text-align:center; width:400px;">
		    	<h4 style="margin: 10px 0;">Login History</h4>
		    	<table border="1" style="margin: 0 auto;">
					<tr>
						<th>Date</th>
						<th>Time Difference</th>
					</tr>
					@foreach($histories as $login)
						<tr>
							<td>{{ $login->logins }}</td>
							<td>{{ $login->logins }}</td>
						</tr>
					@endforeach
		    	</table>
		    </div>
	    </div>

	    <div style="display:none">
		    <div id="activity_hx" style="text-align:center; width:400px;">
		    	<h4 style="margin: 10px 0;">Activity History</h4>
		    </div>
	    </div> -->

		

		<!-- <tr>
			<td colspan="2"><a href="{{ URL::route('admin.users.edit', $user->id) }}" class="mgmt-link">Edit Account</a></td>
		</tr> -->
	</div>
		{{ HTML::script('js/form-functions.js') }}
		{{ HTML::script('js/jquery.dataTables.js') }}
		{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
		<!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->

	    <script>
	    	// $("#inline").fancybox({
	     //        'titlePosition'     : 'inside',
	     //        'transitionIn'      : 'none',
	     //        'transitionOut'     : 'none'
	     //    });

	     //    $("#inline2").fancybox({
	     //        'titlePosition'     : 'inside',
	     //        'transitionIn'      : 'none',
	     //        'transitionOut'     : 'none'
	     //    });

			$(document).ready(function(){
			    $('#purchased_games').DataTable();
			    $('#login_history').dataTable({
			        "order": [[ 0, "DESC" ]]
			    });
			    $('#activity_history').DataTable({
			        "order": [[ 2, "DESC" ]]
			    });
			});
	    </script>
@stop