@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	{{ Form::model($category, array('route' => array('admin.categories.update', $category->id), 'method' => 'put', 'class' => 'small-form')) }}
		<h2>Edit Category</h2>
		<ul>
			<li>
				{{ Form::label('category', 'Category: ') }}
				{{ Form::text('category', null, array('class' => 'slug-reference')) }}
				{{ $errors->first('category', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('slug', 'Slug: ') }}
				{{ Form::text('slug', null, array('class' => 'slug')) }}
				{{ $errors->first('slug', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::submit('Save') }}
			</li>
		</ul>

	{{ Form::close() }}

@stop


@section('scripts')
{{ HTML::script('js/toastr.js') }}
{{ HTML::script('js/form-functions.js') }}
{{ HTML::script('js/jquery.dataTables.js') }}
{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	<?php if( Session::has('message') ) : ?>
		var message = "{{ Session::get('message')}}";
		var success = '1';
		getFlashMessage(success, message);
	<?php endif; ?>

});	
</script>
@stop