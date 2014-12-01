@extends('admin._layouts.admin')

@section('content')
	<div class="item-listing">
		<h2>Users</h2>
		<br>
		<table>
			<tr>
				<th><input type="checkbox"></th>
				<th>Name</th>
				<th>Username</th>
				<th>Last Login</th>
			</tr>
			@foreach($users as $user)
			<tr>
				<td><input type="checkbox"></td>
				<td>
					<a href="#">{{ $user->first_name . ' ' . $user->last_name }}</a>
					<ul class="actions">
						<li><a href="">Edit</a></li>
						<li><a href="">View</a></li>
						<li><a href="">Delete</a></li>
					</ul>
				</td>
				<td>{{ $user->username }}</td>
				<td>{{ $user->last_login }}</td>
			</tr>
			@endforeach

		</table>
		{{ $users->links() }}
		<br>
		<a href="{{ URL::route('admin.users.create') }}" class="mgmt-link">Create User</a>
	</div>
@stop