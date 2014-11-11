@extends('admin._layouts.admin')

@section('content')
	<div class="item-listing" id="games-list">
		<h2>Games</h2>
		<br>
		<table>
			<tr>
				<th><input type="checkbox"></th>
				<th>Game Name</th>
				<th>Author</th>
				<th>Type</th>
				<th>Release Date</th>
				<th>Last Updated</th>

			</tr>
			@foreach($games as $game)
				<tr>
					<td><input type="checkbox"></td>
					<td>
						<a href="#">{{ $game->name }}</a>
						<ul class="actions">
							<li><a href="">Edit</a></li>
							<li><a href="">View</a></li>
							<li><a href="">Delete</a></li>
						</ul>
					</td>
					<td>{{ $game->user->username }}</td>
					<td>{{ $game->type->name }}</td>
					<td>{{ $game->release_date }}</td>
					<td>{{ $game->updated_at }}</td>
				</tr>
			@endforeach
		</table>
		<br>
		<a href="{{ URL::route('admin.games.create') }}" class="mgmt-link">New Game</a>
	</div>
	{{ HTML::script('js/jquery-1.11.1.js') }}
	<script>
	$(document).ready(function(){
		$('th input[type=checkbox]').click(function(){
			if($(this).is(':checked')) {
				$('td input[type=checkbox').prop('checked', true);
			} else {
				$('td input[type=checkbox').prop('checked', false);
			}
		});
	});
	</script>

@stop