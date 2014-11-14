@extends('admin._layouts.admin')

@section('content')
	<h2>Create New Game</h2>
	<br>
	{{ Form::open(array('route' => 'admin.games.store', 'class' => 'create-form')) }}
		<ul>
			<li>
				{{ Form::label('name', 'Game name:') }}
				{{ Form::text('name') }}
				{{ $errors->first('name', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('price', 'Price:') }}
				{{ Form::text('price') }}
				{{ $errors->first('username', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('type_id', 'Game Type:') }}
				{{ Form::select('type_id', $types)  }}
				{{ $errors->first('username', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('release_date', 'Release Date:') }}
				{{ Form::text('release_date', null, array('id' => 'release_date')) }}
				{{ $errors->first('release_date', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('description', 'Description') }}
				{{ Form::textarea('description') }}
				{{ $errors->first('description', '<p class="error">:message</p>') }}
			</li>
			<br>
			<li>
				{{ Form::label('featured', 'Featured Image:') }}
				<p>
					{{ Form::text('featured') }}
					{{ Form::button('Select', array('id' => 'select-img')) }}
				</p>
			</li>
			<br>
			<li>
				{{ Form::submit('Save') }}

			</li>
		 
		</ul>
		

		{{ Form::hidden('user_id', Auth::user()->id) }}
	{{ Form::close() }}

	@include('admin._partials.image-select')

	{{ HTML::script('js/jquery-1.11.1.js') }}
    {{ HTML::script('js/jquery-ui.js') }}
    {{ HTML::script('js/tinymce/tinymce.min.js') }}

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

    	$("#select-img").click(function(){
    		$('#img-select').css('display', 'block');
    		var gallery = $('#img-gallery ul');
			
			if(isEmpty(gallery)) {
				$.get("{{ URL::route('media.load') }}",function(data){
					for(var id in data) {
						if (data.hasOwnProperty(id)) {
							var app =  '<li><input name="imgs" type="radio" value="A" id="' + id + '"><label for="' + id + '"><img src="' + data[id] + '" data-value="' + id + '"></label></li>';
					    	gallery.append(app);
					    }
					}
				});
			}
		});

		$("#close-img-select").click(function() {
			$('#img-select').css('display', 'none');
		});

		$("#choose-img").click(function() {
			var checked = false;
			var id, value;
			$('#img-gallery ul input[type=radio]').each(function() {
				if($(this).is(':checked')) {
					var selected = $(this).parent().find('img');
					value = selected.attr('src');
					id = selected.data('value');
				}
			});

			$("#featured").val(value);
			$("#featured").attr('data-value', id);
			$('#img-select').css('display', 'none');
		});
	});

	function isEmpty(el){
		return !$.trim(el.html())
	}
    </script>
@stop