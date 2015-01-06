@extends('admin._layouts.admin')

@section('content')
	<article>
	<h2>Edit News</h2>
	@if(Session::has('message'))
        <div class="flash-success">
            <p>{{ Session::get('message') }}</p>           
        </div>
    @endif

	<br>
	<div class='large-form tab-container' id='tab-container'>
		<ul class='etabs'>
			<li class='tab'><a href="#content">Content</a></li>
			<li class='tab'><a href="#custom-fields">Custom Fields</a></li>
			<li class='tab'><a href="#news-content">News Content</a></li>
		</ul>
		<div class='panel-container'>
			<ul id="content">
				{{ Form::model($news, array('route' => array('admin.news.update', $news->id), 'method' => 'put')) }}
					<li>
						{{ Form::label('main_title', 'Title: ') }}
						{{ Form::text('main_title', $news->main_title , array('id' => 'title', 'class' => 'slug-reference')) }}
						{{ $errors->first('title', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('slug', 'Slug: ') }}
						{{ Form::text('slug', null, array('id' => 'slug', 'class' => 'slug ')) }}
						{{ $errors->first('slug', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('news_category', 'Category:') }}
				  		{{ Form::select('news_category_id', $news_categories, $news->news_category_id) }}				
						{{ $errors->first('news_category', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('status', 'Status: ') }}
						{{ Form::select('status', array('draft' => 'Draft', 'live' => 'Live'))  }}
						{{ $errors->first('status', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('release_date', 'Release Date:') }}
						{{ Form::text('release_date', null, array('id' => 'release_date')) }}
						{{ $errors->first('release_date', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('featured_image', 'Featured Image:') }}
						{{ Form::file('featured_image') }}
					</li>
					<li>
						
					</li>
					{{ Form::hidden('user_id', Auth::user()->id) }}
					{{ Form::submit('Save') }}
				{{ Form::close() }}
			</ul>
			<ul id="custom-fields">
				{{ Form::open(array('route' => array('admin.news.update-fields', $news->id), 'method' => 'post')) }}
					<li>
						{{ Form::label('language_id', 'Languages: ') }}
						{{ Form::select('language_id[]', $languages, $selected_languages, array('multiple' => 'multiple', 'class' => 'chosen-select', 'id' => 'languages', 'data-placeholder'=>'Choose language(s)...'))  }}
						{{ $errors->first('language_id', '<p class="error">:message</p>') }}
					</li>
					{{ Form::submit('Update Fields', array('class' => 'update-content')) }}
				{{ Form::close() }}
			</ul>
			<ul id="news-content">
				<h3>Th has content for the following languages:</h3>
				<br>
				@if($selected_languages)
				<ul>
					@foreach($languages as $language_id => $language)
						@if(in_array($language_id, $selected_languages))
							<li><a href="{{ URL::route('admin.news.edit.content', array('news_id' => $news->id, 'language_id' => $language_id)) }}">{{ $language }}</a></li>
						@endif
					@endforeach
				</ul>
				@else
					<p>Please select one or more languages to add content to this news.
				@endif
			</ul>
		</div>
		
		
	</article>

	@include('admin._partials.image-select')
	{{ HTML::script('js/tinymce/tinymce.min.js') }}
	{{ HTML::script('js/jquery.easytabs.min.js') }}
	{{ HTML::script('js/chosen.jquery.js') }}
	{{ HTML::script('js/form-functions.js') }}

	<script>
	var gallery = $('#img-gallery ul'), 
		img_li;

	$(document).ready(function() {
		// Initializes different tab sections
		$('.tab-container').easytabs();

		// Date picker for Release Date
        $("#release_date").datepicker({ dateFormat: 'yy-mm-dd' }).bind("change",function(){
            var minValue = $(this).val();
            minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
            minValue.setDate(minValue.getDate()+1);
            $("#to").datepicker( "option", "minDate", minValue );
    	});

        // Initializes textarea editor for content and excerpt
        tinymce.init({
			mode : "specific_textareas",
			selector: "#text-content",
			height : 300
		});

		$(".chosen-select").chosen();

// Appends fields for adding screenshots on Images tab		

		$('#tab-container > .etabs a').click(function() {
			$('body').scrollTop(0);
		});

		// Opens media dialog for selecting featured and screenshots images
		$("#feature-image").on('click', '.select-img',function(){
			img_li = $(this).parent().parent();
			$('#cover').css('display', 'block');
			
			if(isEmpty(gallery)) {
				loadGallery();
			}
		});

		// Closes media dialog for selecting featured and screenshots images
		$("#close-img-select, #img-close").on('click', function() {
			$('#cover').css('display', 'none');
		});

		// Selects and sets chosen image for featured or screenshot image
		$("#choose-img").on('click', function() {
			var id, value;

			gallery.find('input[type=radio]').each(function() {
				if($(this).is(':checked')) {
					var selected = $(this).parent().find('img');
					value = selected.attr('src');
					id = selected.data('value');
				}
			});

			img_li.find('.img-url').val(value);
			img_li.find('.hidden_id').val(id);
			img_li.find('div').html('');
			img_li.find('div').append('<img src="' + value + '">');

			$('#cover').css('display', 'none');
		});


	});
	$("#feature-image").on('click', '.remove-img',function(){
		$(this).parent().parent().remove();
	});

	// On submit of form
	$('#tab-container').on('submit', function() {
		$('.img-url').prop('disabled', false);
	});

	// Check if element html is empty
	function isEmpty(el){
		return !$.trim(el.html())
	}

	// Ajax for loading uploaded images
	function loadGallery() {
		$.get("{{ URL::route('media.load') }}",function(data){
			for(var id in data) {
				if (data.hasOwnProperty(id)) {
					var app = ' \
						<li> \
							<input name="imgs" type="radio" value="A" id="' + id + '"> \
							<label for="' + id + '"><img src="' + data[id] + '" data-value="' + id + '"></label> \
						</li>';
			    	gallery.append(app);
			    }
			}
		});
	}

	// On submit of form
	$('#tab-container').on('submit', function() {
		$('.img-url').prop('disabled', false);
	});

    </script>
@stop