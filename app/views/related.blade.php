@extends('_layouts/listing')

@section('stylesheets')
<style>
	
	.discounted { text-decoration: line-through; }

</style>
@stop

@section('content')

	<div class="container">

		<h1 class="title">{{ trans('global.Related games for ') }} {{ $game->slug; }}</h1>

		<div id="token">{{ Form::token() }}</div>

		<div class="grid">
			<div class="row">
				<div id="scroll" class="clearfix">
					@foreach ($related_games as $game)
						@foreach($game->apps as $app)
							<?php $iso_code = ''; ?>
							@foreach($languages as $language)
								@if($language->id == $app->pivot->language_id)
									<?php $iso_code = strtolower($language->iso_code); ?>
								@endif
							@endforeach

							@if($iso_code == Session::get('locale') && $app->pivot->carrier_id == Session::get('carrier'))									
								@foreach($game->media as $media)
									@if($media->type == 'icons')
										<div class="swiper-slide item">
											<input type="hidden" class="game-id" value="{{ $game->id }}">
											<div class="thumb relative">
												@if ($app->pivot->price == 0)
													<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
												@endif

												<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}" class="thumb-image">{{ HTML::image('assets/games/icons/' . $media->url) }}</a>

												@if ($app->pivot->price == 0)
													<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
												@endif
										
												@if($dc = GameDiscount::checkDiscountedGames($game->id, $discounted_games) != 0)
													<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-discounted-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
												@endif

												@if($dc = GameDiscount::checkDiscountedGames($game->id, $discounted_games) != 0)
													<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
												@endif
											</div>
											
											<div class="meta">
												<p class="name">{{{ $game->main_title }}}</p>

												@unless ($app->pivot->price == 0)
												
													<?php $dc = GameDiscount::checkDiscountedGames($game->id, $discounted_games);
														$sale_price = $app->pivot->price * (1 - ($dc/100));
													 ?>
													
													@if($dc != 0)
														
													<p class="price">{{ $app->pivot->currency_code . ' ' . number_format($sale_price, 2) }}</p>	


													@else
														<p class="price">{{ $app->pivot->currency_code . ' ' . number_format($app->pivot->price, 2) }}</p>

													@endif												
													
												@endunless
											</div>
										</div>
									@endif
								@endforeach
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

		var num = {{ $count }};
		var game_id = {{ $game_id }};
		var ids = [];
		var token = $('input[name="_token"]').val();

		var finished=1;
		$(window).scroll(function() {
		// $(document).on("scrollstart",function(){	
			$('.ajax-loader').show();
			
			var load = $('.item').length;

			$('.game-id').each(function() {
				ids.push($(this).val());
			});

			// alert(load);

			// if (load / 6 > num) {
			// 	$('.ajax-loader').hide();
			// } else {
			if ($(window).scrollTop() >= parseInt($(document).height() - $(window).height() - 150)) {   
				 if (finished == 1) {
              		finished = 0;   

					$.ajax({
						// url: "{{ url() }}/games/related/more",
						url: "{{ URL::route('games.related.more', array('id' => $game_id)) }}",
						type: "POST",
						data: {
							load: load,
							ids: ids,
							_token: token
						},
						success: function(data) {
							$('#scroll').append(data);
							$('.ajax-loader').hide();
							finished = 1;
						}
					}); // End of ajax call
				} // End of inner condition
			 } // End of first condition
		});
	</script>
@stop
