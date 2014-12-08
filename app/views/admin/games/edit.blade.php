@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')

	{{ Form::model($game, array('route' => array('admin.games.update', $game->id), 'method' => 'put', 'class' => 'large-form tab-container', 'id' => 'tab-container')) }}
		<h2>Edit Game</h2>
		<br>
		<ul class='etabs'>
			<li class='tab'><a href="#content">Content</a></li>
			<li class='tab'><a href="#custom-fields">Custom Fields</a></li>
			<li class='tab'><a href="#carriers">Carriers</a></li>
			<li class='tab'><a href="#media">Media</a></li>
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
					{{ Form::text('slug', null, array('id' => 'slug', 'class' => 'slug')) }}
					{{ $errors->first('slug', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('status', 'Status: ') }}
					{{ Form::select('status', array('1' => 'Draft', '2' => 'Live'))  }}
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
					{{ Form::label('content', 'Content:') }}
					{{ Form::textarea('content', null, array('id' => 'text-content')) }}
					{{ $errors->first('content', '<p class="error">:message</p>') }}
				</li>
			</ul>
			<ul id="custom-fields">
				<li>
					{{ Form::label('platform_id', 'Platforms: ') }}
					{{ Form::select('platform_id[]', $platforms, $selected_platforms, array('multiple' => 'multiple', 'class' => 'chosen-select', 'data-placeholder'=>'Choose platform(s)...'))  }}
					{{ $errors->first('platform_id', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('category_id', 'Categories: ') }}
					{{ Form::select('category_id[]', $categories, $selected_categories, array('multiple' => 'multiple', 'class' => 'chosen-select', 'data-placeholder'=>'Choose category(s)...'))  }}
					{{ $errors->first('category_id', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('language_id', 'Languages: ') }}
					{{ Form::select('language_id[]', $languages, $selected_languages, array('multiple' => 'multiple', 'class' => 'chosen-select', 'data-placeholder'=>'Choose language(s)...'))  }}
					{{ $errors->first('language_id', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('excerpt', 'Excerpt:') }}
					{{ Form::textarea('excerpt', null, array('id' => 'excerpt')) }}
					{{ $errors->first('excerpt', '<p class="error">:message</p>') }}
				</li>
			</ul>
			<ul id="carriers">
				<li>
					{{ Form::label('carrier_id', 'Carriers: ') }}
					{{ Form::select('carrier_id[]', $carriers, $selected_carriers, array('multiple' => 'multiple', 'id' => 'carriers', 'class' => 'chosen-select', 'data-placeholder'=>'Choose carriers(s)...'))  }}
					<br>
					{{ Form::button('Set Currencies', array('id' => 'set-currency')) }}
					{{ $errors->first('carrier_id', '<p class="error">:message</p>') }}
					{{-- Form::select('sports[]', $sports, null, array('multiple')) --}}
				</li>
				<li>
					{{ Form::label('default_price', 'Default Price: ') }}
					{{ Form::text('default_price') }}
				</li>
				<li id="prices">
					<div id="carrier-tab">
						<ul class="etabs">
							@foreach($carriers as $carrier)
								<li class="tab"><a href="#{{ $carrier }}">{{ $carrier }}</a></li>
							@endforeach
						</ul>
						<div class="panel-container">
							@foreach($carriers as $carrier_id => $carrier)
							<div id="{{ $carrier }}">
								<h3>Prices for countries with {{ $carrier }} carrier:</h3>
								@foreach($prices as $cid => $pid)
									@if($carrier_id == $pid['carrier_id'])
										@foreach($countries as $country)
											@if($country->id == $pid['country_id'])
												<label for="{{ $cid }}">{{ $country->currency_code }}:</label>
											@endif	
										@endforeach
										<input type="text" class="prices" name="prices{{ $pid['carrier_id'] }}['{{ $pid['country_id'] }}']" id="{{ $pid['country_id'] }}" value="{{ $pid['price'] }}">
									@endif
								@endforeach
							</div>
							@endforeach
						</div>
					</div>
				</li>
				
			</ul>
			<ul id="media">
				<li>
					{{ Form::label('featured-img', 'Featured Image:') }}
					<?php $featured = false; ?>
					@foreach($selected_media as $media)
						@if($media['type'] == 'featured')
							<?php $featured = true; ?>
							<div class="img-holder">
								<img src="{{ $media['media_url'] }}">
							</div>
							<p>
								{{ Form::text('featured-img', $media['media_url'], array('id' => 'featured-img', 'class' => 'img-url', 'disabled')) }}
								{{ Form::hidden('featured_img_id', $media['media_id'], array('class' => 'hidden_id')) }}
								{{ Form::button('Select', array('class' => 'select-img')) }}
							</p>
						@endif
					@endforeach
					@if(!$featured)
						<div class="img-holder"></div>
						<p>
							{{ Form::text('featured-img', null, array('id' => 'featured-img', 'class' => 'img-url', 'disabled')) }}
							{{ Form::hidden('featured_img_id', null, array('class' => 'hidden_id')) }}
							{{ Form::button('Select', array('class' => 'select-img')) }}
						</p>
					@endif
				</li>
				<br>
				<ul id="screenshots">
					<label>Images:</label>
					{{ Form::button('Add Image', array('id' => 'add-img')) }}<br>
					<?php 
						$screenshot = false; 
						$i = 1; 
					?>
					@foreach($selected_media as $media)
						@if($media['type'] == 'screenshot')
							<?php $screenshot = true; ?>
							<li>
								<div class="img-holder">
									<img src="{{ $media['media_url'] }}">
								</div>
								<p>
									{{ Form::text('screenshots', $media['media_url'], array('class' => 'img-url', 'disabled')) }}
									{{ Form::hidden('screenshot_id[]', $media['media_id'], array('class' => 'hidden_id')) }}
									{{ Form::button('Select', array('class' => 'select-img')) }}
									@if($i > 1)
										{{ Form::button('Remove', array('class' => 'remove-img')) }}
									@endif
									<?php $i++; ?>
								</p>
							</li>
						@endif
					@endforeach
					@if(!$screenshot)
						<li>
							<div class="img-holder"></div>
							<p>
								{{ Form::text('screenshots', null, array('class' => 'img-url', 'disabled')) }}
								{{ Form::hidden('screenshot_id[]', null, array('class' => 'hidden_id')) }}
								{{ Form::button('Select', array('class' => 'select-img')) }}
							</p>
						</li>
					@endif
				</ul>
				
			</ul>
			<br>
			<li>
				{{ Form::submit('Save', array('id' => 'save-game')) }}
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
		img_li,
		prices_list = $('#prices');

	$(document).ready(function() {
		// Initializes different tab sections
		$('.tab-container, #carrier-tab').easytabs();

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

        // Initializes Chosen Select for all multiple select fields
        $(".chosen-select").chosen();

        // Appends fields for adding screenshots on Images tab
		$('#add-img').click(function() {
			$('#screenshots').append(" \
				<li> \
					<div class='img-holder'></div> \
					<p> \
						<input class='img-url' type='text' name='screenshots' disabled> \
						<input type='hidden' name='screenshot_id[]' class='hidden_id'> \
						<button class='select-img' type='button'>Select</button> \
						<button class='remove-img' type='button'>Remove</button> \
					</p> \
				</li>");
		});

		$('#tab-container > .etabs a').click(function() {
			$('body').scrollTop(0);
		});
	});

	// Opens media dialog for selecting featured and screenshots images
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
	}
    </script>
@stop