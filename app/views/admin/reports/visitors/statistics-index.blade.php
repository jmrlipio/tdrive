@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="item-listing table" id="categories-list">
		<h2>Game Page Views</h2>
		<br>
		<table id="table">
			<thead>
			<tr>
				<th style="width: 300px;">Game</th>
				<th>Buy Clicks</th>
				<th>Download Clicks</th>
				<th>Hits</th>
			</tr>
			<thead>
			<tbody>
				@foreach($games as $game) 
					<tr>
						<td style="width: 1000px">{{ $game->main_title }}</td>
						<td style="width: 150px"><a href="{{ URL::route('admin.reports.visitors.statistics.buy', $game->id) }}">{{ Transaction::countTransaction($game->id) }}</a></td>
						<td style="width: 300px"><a href="{{ URL::route('admin.reports.visitors.statistics.download', $game->id) }}">{{ Download::getTotal($game->id) }}</a></td>
						<td style="width: 150px">{{ $game->hits }}</td>
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
	$(document).ready(function() {
    	 $('#table').DataTable({
        	"bAutoWidth": false,
	        "aoColumnDefs": [
	            { "sWidth": "14.5%", "aTargets": [ 1,2,3 ] }
	        ]
	    });
	});
	</script>
@stop