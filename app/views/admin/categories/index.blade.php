@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="categories-list">
		<h2>Categories</h2>
		<a href="{{ URL::route('admin.categories.create') }}" class="mgmt-link">New Category</a>
		<br>
		<table>
			<tr>
				<th><input type="checkbox"></th>
				<th>Category Name</th>
				<th>Slug</th>
			</tr>
			@foreach($categories as $category)
				<tr>
					<td><input type="checkbox"></td>
					<td>
						<a href="#">{{ $category->category }}</a>
						<ul class="actions">
							<li><a href="{{ URL::route('admin.categories.edit', $category->id) }}">Edit</a></li>
							<li><a href="">View</a></li>
							<li>
								{{ Form::open(array('route' => array('admin.categories.destroy', $category->id), 'method' => 'delete', 'class' => 'delete-form')) }}
									{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
								{{ Form::close() }}
							</li>
						</ul>
					</td>
					<td>{{ $category->slug }}</td>
				</tr>
			@endforeach
		</table>
		<br>
		
	</div>
	{{ HTML::script('js/form-functions.js') }}
@stop