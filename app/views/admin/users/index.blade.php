@extends('admin._layouts.admin')

@section('content')
	<div class="item-listing">
		<table>
			<tr>
				<th>Username</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Last Login</th>
			</tr>
			@foreach($users as $user)
			<tr>
				<td>{{ $user->username }}</td>
				<td>{{ $user->first_name }}</td>
				<td>{{ $user->last_name }}</td>
				<td>{{ $user->last_login }}</td>
			</tr>
			@endforeach
		</table>
		<br>
		<a href="{{ URL::route('admin.users.create') }}" class="mgmt-link">Create User</a>
	</div>
@stop