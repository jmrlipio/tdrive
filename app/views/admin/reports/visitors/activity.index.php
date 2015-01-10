@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="item-listing" id="categories-list">
		<h2>Game Buy Statistics</h2>
		<br>
		<table id="table">
			<thead>
			<tr>
				<th style="width: 300px;">Date</th>
				<th>User</th>
				<th>Action</th>
				<th>Total</th>
			</tr>
			<thead>
			<tbody>

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