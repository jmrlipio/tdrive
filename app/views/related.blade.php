@extends('_layouts/listing')

@section('stylesheets')
<style>
	
	.discounted { text-decoration: line-through; }

</style>
@stop

@section('content')

	<div class="container">
		<h1 class="title">{{ trans('global.Related games') }}</h1>

		<div id="token">{{ Form::token() }}</div>

		<div class="grid">
			<div class="row">
				<div id="scroll" class="clearfix">
					
					@foreach ($related_games as $game)
						@foreach ($game->media as $media)
							
							@if($media->type == 'icons')
								@foreach($game->apps as $app)
									@if(strtolower($app->language->iso_code) == Session::get('locale') && $app->pivot->carrier_id == Session::get('carrier'))

											<div class="item">
												<div class="thumb relative">
													@if ($game->default_price == 0)
														<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
													@endif

														<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}" class="thumb-image" >{{ HTML::image('assets/games/icons/' . $media->url, $game->main_title) }}</a>

													@if ($game->default_price == 0)
														<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
													@endif

													@if($dc = GameDiscount::checkDiscountedGames($game->id, $discounted_games) != 0)
														<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-discounted-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
													@endif

													@if($dc = GameDiscount::checkDiscountedGames($game->id, $discounted_games) != 0)
														<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
													@endif


										<!-- 	<img src="{{ Request::root() . '/assets/games/icons/'. $media->url }}" alt="{{ $game->main_title }}"> -->

										<!-- If image url can't be located, change the url to -->
										<!--  {{ Request::root() . '/assets/games/icons/'. $media->url }}" alt="{{ $game->main_title }}  -->
												

												</div>

												<div class="meta">
													<p>{{ $game->main_title }}</p>

													
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

	<script>
		FastClick.attach(document.body);

		var _token = $('#token input').val();
		var num = {{ $count }};
		var game_id = {{ $game_id }};

		$('#polyglotLanguageSwitcher1').polyglotLanguageSwitcher1({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',

			onChange: function(evt){

				$.ajax({
					url: "language",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: _token
					},
					success: function(data) {
					}
				});

				return true;
			}
		});

		$('#polyglotLanguageSwitcher2').polyglotLanguageSwitcher2({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',

			onChange: function(evt){

				$.ajax({
					url: "language",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: _token
					},
					success: function(data) {
					}
				});

				return true;
			}
		});

		$(window).scroll(function() {
		// $(document).on("scrollstart",function(){	
			$('.ajax-loader').show();
			
			var load = $('.item').length;

			// alert(load);

			// if (load / 6 > num) {
			// 	$('.ajax-loader').hide();
			// } else {

				$.ajax({
					// url: "{{ url() }}/games/related/more",
					url: "{{ URL::route('games.related.more', array('id' => $game_id)) }}",
					type: "POST",
					data: {
						load: load,
						_token: _token
					},
					success: function(data) {
						$('#scroll').append(data);
						$('.ajax-loader').hide();
					}
				});

			// }
		});
	</script>
@stop
