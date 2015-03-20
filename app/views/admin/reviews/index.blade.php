@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="games-list">
		<h2>Reviews</h2>

		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<br>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover"  id="review_table">
			<thead>
				<tr>
					<th>Game Title</th>
					<th>Name</th>
					<th>Review</th>
					<th>Approve</th>
					<th>Rating</th>
				</tr>
			</thead>

			<tbody>
				@foreach($reviews as $review)
					<tr>
						<td>
							
							<a href="{{ URL::route('review.show', $review->id) }}">
								@if($review->viewed == 0 )

									{{ '<i class="fa fa-envelope"></i>  '. $review->game->main_title }}

								@else

									{{ $review->game->main_title }}

								@endif

							</a>
							<ul class="actions">							
								<li><a href="{{ URL::route('review.show', $review->id) }}">View</a></li>
								<li>
									{{ Form::open(array('route' => array('review.destroy', $review->id), 'method' => 'delete', 'class' => 'delete-form')) }}
										{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
									{{ Form::close() }}
								</li>
							</ul>
							
						</td>

						<td>{{ $review->user->first_name . ' ' . $review->user->last_name }}</td>
						
						<td>{{ str_limit($review->review, $limit = 200, $end = '...') }}</td>

						<td>
							@if($review->status == 1)
								<input type="checkbox" class="status" name="status[]" value="{{ $review->status }}" checked id="{{ $review->id }}"/>
							@else
								<input type="checkbox" class="status" name="status[]" value="{{ $review->status }}" id="{{ $review->id }}" />
							@endif
						</td>
						<td>
												
						<!-- UPDATED BY: Jone -->
							@for ($i=1; $i <= 5 ; $i++)
		                      <i class="fa fa-star{{ ($i <= $review->rating) ? '' : '-empty'}}"></i>
		                    @endfor         
						<!-- END -->
													
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
		{{ $reviews->links() }}
		<br>
	</div>
	<script>
		$("document").ready(function(){
	        $('.status').on('click', function() {

	        	var id = $(this).attr('id');
	        	var checked = ($(this).is(':checked')) ? 1 : 0;

	        	// alert(id + ' ' + checked)

	            $.ajax({
	                type: "POST",
	                url : "{{ URL::route('admin.reviews.status') }}",
	                data :{
	                	"status": checked,
	                	"id": id
	                },
	                success : function(data){
	                    console.log('data');
	                }
	            });
	    	});
		});
	</script>
	{{ HTML::script('js/form-functions.js') }}
	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function(){
		   /* $('#review_table').DataTable();*/
		   /** 
				* Added by: Jone   
				* Purpose: Disables sorting on the rating column
				* Date: 01/22/2015
			*/
		   $('#review_table').dataTable( {
		      "aoColumnDefs": [
		          { 'bSortable': false, 'aTargets': [ 4 ] }
		       ]
			});

		});

	</script>

@stop