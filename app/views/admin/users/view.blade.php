@extends('admin._layouts.admin')

@section('content')
	<div class='item-listing users-lf' id='tab-container'>

		<div id="user-account" class="tab-container">

			<h2>{{ $user->username }}</h2>
			<br><br>
			
			<ul class='etabs'>
				<li class='tab'><a href="#information">Account Information</a></li>
				<li class='tab'><a href="#purchase">Games Purchased</a></li>
				<li class='tab'><a href="#login-history">Login History</a></li>
				<li class='tab'><a href="#activity-history">Activity History</a></li>
			</ul>

			<div class='panel-container'>	

				<div id="information">
					<table border="1" class="account-table">
						<tr>
							<td><strong>Email</strong></td>
						</tr>
						<tr>
							<td>{{ $user->email }}</td>
						</tr>

						<tr>
							<td><strong>Username</strong></td>
						</tr>
						<tr>
							<td>{{ $user->username }}</td>
						</tr>

						<tr>
							<td><strong>First Name</strong></td>
						</tr>
						<tr>
							<td>{{ $user->first_name }}</td>
						</tr>

						<tr>
							<td><strong>Last Name</strong></td>
						</tr>
						<tr>
							<td>{{ $user->last_name }}</td>
						</tr>

						<tr>
							<td><strong>Role</strong></td>
						</tr>
						<tr>
							<td>{{ $user->role }}</td>
						</tr>

						<tr>
							<td><strong>Mobile Number</strong></td>
						</tr>
						<tr>
							<td>{{ $user->mobile_no }}</td>				
						</tr>

						<tr>
							<td><strong>Registration Date</strong></td>
						</tr>
						<tr>
							<td>{{ Carbon::parse($user->created_at)->format('M d, Y') }}</td>				
						</tr>

					</table>
				</div>
					
				<div id="purchase">	
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
				</div>

				<div id="login-history">
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
				</div>
				
				<div id="activity-history">
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
				</div>

			</div>
		</div>
	</div>
		{{ HTML::script('js/form-functions.js') }}
		{{ HTML::script('js/jquery.dataTables.js') }}
		{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
		{{ HTML::script('js/jquery.easytabs.min.js') }}

	    <script>

			$(document).ready(function(){

			    $('#purchased_games').DataTable({
			    	"bLengthChange": false
			    });
			    $('#login_history').dataTable({
			    	"bLengthChange": false,
			        "order": [[ 0, "DESC" ]]
			    });
			    $('#activity_history').DataTable({
			        "order": [[ 2, "DESC" ]],
			        "bLengthChange": false
			    });

			// Initializes different tab sections
				$('.tab-container').easytabs();

				$('#tab-container > .etabs a').click(function() {
					$("html, body").animate({ scrollTop: 0 }, "slow");
		     		return false;
				});

			});
	    </script>
@stop