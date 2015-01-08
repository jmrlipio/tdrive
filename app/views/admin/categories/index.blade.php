@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="categories-list">
		<h2>Categories</h2>

		@if(Auth::user()->role != 'admin')
			<a href="{{ URL::route('admin.categories.create') }}" class="mgmt-link">New Category</a>
		@endif

		<br>
		<table>
			<tr>
				<!--<th><input type="checkbox"></th>-->
				<th>Category Name</th>
				<th>Slug</th>
				<th>Featured</th>
			</tr>
			@foreach($categories as $category)
				<tr>
					<!--<td><input type="checkbox"></td>-->
					<td>
						<a href="#">{{ $category->category }}</a>
						@if(Auth::user()->role != 'admin')
							<ul class="actions">
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
						@if($category->featured == 1)
							<input type="checkbox" class="featured" name="featured[]" value="{{ $category->featured }}" checked id="{{ $category->id }}"/>
						@else
							<input type="checkbox" class="featured" name="featured[]" value="{{ $category->featured }}" id="{{ $category->id }}" />
						@endif
					</td>
				</tr>
			@endforeach
		</table>
		<script>
			$("document").ready(function(){
		       

		        $('.featured').on('click', function() {

		        	var id = $(this).attr('id');
		        	var checked = ($(this).is(':checked')) ? 1 : 0;

		            $.ajax({
		                type: "POST",
		                url : "{{ URL::route('admin.categories.featured') }}",
		                data :{
		                	"featured": checked,
		                	"id": id
		                },
		                success : function(data){
		                    console.log('data');
		                }
		            });
		    	});
			});
		</script>

		<br>
		
	</div>
	{{ HTML::script('js/form-functions.js') }}
@stop