@extends('admin._layouts.admin')

@section('content')

{{ Form::open(array('route' => 'admin.news.store', 'class' => 'large-form tab-container', 'id' => 'tab-container')) }}
	<h2>Create News</h2>
	@if(Session::has('message'))
        <div class="flash-success">
            <p>{{ Session::get('message') }}</p>
        </div>
    @endif

	<br>
	<ul class='etabs'>
		<li class='tab'><a href="#content">Content</a></li>
		<li class='tab'><a href="#custom-fields">Custom Fields</a></li>
		<li class='tab'><a href="#feature-image">Feature Image</a></li>
	</ul>
<div class='panel-container'>
	<ul id="content">
			<li>
				{{ Form::label('title', 'Title: ') }}
				{{ Form::text('title', null, array('id' => 'title', 'class' => 'slug-reference')) }}
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
			<li>
				{{ Form::label('release_date', 'Release Date:') }}
				{{ Form::text('release_date', null, array('id' => 'release_date')) }}
				{{ $errors->first('release_date', '<p class="error">:message</p>') }}
			</li>
			
			<li>
				{{ Form::label('content', 'Content:') }}
				{{ Form::textarea('content', null, array('id' => 'text-content')) }}
				{{ $errors->first('content', '<p class="error">:message</p>') }}
			</li>
			
		</ul>
		
		<ul id="custom-fields">
			<li>
				{{ Form::label('excerpt', 'Excerpt:') }}
				{{ Form::textarea('excerpt', null, array('id' => 'text-excerpt')) }}
				{{ $errors->first('excerpt', '<p class="error">:message</p>') }}
			</li>
		</ul>
		
		<ul id="feature-image">
			<li>
				{{ Form::label('featured-img', 'Featured Image:') }}
				<div class="img-holder"></div>
				<p>
					{{ Form::text('featured-img', null, array('id' => 'featured-img', 'class' => 'img-url', 'disabled')) }}
					{{ Form::hidden('featured_img_id', null, array('class' => 'hidden_id')) }}
					{{ Form::button('Select', array('class' => 'select-img')) }}
				</p>
			</li>
			
		</ul>

		<li>
			{{ Form::submit('Save', array('id' => 'save-news')) }}
		</li>
</div>
		{{ Form::hidden('user_id', Auth::user()->id) }}
	{{ Form::close() }}

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
			height : 300,
			plugins: "image",
			file_browser_callback : "myFileBrowser",
		    image_list: [ 
		        {title: 'My image 1', value: 'http://www.tinymce.com/my1.gif'}, 
		        {title: 'My image 2', value: 'http://www.moxiecode.com/my2.gif'} 
		    ]
		});

		
    	/*tinymce.init({
			
			selector: "#text-content",
			height : 300,
			plugins: ["image"],
	        file_browser_callback: function(field_name, url, type, win) {
	            if(type=='image') $('#my_form input').click();
	        }
		});*/

		// tinymce.init({
		// 	mode : "specific_textareas",
		// 	selector: "#excerpt",
		// 	height : 150
		// });
/*		tinymce.init({
	        selector: '#text-content',
	        plugins: ["image"],
	        file_browser_callback: function(field_name, url, type, win) {
	            if(type=='image') $('#my_form input').click();
	        }
	    });*/

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