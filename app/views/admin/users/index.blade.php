@extends('admin._layouts.admin')

@section('content')
	<div class="item-listing">
		<h2>Users</h2>
		<br>
		{{ Form::open(array('route' => 'admin.users.roles','class' => 'simple-form', 'id' => 'submit-role', 'method' => 'get')) }}
			{{ Form::select('role', $roles, $selected, array('class' => 'select-filter', 'id' => 'select-role')) }}
		{{ Form::close() }}
		<table>
			<tr>
				<th><input type="checkbox"></th>
				<th>Name</th>
				<th>Username</th>
				<th>email</th>
				<th>Role</th>
				<th>Last Login</th>
				<th>Last Activity</th>
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
				<td>{{ $user->email }}</td>
				<td>{{ $user->role }}</td>
				<td>{{ $user->last_login }}</td>
				<td>{{ $user->last_login }}</td>
			</tr>
			@endforeach

		</table>
		{{ $users->links() }}
		<br>
		<a href="{{ URL::route('admin.users.create') }}" class="mgmt-link">Create User</a>
	</div>
	<script>
	$('#select-role').on('change', function() {
		$('#submit-role').trigger('submit');
	});
	</script>
@stop