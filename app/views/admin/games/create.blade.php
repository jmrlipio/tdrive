@extends('admin._layouts.admin')

@section('content')
	<h2>Create New Game</h2>
	<br>
	{{ Form::open(array('route' => 'admin.games.store', 'class' => 'create-form tab-container', 'id' => 'tab-container')) }}
		<ul class='etabs'>
			<li class='tab'><a href="#content">Content</a></li>
			<li class='tab'><a href="#custom-fields">Custom Fields</a></li>
			<li class='tab'><a href="#media">Media</a></li>
		</ul>
		<div class='panel-container'>
			<ul id="content">
				<li>
					{{ Form::label('title', 'Title: ') }}
					{{ Form::text('title', null, array('id' => 'title')) }}
					{{ $errors->first('title', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('slug', 'Slug: ') }}
					{{ Form::text('slug', null, array('id' => 'slug')) }}
					{{ $errors->first('slug', '<p class="error">:message</p>') }}
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
					{{ Form::textarea('content') }}
					{{ $errors->first('content', '<p class="error">:message</p>') }}
				</li>
			</ul>
			<ul id="custom-fields">
				<li>
					{{ Form::label('platforms', 'Platforms: ') }}
					{{ Form::select('platforms', $platforms, null, array('multiple' => 'multiple', 'class' => 'chosen-select', 'data-placeholder'=>'Choose platform(s)...'))  }}
					{{ $errors->first('platforms', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('categories', 'Categories: ') }}
					{{ Form::select('categories', $categories, null, array('multiple' => 'multiple', 'class' => 'chosen-select', 'data-placeholder'=>'Choose category(s)...'))  }}
					{{ $errors->first('categories', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('languages', 'Languages: ') }}
					{{ Form::select('languages', $languages, null, array('multiple' => 'multiple', 'class' => 'chosen-select', 'data-placeholder'=>'Choose language(s)...'))  }}
					{{ $errors->first('languages', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('currencies', 'Currencies: ') }}
					{{ Form::select('currencies', $currencies, null, array('multiple' => 'multiple', 'id' => 'currencies', 'class' => 'chosen-select', 'data-placeholder'=>'Choose currency(s)...'))  }}
					{{ $errors->first('currencies', '<p class="error">:message</p>') }}
				</li>
				<li id="prices">
					{{ Form::label('prices', 'Prices: ') }}
					{{ Form::button('Set Prices from Currencies', array('id' => 'currency', 'class' => 'currency')) }}
				</li>
				<li>
					{{ Form::label('excerpt', 'Excerpt:') }}
					{{ Form::textarea('excerpt') }}
					{{ $errors->first('excerpt', '<p class="error">:message</p>') }}
				</li>
			</ul>
			<ul id="media">
				
			</ul>
			<br>
			<li>
				{{ Form::submit('Save') }}
			</li>
		</div>

		{{ Form::hidden('user_id', Auth::user()->id) }}
	{{ Form::close() }}

	@include('admin._partials.image-select')

	{{ HTML::script('js/jquery-1.11.1.js') }}
    {{ HTML::script('js/jquery-ui.js') }}
    {{ HTML::script('js/tinymce/tinymce.min.js') }}
	{{ HTML::script('js/jquery.easytabs.min.js') }}
	{{ HTML::script('js/chosen.jquery.js') }}
	<script>
	$(document).ready(function() {
		tinymce.init({
			mode : "specific_textareas",
			selector: "textarea",
			height : 300
		});

        $("#release_date").datepicker({ dateFormat: 'yy-mm-dd' }).bind("change",function(){
            var minValue = $(this).val();
            minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
            minValue.setDate(minValue.getDate()+1);
            $("#to").datepicker( "option", "minDate", minValue );

    	});

        $(".chosen-select").chosen();
        $('#tab-container').easytabs();

        $('#title').on('blur', function() {
			$('#slug').val(convertToSlug($(this).val()));
		});
		
        $('#currency').on('click', function() {
        	var selected = String($('#currencies').val()).split(',');

        	$('#currencies option').each(function(){
        		var current = $(this);
        		for(var i = 0; i < selected.length; i++) {
        			if(current.val() == selected[i]) {
        				console.log(current.text());

        				$('#prices').append(
        					'<label for="' + current.val() + '">' + current.text() + '</label><input type="text" id="' + current.val() + '">'
        				);
        			}
        		}

        		// if($.inArray(current.val(), selected)) {
        		// 	console.log(current.text());
        		// }
        	});

		});

  //   	$("#selectedValue-img").click(function(){
  //   		$('#img-select').css('display', 'block');
  //   		var gallery = $('#img-gallery ul');
			
		// 	if(isEmpty(gallery)) {
		// 		$.get("{{ URL::route('media.load') }}",function(data){
		// 			for(var id in data) {
		// 				if (data.hasOwnProperty(id)) {
		// 					var app =  '<li><input name="imgs" type="radio" value="A" id="' + id + '"><label for="' + id + '"><img src="' + data[id] + '" data-value="' + id + '"></label></li>';
		// 			    	gallery.append(app);
		// 			    }
		// 			}
		// 		});
		// 	}
		// });

		// $("#close-img-select").click(function() {
		// 	$('#img-select').css('display', 'none');
		// });

		// $("#choose-img").click(function() {
		// 	var checked = false;
		// 	var id, value;
		// 	$('#img-gallery ul input[type=radio]').each(function() {
		// 		if($(this).is(':checked')) {
		// 			var selected = $(this).parent().find('img');
		// 			value = selected.attr('src');
		// 			id = selected.data('value');
		// 		}
		// 	});

		// 	$("#featured").val(value);
		// 	$("#featured").attr('data-value', id);
		// 	$('#img-select').css('display', 'none');
		// });

		
	});

	function isEmpty(el){
		return !$.trim(el.html())
	}

	function convertToSlug(text){
	    return text
	        .toLowerCase()
	        .replace(/[^\w ]+/g,'')
	        .replace(/ +/g,'-')
	        ;
	}


    </script>
@stop