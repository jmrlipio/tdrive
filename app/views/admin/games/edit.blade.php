@extends('admin._layouts.admin')
@section('stylesheets')
	<style>
		p.published {color: green;}
		p.draft {color: #555;}
	</style>
@stop
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
					{{ Form::token() }}
					{{ Form::model($game, array('route' => array('admin.games.update', $game->id), 'method' => 'put')) }}
						<li>
							{{ Form::label('id', 'Game ID:') }}
							<p>{{ str_pad($game->id, 4, '0', STR_PAD_LEFT) }}</p>
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
							<th>Status</th>
							<th>App ID</th>
							<th>Carrier</th>
							<th>Language</th>
							<th>Price</th>
							<th>Action</th>
						</tr>

						@if(count($game->apps))
							@foreach($game->apps as $app)								
								<tr>
									<td>
										<p>
											@foreach(Constant::app_status() as $key => $value)
												@if($app->pivot->status == $key)

													<p class="published">{{ $value }}</p>
													<?php break; ?>
												
												@else
																									
													<p class="draft">{{ 'Draft' }}</p> 
													<?php break; ?>
												@endif
												
											@endforeach
										</p>
									</td>
									<td>
										<p>
											{{ $app->pivot->app_id }}
										</p>
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
										 {{ $app->pivot->currency_code }} {{ $app->pivot->price }}
									</td>
									<td>

										<a href="{{ URL::route('admin.games.edit.app', array('game_id' => $game->id, 'app_id' => $app->pivot->app_id)) }}" class='edit-btn fleft'>
											Edit
										</a>
										{{ Form::open(array('route' => array('admin.games.delete.app', $game->id, $app->pivot->app_id), 'method' => 'delete', 'class' => 'delete-form')) }}
											{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
										{{ Form::close() }}
									</td>
								</tr>
							@endforeach
						@else
							<tr>
						    	<td colspan="6" class="center">You haven't created any apps yet.</td>
						    </tr>
						@endif

					</table>
				</ul>
				<ul id="media">
						<li>
							{{ Form::label('video', 'Video URL: ', array('class' => 'media-label')) }}
							@foreach($selected_media as $media)
								@if($media['type'] == 'video')
									<?php $video = $media['media_url']; ?>
								@endif
							@endforeach
							<?php if(!isset($video)) $video = null; ?>
							{{ Form::text('video', $video, array('class' => 'media-video')) }}<span class="loader"></span>
							
						</li>
						<div class="clear"></div>
						<li>
							{{ Form::open(array('route' => array('admin.games.postupdate-media', $game->id), 'method' => 'post', 'files' => true, 'class' => 'post-media-form promo-form')) }}
							{{ Form::label('promo', 'Promo Image:', array('class' => 'media-label')) }}
							<input type="hidden" value="this is a text" name="promo-code" />
							<div id="message"></div>
								<?php $image = Media::getGameImages($game->id, 'promos'); ?>
									<div class="media-box">
										@if($image)
											<img src="{{ asset('assets/games/promos') }}/{{ $image['url'] }}" class="image-preview" alt="image_preview"/>
						            	@else
						            		<img src="{{ asset('images/default-450x200.png') }}" class="image-preview" alt="image_preview"/>
						            	@endif
						            	 <div style="position:relative; width: 100px; top: -35px">
						              		<a class='btn btn-primary upload-trigger' href='javascript:;'>
						                    <span>change</span>
						                    <input type="file" name="promos" id="promos" class="media-file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' size="60"  onchange='$("#upload-file-info").html($(this).val());'>
						             		</a>
							        	</div>
						            </div>
							{{ Form::close() }}
							<div class="clear"></div>
						</li>
						<li>
							{{ Form::open(array('route' => array('admin.games.postupdate-media', $game->id), 'method' => 'post', 'files' => true, 'class' => 'post-media-form')) }}
							{{ Form::label('icon', 'Icon:', array('class' => 'media-label')) }}
								<?php $image = Media::getGameImages($game->id, 'icons'); ?>
									<div class="media-box media-icon">
										@if($image)
											<img src="{{ asset('assets/games/icons') }}/{{ $image['url'] }}" class="image-preview" alt="image_preview"/>
						            	@else
						            		<img src="{{ asset('images/default-300x300.png') }}" class="image-preview" alt="image_preview"/>
						            	@endif
						            	 <div style="position:relative; width: 100px; top: -35px">
						              		<a class='btn btn-primary upload-trigger' href='javascript:;'>
						                    <span>change</span>
						                    <input type="file" name="icons" id="icons" class="media-file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' size="60"  onchange='$("#upload-file-info").html($(this).val());'>
						             		</a>
							        	</div>
						            </div>
							{{ Form::close() }}
							<div class="clear"></div>
						</li>
						<li>
							{{ Form::open(array('route' => array('admin.games.postupdate-media', $game->id), 'method' => 'post', 'files' => true, 'class' => 'post-media-form')) }}
							{{ Form::label('homepage', 'Homepage Image:', array('class' => 'media-label')) }}
								<?php $image = Media::getGameImages($game->id, 'homepage'); ?>
									<div class="media-box">
										@if($image)
											<img src="{{ asset('assets/games/homepage') }}/{{ $image['url'] }}" class="image-preview" alt="image_preview"/>
						            	@else
						            		<img src="{{ asset('images/default-450x200.png') }}" class="image-preview" alt="image_preview"/>
						            	@endif
						            	 <div style="position:relative; width: 100px; top: -35px">
						              		<a class='btn btn-primary upload-trigger' href='javascript:;'>
						                    <span>change</span>
						                    <input type="file" name="homepage" id="homepage" class="media-file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' size="60"  onchange='$("#upload-file-info").html($(this).val());'>
						             		</a>
							        	</div>
						            </div>
							{{ Form::close() }}
							<div class="clear"></div>
						</li>
						<li>
							{{ Form::label('image_orientation', 'Orientation: ') }}
							{{ Form::select('image_orientation', array('portrait' => 'Portrait', 'landscape' => 'Landscape'), $game->image_orientation, array('id' => 'orientation'))  }}
							{{ $errors->first('orientation', '<p class="error">:message</p>') }}
						</li>
						<li>
							
							{{ Form::label('screenshots', 'Screenshots: ', array('class' => 'media-label')) }}
							<div class="screenshot-box">
								@foreach($selected_media as $media)
									@if($media['type'] == 'screenshots')
										<div class="media-box ss-medium">
											{{ HTML::image($media['media_url'],  null , array('class' => 'image-preview')) }}
						            		 <div style="position:relative; width: 100px; top: -35px">
						            		 	<a href="#" class="arrow remove-btn media-remove-btn" ssid="{{$media['media_id'] }}"></a>
						            		 	{{ Form::hidden('orientation', $media['orientation'] , array('class' => 'screenshot-media')) }}
							        		</div> 
										</div>
									@endif
								@endforeach

								<div id="add-box" class="media-box ss-medium">
									{{ Form::open(array('route' => array('admin.games.postupdate-media', $game->id), 'method' => 'post', 'files' => true, 'class' => 'post-media-form')) }}
										<a class='upload-trigger' href='javascript:;'>
										
										<img src="{{ asset('images/default-300x300.png') }}" alt="addbox" class="addbox-media" />
						            	 <div style="position:relative; width: 100px; top: -35px">
						            	 	<span class="screenshot-loader"></span>
						                    {{ Form::hidden('orientation-ss', '' , array('class' => 'screenshot-media')) }}
						                    <input type="file" name="screenshots" id="homepage" class="ss-media-file" style='position:absolute;z-index:2;top:-167px;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;width:220px;height:200px;' size="60"  onchange='$("#upload-file-info").html($(this).val());'>						      
							        	</div>
							        	</a>
						        	{{ Form::close() }}
					            </div>
							</div>
							<div class="clear"></div>
						</li>
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
	{{ HTML::script('js/form.min.js') }}
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
	$("#media").on('click', '.remove-btn',function(e){
		e.preventDefault();
		$(this).closest('.media-box').remove();
	});

    </script>
    <script>
    	$(function() {
    		var token = $('input[name="_token"]').val();

    		$(document).on('click', '.media-remove-btn', function(e) {
    				e.preventDefault();
    				var ssid = $(this).attr('ssid');
    				var media = $(this).closest('.media-box');
    				$.ajax({
			            type: 'POST',
			            url: '{{ URL::route("admin.games.destroy-media") }}',
			            data: { ssid: ssid,
			            		orientation: media.find('.screenshot-media').val(),
			            		_token: token  },
			            success: function (data) {
			            		media.remove();
			            		console.log(data);
			                	//loader.html('');
			            	}
			       });
    		});

    		$(".media-video").change(function() {
    			var loader = $(".loader");
    			loader.html('<span class="loader-icon-black"></span>');
				$.ajax({
		            type: 'POST',
		            url: '{{ URL::route("admin.games.postupdate-media", $game->id) }}',
		            data: { video: $(this).val(),
		            		_token: token  },
		            success: function (data) {
		                	loader.html('');
		            	}
			       });
    		});

			$(".media-file").change(function() {
				var file_input = $(this);
				var media = $(this).closest('li');
				var img = media.find('.image-preview');
				var frm = media.find('.post-media-form');
				var btn = media.find('.upload-trigger span');

				$("#message").empty(); // To remove the previous error message

				var file = this.files[0];
				var imagefile = file.type;
				var match= ["image/jpeg","image/png","image/jpg"];

				if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
				{
					$('#previewing').attr('src','noimage.png');
					$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
					return false;
				}
				else
				{
					var reader = new FileReader();
					reader.onload = function(e) {
						$('#image_preview').css("display", "block");
						img.attr('src', e.target.result);
						img.attr('width', '250px');
						img.attr('height', '230px');
					}

					reader.readAsDataURL(this.files[0]);

					var form = $('.promo-form');
					//form.submit();
				    frm.submit(function (ev) {
				    	var formData = new FormData(this);
				    	btn.html('<span class="loader-icon"></span>Saving..');
				        $.ajax({
				            type: frm.attr('method'),
				            url: frm.attr('action'),
				            data: formData,
				            mimeType:"multipart/form-data",
						    contentType: false,
						    cache: false,
						    processData:false,
				            success: function (data) {
				                	btn.html('Change');
				            }
				        });
				        ev.preventDefault();
				        $(this).unbind('submit');
				    });
				    frm.submit();
				}
			});
			//screenshots
			var orientation = $('#orientation');
			var orientation_post = $('.screenshot-media');
			orientation_post.val(orientation.val());
			
			orientation.change(function() {
				orientation_post.val($(this).val());
			})

			$(".ss-media-file").change(function() {
				
				var file_input = $(this);
				var box = $('#add-box');
				var wrapper = $('.screenshot-box');
				var media = $(this).closest('.media-box');
				var frm = box.find('.post-media-form');
				var btn = media.find('.screenshot-loader');
	    		var mediabox = '<div class="media-box ss-medium"><img src="{src}" class="image-preview"><div style="position:relative; width: 100px; top: -35px"><a href="#" class="arrow remove-btn media-remove-btn" ssid="{ssid}"></a><input type="hidden" name="orientation" class="screenshot-media" value="{orientation}" /></div></div>';	

				var file = this.files[0];
				var imagefile = file.type;
				var match= ["image/jpeg","image/png","image/jpg"];

				if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
				{
					$('#previewing').attr('src','noimage.png');
					$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
					return false;
				}
				else
				{
					var reader = new FileReader();
					reader.onload = function(e) {
						$('#image_preview').css("display", "block");
						mediabox = mediabox.replace('{src}', e.target.result );
						//$(mediabox).insertBefore(box);
					}

					reader.readAsDataURL(this.files[0]);

				    frm.submit(function (ev) {
				    	console.log('submit');
				    	var formData = new FormData(this);
				    	btn.html('<span class="loader-image"></span>');
				        $.ajax({
				            type: frm.attr('method'),
				            url: frm.attr('action'),
				            data: formData,
				            mimeType:"multipart/form-data",
						    contentType: false,
						    cache: false,
						    processData:false,
				            success: function (data) {
				            	var data = jQuery.parseJSON( data );
			                	mediabox = mediabox.replace('{ssid}', data.id );
			                	mediabox = mediabox.replace('{orientation}', data.orientation );
			                	$(mediabox).insertBefore(box);
			                	btn.html('');
				            }
				        });
				        ev.preventDefault();
				        $(this).unbind('submit');
				    });
				    frm.submit();
				}
			});
		});

    </script>
@stop
