@extends('admin._layouts.admin')
@section('stylesheets')
	<style>
		p.published {color: green;}
		p.draft {color: #555;}
		tr th:first-of-type { width: 25px !important; }
	</style>
@stop
@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="games-list">
		<h2>Games</h2>
		
		@if(Auth::user()->role != 'admin')
			<a href="{{ URL::route('admin.games.create') }}" class="mgmt-link">Create Game</a>
		@endif

		{{ Form::open(array('route' => 'admin.game.category','class' => 'simple-form', 'id' => 'submit-cat', 'method' => 'get')) }}
			{{ Form::label('game_category', 'Category') }}
			{{ Form::select('game_category', $categories, $selected, array('class' => 'select-filter', 'id' => 'select-cat')) }}
		{{ Form::close() }}
		
		<button id="delete-btn" class="btn-delete">Delete Selected</button>
		<form method="POST" action="{{ URL::route('admin.games.destroy') }}">
		{{ Form::token() }}

		<table class="table table-striped table-bordered table-hover"  id="game_table">
			<thead>
				<tr>
					<th class="no-sort"><input type="checkbox"></th>
					<th>Game Name</th>
					<th>Status</th>
					<th>Categories</th>
					<th>Author</th>
					<th>Release Date</th>
					<th>Last Updated</th>
				</tr>
			</thead>

			<tbody>
				
				@foreach($games as $game)	
					<tr>
						<td><input type="checkbox"></td>
						<td>
							<a href="{{ URL::route('admin.games.edit', $game->id) }}">{{ $game->main_title }}</a>
							@if(Auth::user()->role != 'admin')
								<ul class="actions">							
									<li><a href="{{ URL::route('admin.games.edit', $game->id) }}">Edit</a></li>							
									<li><a href="{{ URL::route('admin.games.edit', $game->id) }}">View</a></li>
									<li>
										{{ Form::open(array('route' => array('admin.games.destroy', $game->id), 'method' => 'delete', 'class' => 'delete-form')) }}
											{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
										{{ Form::close() }}
									</li>
								</ul>
							@endif
						</td>
						<td>
							{{ ( $game->status == 'live' ) ? '<p class="published">Published</p>' : '<p class="draft">Draft</p>'  }}
						</td>
						<td>
							@foreach($game->categories as $gc)
								<a href="{{ Request::root().'/admin/game/categories?game_category='.$gc->id }}">{{ $gc->category. (count($game->categories) > 1 ? ',' : '') }}</a>								
							@endforeach

						</td>
						<td>{{ $game->user->username }}</td>
						<td>{{ $game->release_date }}</td>
						<td>{{ $game->updated_at }}</td>						
					
					</tr>
				
				@endforeach
				<?php $ctr = 0; ?>
			</tbody>
		</table>

		<br>
	</div>
	

@stop


@section('scripts')

	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
	{{ HTML::script('js/toastr.js') }}
	{{ HTML::script('js/form-functions.js') }}

	<script>
	$(document).ready(function(){
		$('#game_table').DataTable({
	        "order": [[ 6, "desc" ]],
	        "bLengthChange": false,
	    });
		$('th input[type=checkbox]').click(function(){
			
			if($(this).is(':checked')) 
			{
				$('td input[type=checkbox').prop('checked', true);
			} 
			else 
			{
				$('td input[type=checkbox').prop('checked', false);
			}

			if(!$("input[type='checkbox'].chckbox").is(':checked'))
			{
				$('#delete-btn').prop('disabled', true);
				$('#delete-btn').addClass('btn-delete-disabled');
				$('#delete-btn').removeClass('btn-delete-enabled');
			}
			else 
			{
				$('#delete-btn').prop('disabled', false);
				$('#delete-btn').removeClass('btn-delete-disabled');
				$('#delete-btn').addClass('btn-delete-enabled');
			}
		});

		$('.chckbox').change(function() {
			if(!$("input[type='checkbox'].chckbox").is(':checked'))
			{
				$('#delete-btn').prop('disabled', true);
				$('#delete-btn').addClass('btn-delete-disabled');
				$('#delete-btn').removeClass('btn-delete-enabled');
			}
			else 
			{
				$('#delete-btn').prop('disabled', false);
				$('#delete-btn').removeClass('btn-delete-disabled');
				$('#delete-btn').addClass('btn-delete-enabled');
			}

		}) 

		$('#select-cat').on('change', function() {
			$('#submit-cat').trigger('submit');
		});
		<?php if( Session::has('message') ) : ?>
			var message = "{{ Session::get('message')}}";
			var success = '1';
			getFlashMessage(success, message);
		<?php endif; ?>
	});

	</script>
@stop
