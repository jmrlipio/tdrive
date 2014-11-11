@extends('admin._layouts.admin')

@section('content')
	<div id="user-account">
		<h2>Account Information</h2>
		<table>
			<tr>
				<td>Username:</td>
				<td>{{  $user->username }}</td>
			</tr>
			<tr>
				<td>Last Name:</td>
				<td>{{  $user->last_name }}</td>
			</tr>
			<tr>
				<td>First Name:</td>
				<td>{{  $user->first_name }}</td>
			</tr>
			<tr>
				<td colspan="2"><a href="{{ URL::route('admin.users.edit', $user->id) }}" class="mgmt-link">Edit Account</a></td>
			</tr>
		</table>
	</div>
@stop