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
			<!-- <tr>
				<td colspan="2"><a href="{{ URL::route('admin.users.edit', $user->id) }}" class="mgmt-link">Edit Account</a></td>
			</tr> -->
	</div>
@stop