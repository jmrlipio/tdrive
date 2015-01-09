@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="item-listing" id="categories-list">
		<h2>Download Reports</h2>
		<br>
		<table id="table">
			<thead>
			<tr>
				<th style="width: 300px;">Game</th>
				<th style="width: 120px !important;" >Real Downloads</th>
				<th>Modified Downloads</th>
				<th>Success Downloads</th>
				<th>Failed Downloads</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
		</table>
	</div>
	{{ HTML::script('js/form-functions.js') }}
	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
	<script>
	$(document).ready(function(){
	    $('#table').DataTable();
		});
	</script>
@stop