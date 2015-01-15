@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="games-list">
		<h2>{{ $game->main_title}} Reviews</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<table class="table table-striped table-bordered table-hover"  id="game_table">
			<thead>
				<tr>
					<th>Username</th>
					<th>Review</th>
					<th>Rating</th>
				</tr>
			</thead>

			<tbody>
				@foreach($game->review as $review)	
					<tr>
						<td>{{ $review->username }}</td>
						<td>{{ $review->pivot->review }}</td>
						<td>
							{{-- $review->pivot->rating --}}
							@for($i = 1; $i <= 5; $i++)
								<i class="fa fa-star{{ ($i <= $review->pivot->rating) ? '' : '-empty' }}"></i>
							@endfor
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<br>
	</div>
	

@stop


@section('scripts')

	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
	{{ HTML::script('js/form-functions.js') }}

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

		$('#select-cat').on('change', function() {
			$('#submit-cat').trigger('submit');
		});
	});

	</script>
@stop
