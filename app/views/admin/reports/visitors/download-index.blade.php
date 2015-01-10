@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="item-listing" id="categories-list">
		<h2>Game Download Statistics</h2>
		<br>
		<table id="table">
			<thead>
			<tr>
				<th style="width: 300px;">Game</th>
				<th>Carrier</th>
				<th>Country</th>
				<th>Total</th>
			</tr>
			<thead>
			<tbody>
				@foreach($games as $game) 
					<tr>
						<td style="width: 1000px">{{ $game['game_title'] }}</td>
						<td style="width: 100px">{{ $game['carrier'] }}</td>
						<td style="width: 300px">{{ $game['country'] }}</td>
						<td style="width: 300px">{{ $game['total'] }}</td>
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