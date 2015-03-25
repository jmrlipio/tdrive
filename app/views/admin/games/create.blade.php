@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
		<article class='large-form tab-container' id='create-game'>
			<h2>Create New Game</h2>
			<br>
			@if(Session::has('message'))
			    <div class="flash-success">
			        <p>{{ Session::get('message') }}</p>
			    </div>
			@endif
			<div class='panel-container'>
				{{ Form::open(array('route' => 'admin.games.store')) }}
					<ul id="custom-fields">
						<li>
							{{ Form::label('app_id', 'App ID:') }}
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
					</ul>
					{{ Form::hidden('user_id', Auth::user()->id) }}
					{{ Form::submit('Save', array('id' => 'save-game')) }}
				{{ Form::close() }}
				<!--<ul id="content">
					<li>
						{{-- Form::label('language_id', 'Languages: ') --}}
						{{-- Form::select('language_id[]', $languages, null, array('multiple' => 'multiple', 'class' => 'chosen-select', 'id' => 'languages', 'data-placeholder'=>'Choose language(s)...'))  --}}
						{{-- $errors->first('language_id', '<p class="error">:message</p>') --}}
						<br>
						{{-- Form::button('Set Content', array('id' => 'set-content')) --}}
					</li>
					<br>
					<li id="language-content">
						<div id="content-tab"></div>
					</li>
					<li>
						{{-- Form::label('category_id', 'Categories: ') --}}
						{{-- Form::select('category_id[]', $categories, null, array('multiple' => 'multiple', 'class' => 'chosen-select', 'data-placeholder'=>'Choose category(s)...'))  --}}
						{{-- $errors->first('category_id', '<p class="error">:message</p>') --}}
					</li>
				</ul>
				<ul id="carriers">
					<li>
						{{-- Form::label('carrier_id', 'Carriers: ') --}}
						{{-- Form::select('carrier_id[]', $carriers, null, array('multiple' => 'multiple', 'id' => 'carriers', 'class' => 'chosen-select', 'data-placeholder'=>'Choose carriers(s)...'))  --}}
						<br>
						{{-- Form::button('Set Currencies', array('id' => 'set-currency')) --}}
						{{-- $errors->first('carrier_id', '<p class="error">:message</p>') --}}
						{{-- Form::select('sports[]', $sports, null, array('multiple')) --}}
					</li>
					
					<li id="prices">
						<div id="carrier-tab"></div>
					</li>
				</ul>
				<ul id="media">
					<li>
						{{-- Form::label('featured-img', 'Featured Image:') --}}
						<div class="img-holder"></div>
						<p>
							{{-- Form::text('featured-img', null, array('id' => 'featured-img', 'class' => 'img-url', 'disabled')) --}}
							{{-- Form::hidden('featured_img_id', null, array('class' => 'hidden_id')) --}}
							{{-- Form::button('Select', array('class' => 'select-img')) --}}
						</p>
					</li>
					<br>
					<ul id="screenshots">
						<label>Images:</label>
						{{-- Form::button('Add Image', array('id' => 'add-img')) --}}<br>
						<li>
							<div class="img-holder"></div>
							<p>
								{{-- Form::text('screenshots', null, array('class' => 'img-url', 'disabled')) --}}
								{{-- Form::hidden('screenshot_id[]', null, array('class' => 'hidden_id')) --}}
								{{-- Form::button('Select', array('class' => 'select-img')) --}}
							</p>
						</li>
					</ul>
					
				</ul>
				<br>
				<li>
					{{-- Form::submit('Save', array('id' => 'save-game')) --}}
				</li>
		-->
		</div>
	</article>

	@include('admin._partials.image-select')
    {{-- HTML::script('js/tinymce/tinymce.min.js') --}}
	{{ HTML::script('js/jquery.easytabs.min.js') }}
	{{ HTML::script('js/ckeditor/ckeditor.js') }}
	{{ HTML::script('js/chosen.jquery.js') }}
	{{ HTML::script('js/form-functions.js') }}
	<script>
	var gallery = $('#img-gallery ul'), 
		img_li,
		prices_list = $('#prices');

	$(document).ready(function() {
		// Date picker for Release Date
        $("#release_date").datepicker({ dateFormat: 'yy-mm-dd' }).bind("change",function(){
            var minValue = $(this).val();
            minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
            minValue.setDate(minValue.getDate()+1);
            $("#to").datepicker( "option", "minDate", minValue );
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
		var content_li = $('#language-content').html('');
		content_li.append('<div id="content-tab"></div>');

		var content_tab = content_li.find('#content-tab');

		content_tab.html('');
		content_tab.append('<ul class="etabs"></ul>');
		content_tab.append('<div class="panel-container"></div>');

		$("#languages option:selected").each(function() {
			var id = $(this).val();
			var language = $(this).text();

			var content_div = convertToSlug(language);

			var content_menu = '<li class="tab"><a href="#' + content_div + '">' + language + '</a></li>';
			content_tab.find('.etabs').append(content_menu);
			content_tab.find('.panel-container').append('<div id="' + content_div + '"></div>');

			var title = '<li> \
							<label for="title-' + content_div + '">Title: </label> \
							<input id="title-' + content_div + '" name="title[]" type="text"> \
						 </li>';

			var content = '<li> \
								<label for="content-' + content_div + '">Content: </label> \
								<textarea id="content-' + content_div + '" name="content[]" class="ckeditor"></textarea> \
						   </li>';

			var excerpt = '<li> \
								<label for="excerpt-' + content_div + '">Excerpt: </label> \
								<textarea name="excerpt[]" class="excerpt" id="excerpt-' + content_div + '"></textarea>\
						   </li>';

			$('#' + content_div).append(title);
			$('#' + content_div).append(content);
			$('#' + content_div).append(excerpt);

	    	CKEDITOR.replace('content-' + content_div);
	    	CKEDITOR.add;
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
	}
	*/
    </script>
@stop