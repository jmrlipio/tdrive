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
						<li>
							{{ Form::label('carrier_id', 'Carriers: ') }}
							{{ Form::select('carrier_id[]', $carriers, $selected_carriers, array('multiple' => 'multiple', 'id' => 'carriers', 'class' => 'chosen-select', 'data-placeholder'=>'Choose carriers(s)...'))  }}
							{{ $errors->first('carrier_id', '<p class="error">:message</p>') }}
						</li>
						{{ Form::submit('Update Fields', array('class' => 'update-content')) }}
					{{ Form::close() }}
				</ul>
				<ul id="game-content">
					<h3>The game has content for the following languages:</h3>
					<br>
					@if($selected_languages)
					<ul>
						@foreach($languages as $language_id => $language)
							@if(in_array($language_id, $selected_languages))
								<li><a href="{{ URL::route('admin.games.edit.content', array('game_id' => $game->id, 'language_id' => $language_id)) }}">{{ $language }}</a></li>
							@endif
						@endforeach
					</ul>
					@else
						<p>Please select one or more languages to add content to this game.
					@endif
					<br>
					<h3>The game has prices for the following carriers:</h3>
					@if($selected_carriers)
					<ul>
						@foreach($carriers as $carrier_id => $carrier)
							@if(in_array($carrier_id, $selected_carriers))
								<li><a href="{{ URL::route('admin.games.edit.prices', array('game_id' => $game->id, 'carrier_id' => $carrier_id)) }}">{{ $carrier }}</a></li>
							@endif
						@endforeach
					</ul>
					@else
						<p>Please select one or more carriers to add prices to this game.
					@endif
				</ul>
				<ul id="media">
					{{ Form::open(array('route' => array('admin.games.update-media', $game->id), 'method' => 'post', 'files' => true)) }}
						<h3>Orientation:</h3>
						<p>
							{{ Form::label('portrait', 'Portrait') }}
							{{ Form::radio('orientation', 'portrait', null, array('id' => 'portrait')) }}
						</p>
						<p>
							{{ Form::label('landscape', 'Landscape') }}
							{{ Form::radio('orientation', 'landscape', null, array('id' => 'landscape')) }}
						</p>
						<li>
							{{ Form::label('promo_image', 'Featured Image:', array('class' => 'image-label')) }} <br>
							{{ Form::file('promo_image') }}
						</li>
						<li>
							{{ Form::label('icon', 'Icon:', array('class' => 'image-label')) }} <br>
							{{ Form::file('icon') }}
						</li>
						<h3>Screenshots:</h3>
						<li>
							{{ Form::file('screenshots[]') }}
						</li>
						{{ Form::button('Add Screenshot', array('id' => 'add-img')) }}
						<br><br>
						{{ Form::submit('Update Media', array('class' => 'update-content')) }}
					{{ Form::close() }}
				</ul>

				<!--
				<ul id="media">
					{{-- Form::open(array('route' => array('admin.games.update-media', $game->id), 'method' => 'post')) --}}
						<li>
							{{-- Form::label('featured-img', 'Featured Image:') --}}
							<?php //$featured = false; ?>
							@//foreach($selected_media as $media)
								@//if($media['type'] == 'featured')
									<?php //$featured = true; ?>
									<div class="img-holder">
										<img src="{{-- $media['media_url'] --}}">
									</div>
									<p>
										{{-- Form::text('featured-img', $media['media_url'], array('id' => 'featured-img', 'class' => 'img-url', 'disabled')) --}}
										{{-- Form::hidden('featured_img_id', $media['media_id'], array('class' => 'hidden_id')) --}}
										{{-- Form::button('Select', array('class' => 'select-img')) --}}
									</p>
								@//endif
							@//endforeach
							@//if(!$featured)
								<div class="img-holder"></div>
								<p>
									{{-- Form::text('featured-img', null, array('id' => 'featured-img', 'class' => 'img-url', 'disabled')) --}}
									{{-- Form::hidden('featured_img_id', null, array('class' => 'hidden_id')) --}}
									{{-- Form::button('Select', array('class' => 'select-img')) --}}
								</p>
							@//endif
						</li>
						<br>
						<ul id="screenshots">
							<label>Images:</label>
							{{-- Form::button('Add Image', array('id' => 'add-img')) --}}<br>
							<?php 
								//$screenshot = false; 
								//$i = 1; 
							?>
							@//foreach($selected_media as $media)
								@//if($media['type'] == 'screenshot')
									<?php //$screenshot = true; ?>
									<li>
										<div class="img-holder">
											<img src="{{-- $media['media_url'] --}}">
										</div>
										<p>
											{{-- Form::text('screenshots', $media['media_url'], array('class' => 'img-url', 'disabled')) --}}
											{{-- Form::hidden('screenshot_id[]', $media['media_id'], array('class' => 'hidden_id')) --}}
											{{-- Form::button('Select', array('class' => 'select-img')) --}}
											@//if($i > 1)
												{{-- Form::button('Remove', array('class' => 'remove-img')) --}}
											@//endif
											<?php //$i++; ?>
										</p>
									</li>
								@//endif
							@//endforeach
							@//if(!$screenshot)
								<li>
									<div class="img-holder"></div>
									<p>
										{{-- Form::text('screenshots', null, array('class' => 'img-url', 'disabled')) --}}
										{{-- Form::hidden('screenshot_id[]', null, array('class' => 'hidden_id')) --}}
										{{-- Form::button('Select', array('class' => 'select-img')) --}}
									</p>
								</li>
							@//endif
						</ul>
						{{-- Form::submit('Update Media', array('class' => 'update-content')) --}}
					{{-- Form::close() --}}
				</ul>
				-->
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
		prices_list = $('#prices');

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
					<input name="screenshots[]" type="file"> \
				</li> \
				');
		});

		$('#tab-container > .etabs a').click(function() {
			$('body').scrollTop(0);
		});
	});

	/* Opens media dialog for selecting featured and screenshots images
	$("#media").on('click', '.select-img',function(){
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

	// Shows price fields for the game for the countries under the selected carriers
	$('#set-currency').on('click', function(){
		var prices_li = $('#prices').html('');
		prices_li.append('<div id="carrier-tab"></div>');

		var carrier_tab = prices_li.find('#carrier-tab');

		carrier_tab.html('');
		carrier_tab.append('<ul class="etabs"></ul>');
		carrier_tab.append('<div class="panel-container"></div>');

		$("#carriers option:selected").each(function() {
	    	var id = $(this).val();
	    	var carrier = $(this).text();

	    	var carrier_div = convertToSlug(carrier);

	    	var carrier_menu = '<li class="tab"><a href="#' + carrier_div + '">' + carrier + '</a></li>';
	    	carrier_tab.find('.etabs').append(carrier_menu);
	    	carrier_tab.find('.panel-container').append('<div id="' + carrier_div +'"></div>');

	    	$('#' + carrier_div).append('<h3>Prices for countries with ' + carrier + ' carrier:</h3>');
	    	$('#' + carrier_div).append('<input type="hidden" value="' + id + '">');
	    	loadCurrencies(id, carrier_div);
	    });

		carrier_tab.easytabs();
	});

	$('#set-content').on('click', function(){
		var llinks = $('#language-links').html('');



		$("#languages option:selected").each(function() {
			var id = $(this).val();
			var language = $(this).text();

			var link = '<a href="">' + language + '</a>';
			llinks.append(link);

		});

		content_tab.easytabs();
	});

	// Removes added field for screenshots on Images tab
	$("#media").on('click', '.remove-img',function(){
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

	// Ajax for selecting countries under selected carriers
	function loadCurrencies(cid, cdiv) {
		var carrier_div = $('#' + cdiv);

		$.get("{{ URL::route('carrier.load') }}", { carrier_id: cid }, function(data) {
			for(var id in data) {
				if (data.hasOwnProperty(id)) {
					var price = ' \
						<label for="' + id + '">' + data[id] + ': </label> \
						<input type="text" class="prices" name="prices' + cid + '[' + id +']" id="' + id + '">';

					carrier_div.append(price);
				}
			}
		});
	} */
    </script>
@stop