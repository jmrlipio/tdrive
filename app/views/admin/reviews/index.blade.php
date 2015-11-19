@extends('admin._layouts.admin')

@section('stylesheets')
	<style>
		/*button{ background: #4288CE !important; }
		button:hover {background: #333333 !important; }*/
		
		p.approved {color: green !important;}
		p.pending {color: #555 !important;}
	
	</style>
@stop

@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="games-list">
		<h2>Reviews</h2>
		<div  class="fleft label-dropdown">
			Games 
		</div>
		<div class="fleft ">
		{{ Form::open(array('route' => 'admin.reviews.game','class' => 'simple-form', 'id' => 'submit-game', 'method' => 'get')) }}
			{{ Form::select('selected_game', $games, $selected, array('class' => 'select-filter', 'id' => 'select-game')) }}
		{{ Form::close() }}
		</div>
		<div class="clear"></div>


	<div class="table-responsive">
		<!-- <button id="delete-btn" class="btn-delete">Delete</button> -->
	<form method="POST" action="{{ URL::route('admin.destroy.review') }}">
		{{ Form::token() }}

		@if (count($reviews))

		<table class="table reviews-table"  id="review_table">
			<thead>
				<tr>
					<th class="no-sort"><input type="checkbox"></th>
					<th>Game Title</th>
					<th>Name</th>
					<th>Status</th>
					<th>Rating</th>
					<th>Date Created</th>
				</tr>
			</thead>

			<tbody>

				@foreach($reviews as $review)
								
					<tr>
						<td><input name="review" type="checkbox" inquiry-id="{{$review->id}}"></td>
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
								<li><a class="red" href="{{ URL::route('reviews.delete', $review->id) }}">Delete</a></li>
							</ul>
							
						</td>

						<td>{{ $review->user->first_name . ' ' . $review->user->last_name }}</td>
						
						<td>
							@if($review->status == 1)
								<p class="approved">Approved</p>
							@else								
								<p class="pending">Pending</p>
							@endif
						</td>
						<td>		

							@for ($i=$review->rating; $i>= 1 ; $i--)
		                      <i class="fa fa-star"></i>
		                    @endfor      
													
						</td>
						<td>
							{{ Carbon::parse($review->created_at)->format('M j, Y') }} <br>
							{{ Carbon::parse($review->created_at)->format('g:i A') }}
						</td>
					</tr>
				@endforeach				
			</tbody>
		</table>
		@else
			<p>No reviews</p>
		@endif
		
	</div>
		{{ $reviews->links() }}
		<br>
	</div>
	<script>
		$("document").ready(function(){
	        $('.status').on('click', function() {

	        	var id = $(this).attr('id');
	        	var checked = ($(this).is(':checked')) ? 1 : 0;

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
	{{ HTML::script('js/toastr.js') }}
	{{ HTML::script('js/form-functions.js') }}
	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
	
	<script>
		$(document).ready(function(){

			<?php if( Session::has('message') ) : ?>
				var message = "{{ Session::get('message')}}";
				var success = '1';
				getFlashMessage(success, message);
			<?php endif; ?>


			$('#review_table').dataTable({
				"iDisplayLength": 50,
		        "order": [[ 5, "desc" ]],
		       "bPaginate" : false,
		        "oLanguage": {
	                "sSearch": "<span>Search  </span> _INPUT_", //search
	            }
		    });

			$('th input[type=checkbox]').click(function(){
				if($(this).is(':checked')) {
					$('td input[type=checkbox').prop('checked', true);
				} else {
					$('td input[type=checkbox').prop('checked', false);
				}
			});
			$('.reviews-table input[type="checkbox"]').click(function(){
				console.log('checked');
				var checked = $('.reviews-table input[type="checkbox"]:checked');
				if(checked.length > 0){
					$("a.del").removeClass("disabled");
				}else {
					$("a.del").addClass("disabled");
				}
			});

			$(document).on('click', 'a.del', function() {
	    	
        	if(confirm("Are you sure you want to remove this review?")) {
				var ids = new Array();

			    $('input[name="review"]:checked').each(function() {
			        ids.push($(this).attr("inquiry-id"));
			    });

				$.ajax({
					url: "{{ URL::route('admin.review.multiple-delete') }}",
					type: "POST", 
					data: { ids: ids },
					success: function(response) {
						location.reload();
					},
					error: function(response) {
						console.log(response);
					}
				});
			}
			return false;
	    });

			var link = '<a href="#"  class="pull-right graph-link mgmt-link del disabled">Delete Selected</a>'
			$(".dataTables_length label").html(link);
		});

	</script>

@stop