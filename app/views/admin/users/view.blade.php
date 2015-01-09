@extends('admin._layouts.admin')

@section('content')
	<div id="user-account">
		<h2>Account Information</h2>
		<table border="1">
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
		@if($games)
			<table border="1">
				<tr>
					<th>Game Title</th>
					<th>Carrier</th>
					<th>Country</th>
					<th>Price</th>
				</tr>
				@foreach($games as $game)
					<tr>
						<td>{{ $game['game_title'] }}</td>
						<td>{{ $game['carrier'] }}</td>
						<td>{{ $game['country'] }}</td>
						<td>{{ $game['currency'] . ' ' . $game['price'] }}</td>
					</tr>
				@endforeach
			</table>
		@else
			<p class="ml5">You have not purchased any games yet.</p>
		@endif

		<br/>

		<a href="#login_hx" id="inline" class="link ml5" ><span>Login History</span></a> |
	    <a href="#activity_hx" id="inline2" class="link ml5" ><span>Activity History</span></a>

	    <div style="display:none">
		    <div id="login_hx" style="text-align:center; width:800px; height: 500px;">
		    	<h4 style="margin: 10px 0;">Login History</h4>
		    </div>
	    </div>

	    <div style="display:none">
		    <div id="activity_hx" style="text-align:center; width:800px; height: 500px;">
		    	<h4 style="margin: 10px 0;">Activity History</h4>
		    </div>
	    </div>

	    <script>
	    	$("#inline").fancybox({
	            'titlePosition'     : 'inside',
	            'transitionIn'      : 'none',
	            'transitionOut'     : 'none'
	        });

	        $("#inline2").fancybox({
	            'titlePosition'     : 'inside',
	            'transitionIn'      : 'none',
	            'transitionOut'     : 'none'
	        });
	    </script>
		<!-- <tr>
			<td colspan="2"><a href="{{ URL::route('admin.users.edit', $user->id) }}" class="mgmt-link">Edit Account</a></td>
		</tr> -->
	</div>
@stop