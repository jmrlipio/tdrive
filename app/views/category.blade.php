@extends('_layouts/listing')

@section('stylesheets')
@stop

@section('content')
	
	<div class="container">
		
		<div class="clearfix">
			<h1 class="title">{{{ Language::getVariant($category->id,Session::get('locale')) }}}</h1>

			<div class="search-category">

				{{ Form::open(array('action' => 'ListingController@searchGamesByCategory', 'id' => 'search_form_by_category', 'class' => 'clearfix')) }}
					{{ Form::input('text', 'search', null, array('placeholder' => trans('global.search games in this category'))); }}
					{{ Form::hidden('id', $category->id) }}

					<a href="javascript:{}" onclick="document.getElementById('search_form_by_category').submit(); return false;"><i class="fa fa-search"></i></a>

					{{ Form::token() }}
				{{ Form::close() }}

			</div>
		</div>

		<div id="token">{{ Form::token() }}</div>

		<div class="grid">
			<div class="row">
				<div id="scroll" class="clearfix">

					@foreach ($games as $game)												
						@foreach($game->apps as $app)
							<?php $iso_code = ''; ?>
							@foreach($languages as $language)
								@if($language->id == $app->pivot->language_id)
									<?php $iso_code = strtolower($language->iso_code); ?>
								@endif
							@endforeach
							
							@if($app->pivot->status != Constant::PUBLISH)
								<?php continue; ?>
							@endif	

							@if($iso_code == Session::get('locale') && $app->pivot->carrier_id == Session::get('carrier'))
								<div class="item">
									@include('_partials/game-thumb')
								</div>
							@endif

						@endforeach
					@endforeach

				</div>
			</div>
		</div>

		<div class="ajax-loader center"><i class="fa fa-cog fa-spin"></i> loading&hellip;</div>
	</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}
	@include('_partials/scripts')
	<script>
		FastClick.attach(document.body);

		var load = 0;
		var category_id = {{ $category->id }};
		var page = ({{ $page }} / 1);
		var token = $('input[name="_token"]').val();

		$(window).scroll(function() {
			var bottom = 50;
			var scroll = true;
				if ($(window).scrollTop() + $(window).height() > $(document).height() - bottom) 
				{
					$.ajax({
						url: "{{ url() }}/category/load/more",
						type: "POST",
						data: {
							page: page,
							category_id: category_id,
							_token: token
						},
						success: function(data) {
							console.log(data);
							page++;
							$('#scroll').append(data);
							$('.ajax-loader').hide();
						}
					});
				}



			
		});
	</script>
@stop
