@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.options-nav')
	<div class="item-listing" id="featured-games">
		<h2>Slideshow Listing</h2>
		<p>Please select the news you want to feature on the homepage slideshow.</p>
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover"  id="game_table">
				<thead>
					<tr>
						<th>News Title</th>
						<th>Featured</th>
					</tr>
				</thead>

				<tbody>
					@foreach($news as $n)
						<tr>
							<td>
								{{ $n->main_title }}
							</td>
							<td>
								<center>
									@if($n->featured == 1)
										<input type="checkbox" class="featured" name="featured[]" value="{{ $n->featured }}" checked id="{{ $n->id }}"/>
									@else
										<input type="checkbox" class="featured" name="featured[]" value="{{ $n->featured }}" id="{{ $n->id }}" />
									@endif
								</center>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		{{ $news->links() }}
		<br>
	</div>
	<script>
		$("document").ready(function(){
	        $('.featured').on('click', function() {
	        	var id = $(this).attr('id');
	        	var checked = ($(this).is(':checked')) ? 1 : 0;

	            $.ajax({
	                type: "POST",
	                url : "{{ URL::route('admin.featured') }}",
	                data :{
	                	"featured": checked,
	                	"id": id
	                }
	            });
	    	});
		});
	</script>
@stop