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
				<li class='tab'><a href="#custom-fields">Custom Fields</a></li>
				<li class='tab'><a href="#game-content">Game Content</a></li>
				<li class='tab'><a href="#media">Media</a></li>
			</ul>
			<div class='panel-container'>	
				<ul id="details">
					{{ Form::model($game, array('route' => array('admin.games.update', $game->id), 'method' => 'put')) }}
						<li>
							{{ Form::label('app_id', 'App ID: ') }}
							{{ Form::text('app_id', null) }}
							{{ $errors->first('app_id', '<p class="error">:message</p>') }}
						</li>
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
							{{ Form::label('carrier_id', 'Carrier:') }}
					  		{{ Form::select('carrier_id', $carriers, null) }}				
							{{ $errors->first('carrier_id', '<p class="error">:message</p>') }}
						</li>
						<li>
							{{ Form::label('status', 'Status: ') }}
							{{ Form::select('status', array('draft' => 'Draft', 'live' => 'Live'))  }}
							{{ $errors->first('status', '<p class="error">:message</p>') }}
						</li>
						<li>
							{{ Form::label('featured', 'Featured: ') }}
							{{ Form::select('featured', array('1' => 'Yes', '0' => 'No'))  }}
							{{ $errors->first('featured', '<p class="error">:message</p>') }}
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
				<ul id="custom-fields">
					{{ Form::open(array('route' => array('admin.games.update-fields', $game->id), 'method' => 'post')) }}
						<li>
							{{ Form::label('category_id', 'Categories: ') }}
							{{ Form::select('category_id[]', $categories, $selected_categories, array('multiple' => 'multiple', 'class' => 'chosen-select', 'data-placeholder'=>'Choose category(s)...'))  }}
							{{ $errors->first('category_id', '<p class="error">:message</p>') }}
						</li>
						<li>
							{{ Form::label('language_id', 'Languages: ') }}
							{{ Form::select('language_id[]', $languages, $selected_languages, array('multiple' => 'multiple', 'class' => 'chosen-select', 'id' => 'languages', 'data-placeholder'=>'Choose language(s)...'))  }}
							{{ $errors->first('language_id', '<p class="error">:message</p>') }}
						</li>
						{{ Form::submit('Update Fields', array('class' => 'update-content')) }}
					{{ Form::close() }}
				</ul>
				<ul id="game-content">
					<h3>The game has content for the following languages:</h3>
					<br>
					@if($selected_languages)
						<ul>
							<table id="language-table">
								<tr>
									<th>Language</th>
									<th>Default</th>
								</tr>
								@foreach($languages as $language_id => $language)
									@if(in_array($language_id, $selected_languages))
										<tr>
											<td>
												<li>
													<a href="{{ URL::route('admin.games.edit.content', array('game_id' => $game->id, 'language_id' => $language_id)) }}">{{ $language }}</a>
												</li>
											</td>
											<td>
												<?php $checked = 0; ?>
												@foreach($game->contents as $content)
													@if($content->pivot->language_id == $language_id)
														<?php 
															$checked = $content->pivot->default;
															break;
														?>
													@endif
												@endforeach
												{{ Form::radio('default', null, $checked, array('class' => 'default', 'id' => $language_id)) }}
											</td>
										</tr>
									@endif
								@endforeach
							</table>
						</ul>
					@else
						<p>Please select one or more languages to add content to this game.</p>
					@endif
					<br>
					<h3>Prices:</h3>
					{{ Form::open(array('route' => array('admin.games.edit.prices', $game->id, $game->carrier_id), 'method' => 'post', 'id' => 'prices-form')) }}
						<br>
						@foreach($countries as $country)
							@foreach($selected_countries as $scid => $sc)
								@if($scid == $country->id)
									<?php $cprice = null; ?>
									@foreach($prices as $country_id => $price)
										@if($country_id == $scid)
											<?php $cprice = $price; ?>
										@endif
									@endforeach
									<li>
										<p>{{ $country->full_name }}</p>
										<p>
											{{ Form::label($scid, $sc.': ') }}
											{{ Form::text('prices['.$scid.']', $cprice, array('id' => $scid, 'class' => 'small-text')) }}
										</p>
										<br>
									</li>
								@endif
							@endforeach
						@endforeach
						{{ Form::submit('Update Prices') }}
					{{ Form::close() }}
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

	$('.default').on('click', function() {
    	var id = $(this).attr('id');

        $.ajax({
            type: "POST",
            url : "{{ URL::route('admin.game.languages.default') }}",
            data :{
            	"language_id": id,
            	"game_id": game_id
            }
        });
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
