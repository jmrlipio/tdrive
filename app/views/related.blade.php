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
					
					{{-- {{ '<pre>' }} --}}
					{{-- {{ count($related_games) }} --}}
					{{-- {{ '</pre>' }} --}}
					
					@foreach ($related_games as $game)
						@foreach ($game->media as $media)
							
							@if($media->type == 'icons')
								<div class="item">
									<div class="thumb relative">
										@if ($game->default_price == 0)
											<a href="{{ URL::route('game.show', array('id' => $game->id, 'slug' => $game->slug, 'carrier' => strtolower($game->carrier->carrier), 'language' => Session::get('locale'))) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
										@endif

											<a href="{{ URL::route('game.show', array('id' => $game->id, 'slug' => $game->slug, 'carrier' => strtolower($game->carrier->carrier), 'language' => Session::get('locale'))) }}" class="thumb-image" >{{ HTML::image('assets/games/icons/' . $media->url, $game->main_title) }}</a>

										@if ($game->default_price == 0)
											<a href="{{ URL::route('game.show', array('id' => $game->id, 'slug' => $game->slug, 'carrier' => strtolower($game->carrier->carrier), 'language' => Session::get('locale'))) }}">{{ HTML::image('images/ribbon-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
										@endif

										@if($dc = GameDiscount::checkDiscountedGames($game->id, $discounted_games) != 0)
											<a href="{{ URL::route('game.show', array('id' => $game->id, 'slug' => $game->slug, 'carrier' => strtolower($game->carrier->carrier), 'language' => Session::get('locale'))) }}">{{ HTML::image('images/ribbon-discounted-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
										@endif

										@if($dc = GameDiscount::checkDiscountedGames($game->id, $discounted_games) != 0)
											<a href="{{ URL::route('game.show', array('id' => $game->id, 'slug' => $game->slug, 'carrier' => strtolower($game->carrier->carrier), 'language' => Session::get('locale'))) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
										@endif


							<!-- 	<img src="{{ Request::root() . '/assets/games/icons/'. $media->url }}" alt="{{ $game->main_title }}"> -->

							<!-- If image url can't be located, change the url to -->
							<!--  {{ Request::root() . '/assets/games/icons/'. $media->url }}" alt="{{ $game->main_title }}  -->
									


									</div>

									<div class="meta">
										<p>{{ $game->main_title }}</p>

										
										@unless ($game->default_price == 0)
											@foreach($game->prices as $price) 
											<?php $dc = GameDiscount::checkDiscountedGames($game->id, $discounted_games);
												$sale_price = $price->pivot->price * (1 - ($dc/100));
											 ?>
												@if(Session::get('country_id') == $price->pivot->country_id && Session::get('carrier') == $price->pivot->carrier_id)
													@if($dc != 0)														
														<p class="price">{{ $country->currency_code . ' ' . number_format($sale_price, 2) }}</p>
													@else														 
														<p class="price">{{ $country->currency_code . ' ' . number_format($price->pivot->price, 2) }}</p>
													@endif
												@endif
											@endforeach
										@endunless
									</div>

									@if ($game->default_price == 0)
										<!--<div class="button center"><a href="#">Get</a></div>-->
									@else
										<!--<div class="button center"><a href="#">Buy</a></div>-->
									@endif
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
