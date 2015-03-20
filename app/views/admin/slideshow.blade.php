@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.options-nav')
	<article>
		<h2>Homepage</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif

		<br>
		<div class='large-form tab-container' id='tab-container'>
			<ul class='etabs'>
				<li class='tab'><a href="#slider">Slider</a></li>
				<li class='tab'><a href="#categories">Categories</a></li>
			</ul>
			<div class='panel-container'>
				<ul id="slider">
					<div class="option-select">
						<li>
							{{ Form::label('game_id', 'Games: ') }} <br><br>
							{{ Form::select('game_id[]', $games, null, array('multiple' => 'multiple', 'class' => 'chosen-select', 'id' => 'games', 'data-placeholder'=>'Choose game(s)...'))  }}
							{{ $errors->first('game_id', '<p class="error">:message</p>') }}
						</li>
						<li>
							{{ Form::label('news_id', 'News: ') }} <br><br>
							{{ Form::select('news_id[]', $news, null, array('multiple' => 'multiple', 'class' => 'chosen-select', 'id' => 'news','data-placeholder'=>'Choose game(s)...'))  }}
							{{ $errors->first('news_id', '<p class="error">:message</p>') }}
						</li>
					</div>
					{{ Form::open(array('route' => 'admin.featured.update')) }}
						<ul class="sortable-items" id="sortables">
							
						</ul>
						{{ Form::submit('Save Order') }}
					{{ Form::close() }}
					<div class="clear"></div>
				</ul>
				<ul id="categories">
					
				</ul>
			</div>
		</div>
	</article>
	{{ HTML::script('js/jquery.easytabs.min.js') }}
	{{ HTML::script('js/chosen.jquery.js') }}
	<script>
		$("document").ready(function(){
			$('.tab-container').easytabs();
			$(".chosen-select").chosen();

			$('#sortables').sortable();

			$('.chosen-select').on('change', function(evt, selected) {
				var selector = $(this),
					type = $(this).attr('id'),
					sortables = $('#sortables');

				if(selected.selected != null) {
					var options = selector.children(":selected");

					options.each(function(){
						if($(this).val() == selected.selected) {

							var append = '<li class="grab"> \
											<div class="item-title"> ' + $(this).text() + '</div> \
											<div class="item-type"> ' + type + '</div> \
											<input type="hidden" name="item[' + selected.selected + ']" value="' + type +'"> \
										  </li>';

							sortables.append(append);
						}
					});
				} else {
					alert(selected.deselected);
				}
			});

			

			// $('.chosen-select option:selected').each(function(){
			// 	alert($(this).val());
			// });

			// $('#sortables li').each(function() {
			// 	var item = $(this);
			// 	item.mousedown(function() { item.removeClass('grab'); item.addClass('grabbing'); });
				
			// });

			// $('.chosen-select option').on('click', function() {
			// 	alert('test');
			// });
		});

		$('#sortables').on('li',function(){
			var item = $(this);

			item.mouseup(function(){ alert('test'); });
		});
	</script>
@stop