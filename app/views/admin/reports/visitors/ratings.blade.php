@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="item-listing" id="categories-list">
		<h2>Total Game Ratings</h2>
		<br>
		<table id="table">
			<thead>
			<tr>
				<th style="width: 300px;">Game</th>
				<th>Ratings</th>
				<th>Review Count</th>
			</tr>
			<thead>
			<tbody>
				@foreach($games as $game)
				<tr>
					<td style="width: 300px;">{{ $game->main_title }}</td>
					<td>
						<?php  $ratings = Review::getRatings($game->id) ?>
						@if($ratings)
							<p style="display:none;"></p>
							@if($ratings['average'] == 1)
								<i class="fa fa-star"></i>
							@elseif($ratings['average'] == 2)
								<i class="fa fa-star"></i><i class="fa fa-star"></i>
							@elseif($ratings['average'] == 3)
								<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
							@elseif($ratings['average'] == 4)
								<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
							@else
								<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
							@endif
						@else
							<p>N/A</p>
						@endif
					</td>
					<td style="width: 300px;"><a href="{{ URL::route('admin.game.reviews', $game->id) }}">{{ $ratings['count'] }}</a></td>
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