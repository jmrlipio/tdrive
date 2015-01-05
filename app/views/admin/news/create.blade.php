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
					<li>
						{{ Form::label('release_date', 'Release Date:') }}
						{{ Form::text('release_date', null, array('id' => 'release_date')) }}
						{{ $errors->first('release_date', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('featured_image', 'Choose an image') }}
						{{ Form::file('featured_image') }}
						{{ $errors->first('featured_image', '<p class="error">:message</p>') }}
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
	var gallery = $('#img-gallery ul'), 
		img_li;

	$(document).ready(function() {


		// Date picker for Release Date
        $("#release_date").datepicker({ dateFormat: 'yy-mm-dd' }).bind("change",function(){
            var minValue = $(this).val();
            minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
            minValue.setDate(minValue.getDate()+1);
            $("#to").datepicker( "option", "minDate", minValue );
    	});

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