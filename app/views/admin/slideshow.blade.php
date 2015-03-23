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
							{{ Form::select('game_id[]', $games, $selected_games, array('multiple' => 'multiple', 'class' => 'chosen-select', 'id' => 'game', 'data-placeholder'=>'Choose game(s)...'))  }}
							{{ $errors->first('game_id', '<p class="error">:message</p>') }}
						</li>
						<li>
							{{ Form::label('news_id', 'News: ') }} <br><br>
							{{ Form::select('news_id[]', $news, $selected_news, array('multiple' => 'multiple', 'class' => 'chosen-select', 'id' => 'news','data-placeholder'=>'Choose game(s)...'))  }}
							{{ $errors->first('news_id', '<p class="error">:message</p>') }}
						</li>
					</div>
					{{ Form::open(array('route' => 'admin.featured.update')) }}
						<ul class="sortable-items" id="sortables">
							@foreach($sliders as $slider)
								<li class="grab">
									@if($slider->slideable_type == 'Game')
										@foreach($games as $key => $game)
											@if($key == $slider->slideable_id)
												<div class="item-title">{{ $game }}</div>
												<div class="item-type">game</div>
												<input type="hidden" name="item[][game]" value="{{ $slider->slideable_id }}">
											@endif
										@endforeach
										
									@elseif($slider->slideable_type == 'News')
										@foreach($news as $key => $nw)
											@if($key == $slider->slideable_id)
												<div class="item-title">{{ $nw }}</div>
												<div class="item-type">news</div>
												<input type="hidden" name="item[][news]" value="{{ $slider->slideable_id }}">
											@endif
										@endforeach
										
									@endif


								</li>
							@endforeach
						</ul>
						{{ Form::submit('Save Order') }}
					{{ Form::close() }}
					<div class="clear"></div>
				</ul>
				<ul id="categories">
					<div class="option-select">
						<li>
							{{ Form::label('categories', 'Featured Categories: ') }} <br><br>
							{{ Form::select('categories[]', $categories, $selected_categories, array('multiple' => 'multiple', 'class' => 'chosen-select', 'id' => 'categories', 'data-placeholder'=>'Choose categories(s)...'))  }}
							{{ $errors->first('categories', '<p class="error">:message</p>') }}
						</li>
					</div>
					{{ Form::open(array('route' => 'admin.featured.categories.update')) }}
						<ul class="sortable-items" id="sortable-categories">
							@foreach($categories as $key => $category)
								@if(in_array($key, $selected_categories))
									<li class="grab">{{ $category }}</li>
								@endif
							@endforeach
						</ul>
						{{ Form::submit('Save Order') }}
					{{ Form::close() }}
					<div class="clear"></div>
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

			$('.sortable-items').sortable();

			$('.sortable-items li').each(function() {
				var item = $(this);
				item.mousedown(function() {
					item.removeClass('grab');
					item.addClass('grabbing');
				});

				item.mouseup(function() {
					item.removeClass('grabbing');
					item.addClass('grab');
				});
				
			});

			$('#game, #news').on('change', function(evt, selected) {
				var selector = $(this),
					type = $(this).attr('id'),
					sortables = $('#sortables'),
					count = 0;

				$('#sortables li').each(function(){
					count++;
				});

				if(selected.selected != null) {
					var options = selector.children(":selected");

					options.each(function(){
						if($(this).val() == selected.selected) {

							var append = '<li class="grab"> \
											<div class="item-title"> ' + $(this).text() + '</div> \
											<div class="item-type"> ' + type + '</div> \
											<input type="hidden" name="item[][' + type + ']" value="' + selected.selected +'"> \
										  </li>';

							sortables.append(append);
						}
					});
				} else {

					$('#sortables li').each(function(){
						var item_type = $(this).find('.item-type').text();
						var item_id = $(this).find('input[type=hidden]').val();

						if(item_type == type && item_id == selected.deselected) {
							$(this).remove();
						}
					});
					
				}
			});

			$('#categories').on('change', function(evt, selected) {
				var selector = $(this),
					sortables = $('#sortable-categories');

				if(selected.selected != null) {

				} else {

				}

			});

			
		});

	</script>
@stop