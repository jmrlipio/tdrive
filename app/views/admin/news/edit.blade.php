@extends('admin._layouts.admin')
@section('stylesheets')
	<style>
		.media-box { float: none !important; padding-left: 0 !important; }
	</style>
@stop
@section('content')
	<div class='large-form tab-container' id='tab-container'>

		<h2>Edit News</h2>
		<br>
		<br>
		<div>
			<ul id="content">	

				{{ Form::model($news, array('route' => array('admin.news.update', $news->id), 'method' => 'put', 'files'=>true, 'enctype'=> 'multipart/form-data', 'class' => 'editForm')) }}
					<li>
						{{ Form::label('main_title', 'Title ') }}
						{{ Form::text('main_title', $news->main_title , array('id' => 'title', 'class' => 'slug-reference')) }}
						{{ $errors->first('main_title', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('slug', 'Slug ') }}
						{{ Form::text('slug', null, array('id' => 'slug', 'class' => 'slug ')) }}
						{{ $errors->first('slug', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('news_category', 'Category') }}
				  		{{ Form::select('news_category_id', $news_categories, $news->news_category_id) }}				
						{{ $errors->first('news_category', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('status', 'Status ') }}
						{{ Form::select('status', array('draft' => 'Draft', 'live' => 'Live'))  }}
						{{ $errors->first('status', '<p class="error">:message</p>') }}
					</li>
					
					{{ Form::hidden('user_id', Auth::user()->id) }}

				{{ Form::close() }}

				<br/>

					<li>
						<?php $image = $news->featured_image; ?>
						
						{{ Form::label('featured_image', 'Featured Image (1024x500)') }}

						<div class="media-box" id="featured_imagec">
							
							{{ Form::open(array('route' => array('admin.news.postupdate-media', $news->id), 'method' => 'post', 'files' => true, 'class' => 'post-media-form')) }}
							@if($image)
								<img src="{{ asset('assets/news') }}/{{ $image }}" class="image-preview" alt="image_preview"/>
			            	@else
			            		<img src="{{ asset('images/default-450x200.png') }}" class="image-preview" alt="image_preview"/>
			            	@endif
			            	 <div style="position:relative; width: 100px; top: -35px">
			              		<a class='btn btn-primary upload-trigger' href='javascript:;'>
			                    <span class="screenshot-loader" >change</span>
			                    <input type="file" name="featured_image" id="featured_image" class="media-file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' size="60"  onchange='$("#upload-file-info").html($(this).val());'>
			             		</a>
				        	</div>
				        	{{ Form::close() }}
			            </div>
						<div class="clear"></div>
					</li>
					<li>
						<?php $homepage_image = $news->homepage_image; ?>
						
						{{ Form::label('homepage_image', 'Homepage Image (1024x500)') }}

						<div class="media-box" id="featured_imagec">
							
							{{ Form::open(array('route' => array('admin.news.postupdate-media', $news->id), 'method' => 'post', 'files' => true, 'class' => 'post-media-form')) }}
							@if($homepage_image)
								<img src="{{ asset('assets/news') }}/{{ $homepage_image }}" class="image-preview" alt="image_preview"/>
			            	@else
			            		<img src="{{ asset('images/default-450x200.png') }}" class="image-preview" alt="image_preview"/>
			            	@endif
			            	 <div style="position:relative; width: 100px; top: -35px">
			              		<a class='btn btn-primary upload-trigger' href='javascript:;'>
			                    <span class="screenshot-loader" >change</span>
			                    <input type="file" name="homepage_image" id="homepage_image" class="media-file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' size="60"  onchange='$("#upload-file-info").html($(this).val());'>
			             		</a>
				        	</div>
				        	{{ Form::close() }}
			            </div>
						<div class="clear"></div>
					</li>

				<a class="custom-back" href="{{ URL::route('admin.news.index') }}">Back</a>
				{{ Form::submit('Save', array('class' => 'submit')) }}
			</ul>
		</div>
		
	@include('admin._partials.image-select')
	{{ HTML::script('js/tinymce/tinymce.min.js') }}
	{{ HTML::script('js/jquery.easytabs.min.js') }}
	{{ HTML::script('js/chosen.jquery.js') }}
	{{ HTML::script('js/toastr.js') }}
	{{ HTML::script('js/form-functions.js') }}
	{{ HTML::script('js/image-uploader.js') }}

	<script>
	var gallery = $('#img-gallery ul'), 
		img_li;

	$(document).ready(function() {

		$(".submit").on('click', function() {
			$(".editForm").submit();
		});

		<?php if( Session::has('message') ) : ?>
			var message = "{{ Session::get('message')}}";
			var success = '1';
			getFlashMessage(success, message);
		<?php endif; ?>

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

	$("#featured_image").uploadBOOM({
		'url': '{{ URL::route("admin.news.postupdate-media", $news->id) }}',
		'before_loading': '<span class="loader-icon"></span>Saving..',
		'after_loading' : 'Change'
	});

	$("#homepage_image").uploadBOOM({
		'url': '{{ URL::route("admin.news.postupdate-media", $news->id) }}',
		'before_loading': '<span class="loader-icon"></span>Saving..',
		'after_loading' : 'Change'
	});

    </script>
@stop