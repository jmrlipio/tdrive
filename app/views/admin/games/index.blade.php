@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="games-list">
		<h2>Games</h2>
		
		@if(Auth::user()->role != 'admin')
			<a href="{{ URL::route('admin.games.create') }}" class="mgmt-link">New Game</a>
		@endif

		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<br><br><br><br>

		<table class="table table-striped table-bordered table-hover"  id="game_table">
			<thead>
				<tr>
					<th><input type="checkbox"></th>
					<th>Game Name</th>
					<th>Categories</th>
					<th>Author</th>
					<th>Release Date</th>
					<th>Last Updated</th>
				</tr>
			</thead>

			<tbody>

				@forelse($games as $game)	
					<tr>
						<td><input type="checkbox"></td>
						<td>
							<a href="#">{{ $game->main_title }}</a>
							@if(Auth::user()->role != 'admin')
								<ul class="actions">							
									<li><a href="{{ URL::route('admin.games.edit', $game->id) }}">Edit</a></li>							
									<li><a href="#">View</a></li>
									<li>
										{{ Form::open(array('route' => array('admin.games.destroy', $game->id), 'method' => 'delete', 'class' => 'delete-form')) }}
											{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
										{{ Form::close() }}
									</li>
								</ul>
							@endif
						</td>
						<td>
							@foreach($game->categories as $gc)
								{{ $gc->category }}
							@endforeach
						</td>
						<td>{{ $game->user->username }}</td>
						<td>{{ $game->release_date }}</td>
						<td>{{ $game->updated_at }}</td>						
					
					</tr>

				@empty
					<tr class="tall-tr">
						<td colspan="6"><p>You haven't created any games yet.</p></td>
					</tr>
				
			@endforelse

			</tbody>
		</table>

		{{-- $games->links() --}}
		<br>
	</div>
	

@stop


@section('scripts')


	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}

	<script>
	$(document).ready(function(){
		$('#game_table').DataTable();
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