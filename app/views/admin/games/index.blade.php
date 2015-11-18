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
		
		<table class="table table-striped table-bordered table-hover" id="game_table">
			<thead>
				<tr>
					<th class="no-sort"><input id="select-all" type="checkbox"></th>
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
						<td><input name="game" type="checkbox" data-id="{{ $game->id }}"></td>
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
						<td>{{ Carbon::parse($game->release_date)->format('M j, Y') }}</td>
						<td>
							{{ Carbon::parse($game->updated_at)->format('M j, Y') }} <br>
							{{ Carbon::parse($game->updated_at)->format('g:i A') }}
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
	{{ HTML::script('js/toastr.js') }}
	{{ HTML::script('js/form-functions.js') }}

	<script>
	$(document).ready(function(){
		$('#game_table').DataTable({
	        "order": [[ 6, "desc" ]],
	        "oLanguage": {
                "sSearch": "<span>Search  </span> _INPUT_", //search
            }
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
		});
		 

		$('#game_table input[type="checkbox"]').click(function(){
			var checked = $('#game_table input[type="checkbox"]:checked');
			
			if(checked.length > 0)
			{
				$("a.del").removeClass("disabled");
			}
			else 
			{
				$("a.del").addClass("disabled");
			}

		});

		$(document).on('click', 'a.del', function() {
	    	
        	if(confirm("Are you sure you want to remove this game?")) {
				var ids = new Array();

			    $('input[name="game"]:checked').each(function() {
			        ids.push($(this).attr("data-id"));
			    });

				$.ajax({
					url: "{{ URL::route('admin.games.multiple-delete') }}",
					type: "POST", 
					data: { ids: ids },
					success: function(response) {
						
						location.reload();
						<?php if( Session::has('message') ) : ?>
							var message = "{{ Session::get('message')}}";
							var success = '1';
							getFlashMessage(success, message);
						<?php endif; ?>

					},
					error: function(response) {
						console.log(response);
					}
				});
			}
			return false;
	    });

		var link = '<a href="#"  class="pull-right graph-link mgmt-link del disabled">Delete Selected</a>'
		$("#game_table_length label").html(link);
		
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
