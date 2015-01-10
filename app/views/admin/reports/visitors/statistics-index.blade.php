@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="item-listing" id="categories-list">
		<h2>Game Statistics</h2>
		<br>
		<table id="table">
			<thead>
			<tr>
				<th style="width: 300px;">Game</th>
				<th>Buy Clicks</th>
				<th>Download Clicks</th>
			</tr>
			<thead>
			<tbody>
				@foreach($games as $game) 
					<tr>
						<td style="width: 1000px">{{ $game->main_title }}</td>
						<td style="width: 100px"><a href="{{ URL::route('admin.reports.visitors.statistics.buy', $game->id) }}">View</a></td>
						<td style="width: 300px"><a href="{{ URL::route('admin.reports.visitors.statistics.download', $game->id) }}">View</a></td>
					</tr>
				@endforeach	
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