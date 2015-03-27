@extends('admin._layouts.admin')

@section('content')
	<article>
		{{ Form::open(array('route' => 'admin.news.store', 'class' => 'large-form tab-container', 'id' => 'tab-container', 'files'=>true, 'enctype'=> 'multipart/form-data')) }}
			<h2>Create News</h2>
			<br>
			@if(Session::has('message'))
		        <div class="flash-success">
		            <p>{{ Session::get('message') }}</p>
		        </div>
		    @endif
			<div class='panel-container'>
				<ul id="content">
					<li>
						{{ Form::label('main_title', 'Main Title: ') }}
						{{ Form::text('main_title', null, array('id' => 'title', 'class' => 'slug-reference')) }}
						{{ $errors->first('title', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('slug', 'Slug: ') }}
						{{ Form::text('slug', null, array('id' => 'slug', 'class' => 'slug ')) }}
						{{ $errors->first('slug', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('news_category', 'Category:') }}
				  		{{ Form::select('news_category_id', $news_categories, null) }}				
						{{ $errors->first('news_category', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('status', 'Status: ') }}
						{{ Form::select('status', array('1' => 'Draft', '2' => 'Live'))  }}
						{{ $errors->first('status', '<p class="error">:message</p>') }}
					</li>
					<!--
					<li>
						{{-- Form::label('release_date', 'Release Date:') --}}
						{{-- Form::text('release_date', null, array('id' => 'release_date')) --}}
						{{-- $errors->first('release_date', '<p class="error">:message</p>') --}}
					</li>
					-->
					<li>
						{{ Form::label('featured_image', 'Choose an image') }}
						{{ Form::file('featured_image') }}
						{{ $errors->first('featured_image', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('homepage_image', 'Homepage Image:') }}
						{{ Form::file('homepage_image') }}
						{{ $errors->first('homepage_image', '<p class="error">:message</p>') }}
					</li>
				</ul>

				{{ Form::submit('Save', array('id' => 'save-news')) }}
			</div>
			{{ Form::hidden('user_id', Auth::user()->id) }}
		{{ Form::close() }}
	</article>

	@include('admin._partials.image-select')
	{{ HTML::script('js/tinymce/tinymce.min.js') }}
	{{ HTML::script('js/jquery.easytabs.min.js') }}
	{{ HTML::script('js/chosen.jquery.js') }}
	{{ HTML::script('js/form-functions.js') }}

	<script>
	$(document).ready(function() {
		// Date picker for Release Date
        $("#release_date").datepicker({ dateFormat: 'yy-mm-dd' }).bind("change",function(){
            var minValue = $(this).val();
            minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
            minValue.setDate(minValue.getDate()+1);
            $("#to").datepicker( "option", "minDate", minValue );
    	});

	});
    </script>
@stop