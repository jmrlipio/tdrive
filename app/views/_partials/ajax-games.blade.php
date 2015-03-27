@foreach ($games as $game)
	@foreach ($game->media as $media)

		@if($media->type == 'icons')

			<div class="item">
				<div class="thumb relative">
					@if ($game->default_price == 0)
						<a href="{{ URL::route('game.show', array('id' => $game->id, 'slug' => $game->slug, 'carrier' => strtolower($game->carrier->carrier), 'language' => Session::get('locale'))) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
					@endif
					
					<a href="{{ URL::route('game.show', array('id' => $game->id, 'slug' => $game->slug, 'carrier' => strtolower($game->carrier->carrier), 'language' => Session::get('locale'))) }}" class="thumb-image">{{ HTML::image('assets/games/icons/' . $media->url) }}</a>

					@if ($game->default_price == 0)
						<a href="{{ URL::route('game.show', array('id' => $game->id, 'slug' => $game->slug, 'carrier' => strtolower($game->carrier->carrier), 'language' => Session::get('locale'))) }}">{{ HTML::image('images/ribbon-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
					@endif

					@if($dc = GameDiscount::checkDiscountedGames($game->id, $discounted_games) != 0)
						<a href="{{ URL::route('game.show', array('id' => $game->id, 'slug' => $game->slug, 'carrier' => strtolower($game->carrier->carrier), 'language' => Session::get('locale')))}}">{{ HTML::image('images/ribbon-discounted-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
					@endif

					@if($dc = GameDiscount::checkDiscountedGames($game->id, $discounted_games) != 0)
						<a href="{{ URL::route('game.show', array('id' => $game->id, 'slug' => $game->slug, 'carrier' => strtolower($game->carrier->carrier), 'language' => Session::get('locale'))) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
					@endif

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
