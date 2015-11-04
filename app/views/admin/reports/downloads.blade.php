@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="item-listing table" id="categories-list">
		<h2>Download Reports</h2>
		<br>
		<table id="table">
			<thead>
			<tr>
				<th style="width: 300px;">Game</th>
				<th style="width: 120px !important;" >Real Downloads</th>
				<th>Modified Downloads</th>
			</tr>
		</thead>
		<tbody>
			@foreach($games as $game)
				<tr>
					<td>{{ $game->main_title }}</td>
					<td style="width: 120px !important;">{{ $game->actual_downloads }}</td>
					<td>{{ $game->downloads }}</td>
				</tr>
			@endforeach
		</tbody>
		</table>
		<div class="clear"></div>
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