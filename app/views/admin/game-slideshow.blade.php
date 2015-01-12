@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.options-nav')
	<div class="item-listing" id="featured-games">
		<h2>Slideshow Listing</h2>
		<p>Please select the games you want to feature on the homepage slideshow.</p>
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover"  id="game_table">
				<thead>
					<tr>
						<th>Game Name</th>
						<th>Featured</th>
					</tr>
				</thead>

				<tbody>
					@foreach($games as $game)
						<tr>
							<td>
								{{ $game->main_title }}
							</td>
							<td>
								<center>
									@if($game->featured == 1)
										<input type="checkbox" class="featured" name="featured[]" value="{{ $game->featured }}" checked id="{{ $game->id }}"/>
									@else
										<input type="checkbox" class="featured" name="featured[]" value="{{ $game->featured }}" id="{{ $game->id }}" />
									@endif
								</center>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		{{ $games->links() }}
		<br>
	</div>
	<script>
		$("document").ready(function(){
	        $('.featured').on('click', function() {
	        	var id = $(this).attr('id');
	        	var checked = ($(this).is(':checked')) ? 1 : 0;

	            $.ajax({
	                type: "POST",
	                url : "{{ URL::route('admin.games.featured') }}",
	                data :{
	                	"featured": checked,
	                	"id": id
	                }
	            });
	    	});
		});
	</script>
@stop