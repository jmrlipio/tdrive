@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="categories-list">
		<h2>Categories</h2>
		
		@if(Auth::user()->role != 'admin')
			<a href="{{ URL::route('admin.categories.create') }}" class="mgmt-link">Create Category</a>
		@endif
		<div class="clear"></div>

		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<br>
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover"  id="game_table">
				<thead>
					<tr>
						<!--<th><input type="checkbox"></th>-->
						<th>Category Name</th>
						<th>Slug</th>
						<th>Variant</th>
					</tr>
				</thead>

				<tbody>
					@foreach($categories as $category)
						<tr>
							<!--<td><input type="checkbox"></td>-->
							<td>
								<a href="{{ URL::route('admin.categories.edit', $category->id) }}">{{ $category->category }}</a>
								@if(Auth::user()->role != 'admin')
									<ul class="actions">
										<li><a href="{{ URL::route('admin.categories.variant.create', $category->id) }}">Variant</a></li>
										<li><a href="{{ URL::route('admin.categories.edit', $category->id) }}">Edit</a></li>
										<li><a href="">View</a></li>
										<li>
											{{ Form::open(array('route' => array('admin.categories.destroy', $category->id), 'method' => 'delete', 'class' => 'delete-form')) }}
												{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
											{{ Form::close() }}
										</li>
									</ul>
								@endif
							</td>
							<td>{{ $category->slug }}</td>
							
							<td>
								@foreach($category->languages as $cat)
									<a href="{{ URL::route('admin.categories.variant.edit', array('cat_id' => $category->id, 'variant_id' => $cat->pivot->id)) }}">{{ $cat->language }}</a>
								@endforeach
							</td>
							
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		{{ $categories->links() }}
		<br>
	</div>
	<script>
		$("document").ready(function(){
	     //    $('.featured').on('click', function() {

	     //    	var id = $(this).attr('id');
	     //    	var checked = ($(this).is(':checked')) ? 1 : 0;

	     //    	// alert(id + ' ' + checked)

	     //        $.ajax({
	     //            type: "POST",
	     //            url : "{{ URL::route('admin.categories.featured') }}",
	     //            data :{
	     //            	"featured": checked,
	     //            	"id": id
	     //            },
	     //            success : function(data){
	     //                console.log('data');
	     //            }
	     //        });
	    	// });
		});
	</script>
	{{ HTML::script('js/form-functions.js') }}
	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function(){
		    $('#game_table').DataTable();
		});
	</script>

@stop