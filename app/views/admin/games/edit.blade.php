@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	@include('admin._scripts.scripts')

	<article>
		<h2>Edit Game</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<br>
		<div class='large-form tab-container' id='tab-container'>
			<ul class='etabs'>
				<li class='tab'><a href="#details">Details</a></li>
				<li class='tab'><a href="#apps">Apps</a></li>
				<li class='tab'><a href="#media">Media</a></li>
			</ul>
			<div class='panel-container'>	
				<ul id="details">
					{{ Form::model($game, array('route' => array('admin.games.update', $game->id), 'method' => 'put')) }}
						<li>
							{{ Form::label('main_title', 'Main Title: ') }}
							{{ Form::text('main_title', null, array('id' => 'title', 'class' => 'slug-reference')) }}
							{{ $errors->first('title', '<p class="error">:message</p>') }}
						</li>
						<li>
							{{ Form::label('slug', 'Slug: ') }}
							{{ Form::text('slug', null, array('id' => 'slug', 'class' => 'slug')) }}
							{{ $errors->first('slug', '<p class="error">:message</p>') }}
						</li>
						<li>
							{{ Form::label('category_id', 'Categories: ') }}
							{{ Form::select('category_id[]', $categories, $selected_categories, array('multiple' => 'multiple', 'class' => 'chosen-select', 'data-placeholder'=>'Choose category(s)...'))  }}
							{{ $errors->first('category_id', '<p class="error">:message</p>') }}
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
							{{ Form::label('downloads', 'Displayed Number of Downloads: ') }}
							{{ Form::text('downloads') }}
							{{ $errors->first('downloads', '<p class="error">:message</p>') }}
						</li>
						<li>
							{{ Form::label('default_price', 'Default Price: ') }}
							{{ Form::text('default_price') }}
						</li>
						{{ Form::submit('Save', array('id' => 'save-game')) }}
						{{ Form::hidden('user_id', Auth::user()->id) }}

					{{ Form::close() }}
				</ul>
				<ul id="apps">
					<a href="{{ URL::route('admin.games.create.app', $game->id) }}" class="mgmt-link">Create App</a>
					<div class="clear"></div>
					<table id="app-table">
						<tr>
							<th>App ID</th>
							<th>Carrier</th>
							<th>Language</th>
							<th>Action</th>
						</tr>

						@if(count($game->apps))
							@foreach($game->apps as $app)
								
								<tr>
									<td>
										<a href="{{ URL::route('admin.games.edit.app', array('game_id' => $game->id, 'app_id' => $app->pivot->app_id)) }}">
											{{ $app->pivot->app_id }}
										</a>
									</td>
									<td>{{ $app->carrier }}</td>
									<td>
										@foreach($languages as $language)
											@if($language->id == $app->pivot->language_id)
												{{ $language->language }}
											@endif											
										@endforeach
									</td>
									<td>
										{{ Form::open(array('route' => array('admin.games.delete.app', $game->id, $app->pivot->app_id), 'method' => 'delete', 'class' => 'delete-form')) }}
											{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
										{{ Form::close() }}
									</td>
								</tr>
							@endforeach
						@else
							<tr>
						    	<td colspan="4" class="center">You haven't created any apps yet.</td>
						    </tr>
						@endif

					</table>
				</ul>
				<ul id="media">
					{{ Form::open(array('route' => array('admin.games.update-media', $game->id), 'method' => 'post', 'files' => true, 'id' => 'update-media')) }}
						<li>
							{{ Form::label('image_orientation', 'Orientation: ') }}
							{{ Form::select('image_orientation', array('portrait' => 'Portrait', 'landscape' => 'Landscape'), $game->image_orientation, array('id' => 'orientation'))  }}
							{{ $errors->first('orientation', '<p class="error">:message</p>') }}
						</li>
						<li>
							{{ Form::label('promo', 'Promo Image:', array('class' => 'image-label')) }}
							@foreach($selected_media as $media)
								@if($media['type'] == 'promos')
									<div class="media-box">
										{{ HTML::image($media['media_url'], null) }}
									</div>
								@endif
							@endforeach
							{{ Form::file('promo', array('id' => 'promo-img')) }}
						</li>
						<li>
							{{ Form::label('icon', 'Icon:', array('class' => 'image-label')) }}
							@foreach($selected_media as $media)
								@if($media['type'] == 'icons')
									<div class="media-box">
										{{ HTML::image($media['media_url'], null) }}
									</div>
								@endif
							@endforeach
							{{ Form::file('icon', array('id' => 'icon-img')) }}
						</li>
						<li>
							{{ Form::label('homepage', 'Homepage Image:', array('class' => 'image-label')) }}
							@foreach($selected_media as $media)
								@if($media['type'] == 'homepage')
									<div class="media-box">
										{{ HTML::image($media['media_url'], null) }}
									</div>
								@endif
							@endforeach
							{{ Form::file('homepage', array('id' => 'homepage-img')) }}
						</li>
						<li>
							{{ Form::label('video', 'Video URL: ') }}
							@foreach($selected_media as $media)
								@if($media['type'] == 'video')
									<?php $video = $media['media_url']; ?>
								@endif
							@endforeach
							<?php if(!isset($video)) $video = null; ?>
							{{ Form::text('video', $video) }}
						</li>
						<h3>Screenshots:</h3>
						<br>
						@foreach($selected_media as $media)
							@if($media['type'] == 'screenshots')
								<li>
									<div class="media-box">
										{{ HTML::image($media['media_url'], null) }}
									</div>
									{{ Form::file('screenshots[]', null, array('class' => 'screenshot')) }}
									{{ Form::button('Remove', array('class' => 'remove-btn')) }}
									{{ Form::hidden('ssid[]', $media['media_id'], array('class' => 'ssid')) }}
								</li>
							@endif
						@endforeach
						{{ Form::button('Add Screenshot', array('id' => 'add-img')) }}
						<br><br>
						{{ Form::submit('Update Media', array('class' => 'update-content')) }}
					{{ Form::close() }}
				</ul>
				
			</div>
		</div>
	</article>

	@include('admin._partials.image-select')
    {{ HTML::script('js/tinymce/tinymce.min.js') }}
	{{ HTML::script('js/jquery.easytabs.min.js') }}
	{{ HTML::script('js/ckeditor/ckeditor.js') }}
	{{ HTML::script('js/chosen.jquery.js') }}
	{{ HTML::script('js/form-functions.js') }}
	<script>
	var gallery = $('#img-gallery ul'), 
		img_li,
		prices_list = $('#prices')
		game_id = '{{ $game->id }}';

	$(document).ready(function() {
		// Initializes different tab sections
		$('.tab-container, #carrier-tab, #content-tab').easytabs();

		// Date picker for Release Date
        $("#release_date").datepicker({ dateFormat: 'yy-mm-dd' }).bind("change",function(){
            var minValue = $(this).val();
            minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
            minValue.setDate(minValue.getDate()+1);
            $("#to").datepicker( "option", "minDate", minValue );
    	});

        // Initializes Chosen Select for all multiple select fields
        $(".chosen-select").chosen();

        // Appends fields for adding screenshots on Images tab
		$('#add-img').click(function() {
			$(this).before(' \
				<li> \
					<input name="screenshots[]" type="file" class="screenshot"> \
					<button class="remove-btn" type="button">Remove</button> \
				</li> \
				');
		});

		$('#tab-container > .etabs a').click(function() {
			$('body').scrollTop(0);
		});

	    $('#update-media').on('submit', function() {
	    	$('.screenshot').each(function() {
	    		var sfile = $(this);
	    		if(sfile.val() != '') {
	    			sfile.parent().find('.ssid').remove();
	    		}
	    	});
	    });

	    
	});

	var _URL = window.URL || window.webkitURL;

	$("#media").on('change', '#promo-img', function(e) {
	    var control = $(this),
	    	orientation = $('#orientation').val();

	    //checkDimensions('promo', control, this.files[0]);
	});

	$("#media").on('change', '#icon-img', function(e) {
		var control = $(this),
	    	orientation = $('#orientation').val();

	    //checkDimensions('icon', control, this.files[0]);
	});

	$("#media").on('change', '#homepage-img', function(e) {
		var control = $(this),
			orientation = 'landscape';

		// checkDimensions('homepage', control, this.files[0]);
	});

	$("#media").on('change', '.screenshot', function(e) {
	    var control = $(this),
	    	orientation = $('#orientation').val();

	    //checkDimensions('screenshot', control, this.files[0]);
	});

	function checkDimensions(type, control,first) {
		var image, file, width, height;

	    if(type == 'promo') {
	    	if(orientation == 'landscape') {
	    		width = 1024;
	    		height = 768;
	    	} else {
	    		width = 768;
	    		height = 1024;
	    	}
	    } else if(type == 'icon') {
	    	width = 512;
	    	height = 512;
	    } else if(type == 'homepage') {
	    	width = 1024;
	    	height = 768;
	    } else {
	    	if(orientation == 'landscape') {
	    		width = 800;
	    		height = 480;
	    	} else {
	    		width = 480;
	    		height = 500;
	    	}
	    }

	    if ((file = first)) {
	        image = new Image();

	        image.onload = function() {
	            if(!((this.width == width && this.height == height) || (this.width == width && this.height == height))) {
	            	alert('Please upload an image with a ' + width + ' x ' + height +' dimension. You have uploaded a ' + this.width + ' x ' + this.height + ' image');
	            	control.replaceWith(control = control.clone(true));
	            }
	        };

	        image.src = _URL.createObjectURL(file);
	    }	

	}

	// Removes added field for screenshots on Images tab
	$("#media").on('click', '.remove-btn',function(){
		$(this).parent().remove();
	});

    </script>
@stop
