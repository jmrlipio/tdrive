@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="games-list">
		<h2>Games</h2>
		<br>
		<table>
			<tr>
				<th><input type="checkbox"></th>
				<th>Game Name</th>
				<th>Author</th>
				<th>Release Date</th>
				<th>Last Updated</th>
			</tr>
			@if(!$games->isEmpty())
				@foreach($games as $game)
					<tr>
						<td><input type="checkbox"></td>
						<td>
							<a href="#">{{ $game->title }}</a>
							<ul class="actions">
								<li><a href="{{ URL::route('admin.games.edit', $game->id) }}">Edit</a></li>
								<li><a href="#">View</a></li>
								<li>
									{{ Form::open(array('route' => array('admin.games.destroy', $game->id), 'method' => 'delete', 'class' => 'delete-form')) }}
										{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
									{{ Form::close() }}
								</li>
							</ul>
						</td>
						<td>{{ $game->user->username }}</td>
						<td>{{ $game->release_date }}</td>
						<td>{{ $game->updated_at }}</td>
					</tr>
				@endforeach
			@else
				<tr class="tall-tr">
					<td colspan="6"><p>You haven't created any games yet.</p></td>
				</tr>
			@endif
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