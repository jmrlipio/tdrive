@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing">
		<h2>Categories</h2>
		
		@if(Auth::user()->role != 'admin')
			<a href="{{ URL::route('admin.categories.create') }}" class="mgmt-link">Create Category</a>
		@endif
		<div class="clear"></div>

		<br>
		<div class="category_table_container">
			<table class="table table-striped table-bordered table-hover"  id="category_table">
				<thead>
					<tr>
						<th>Category Name</th>
						<th>Slug</th>
						<th>Variant</th>
					</tr>
				</thead>

				<tbody>
					@foreach($categories as $category)
						<tr>
							<td>
								<a href="{{ URL::route('admin.categories.edit', $category->id) }}">{{ $category->category }}</a>
								@if(Auth::user()->role != 'admin')
									<ul class="actions">
										<li><a href="{{ URL::route('admin.categories.variant.create', $category->id) }}">Add Variant</a> |</li>
										<li><a href="{{ URL::route('admin.categories.edit', $category->id) }}">Edit</a> |</li>
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
									<a class="{{strtolower($cat->iso_code)}} flag-link" data-toggle="tooltip" data-placement="top" title="{{$cat->language}}" href="{{ URL::route('admin.categories.variant.edit', array('cat_id' => $category->id, 'variant_id' => $cat->pivot->id)) }}"></a>
								@endforeach
							</td>
							
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<br>
	</div>

@stop
@section('scripts')
{{ HTML::script('js/toastr.js') }}
{{ HTML::script('js/form-functions.js') }}
{{ HTML::script('js/jquery.dataTables.js') }}
{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
{{ HTML::script('js/bootstrap.min.js') }}

<script>
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	$('#category_table').DataTable( {
		"iDisplayLength": 50,
    	 "bLengthChange": false,
        "oLanguage": {
            "sSearch": "<span>Search  </span> _INPUT_", //search
        }
	});
	
	<?php if( Session::has('message') ) : ?>
		var message = "{{ Session::get('message')}}";
		var success = '1';
		getFlashMessage(success, message);
	<?php endif; ?>

});	
</script>
@stop