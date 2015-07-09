@extends('_layouts/listing')

@section('stylesheets')
<style>
	
	.discounted { text-decoration: line-through; }

</style>
@stop

@section('content')

	<div class="container">

		<h1 class="title">{{ trans('global.Related games for ') }} {{ $game->main_title; }}</h1>

		<div class="search-category">

			{{ Form::open(array('action' => 'ListingController@searchRelatedGames', 'id' => 'search_form_related', 'class' => 'clearfix')) }}
				{{ Form::input('text', 'search', null, array('placeholder' => trans('global.search game'))); }}
				{{ Form::hidden('id', $category->id) }}
				<a href="javascript:{}" onclick="document.getElementById('search_form_related').submit(); return false;"><i class="fa fa-search"></i></a>

				{{ Form::token() }}
			{{ Form::close() }}

		</div>

		<div id="token">{{ Form::token() }}</div>

		<div class="grid">
			<div class="row">
				<div id="scroll" class="clearfix">
					<?php $count = 0; ?>
					@foreach ($games as $game)
						@foreach($game->apps as $app)
							<?php $iso_code = ''; ?>
							@foreach($languages as $language)
								@if($language->id == $app->pivot->language_id)
									<?php $iso_code = strtolower($language->iso_code); ?>
								@endif
							@endforeach
							<input type="hidden" class="game-id" value="{{ $game->id }}">
							@if($iso_code == Session::get('locale') && $app->pivot->carrier_id == Session::get('carrier') && $app->pivot->status == Constant::PUBLISH && $game_id != $game->id)									
								<?php $count++; ?>
								<div class="swiper-slide item">
									@include('_partials/game-thumb')
								</div>		
							@endif						
						@endforeach
					@endforeach
					@if($count == 0)
						<div class="swiper-slide item">
							<p>{{ trans('global.No related games.') }}</p>
						</div>	
					@endif
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
		var num = {{ $count }};
		var page = {{ $page }};
		var token = $('input[name="_token"]').val();

		$(window).scroll(function() {
			var bottom = 70;
			var scroll = true;
				if ($(window).scrollTop() + window.innerHeight == $(document).height()) 
				{
					$('.ajax-loader').show();
					$.ajax({
						url: "{{ URL::route('games.related.more', array('id' => $game_id)) }}",
						type: "POST",
						data: {
							page: page,
							_token: token
						},
						success: function(data) {
							// $(window).bind('scroll');
							page++;
							$('#scroll').append(data);
							$('.ajax-loader').hide();
						}
					});
				}
			});
	</script>
@stop
