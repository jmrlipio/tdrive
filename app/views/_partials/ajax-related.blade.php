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
					
					<a href="{{ URL::route('game.show', array('id' => $game->id, 'slug' => $game->slug, 'carrier' => strtolower($game->carrier->carrier), 'language' => Session::get('locale'))) }}" class="thumb-image">{{ HTML::image('assets/games/icons/' . $media->url) }}</a>

					@if ($game->default_price == 0)
						<a href="{{ URL::route('game.show', array('id' => $game->id, 'slug' => $game->slug, 'carrier' => strtolower($game->carrier->carrier), 'language' => Session::get('locale'))) }}">{{ HTML::image('images/ribbon-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
					@endif

				</div>

				<div class="meta">
					<p>{{ $game->main_title }}</p>

					@unless ($game->default_price == 0)
						@foreach($game->prices as $price) 
							@if(Session::get('country_id') == $price->pivot->country_id && Session::get('carrier') == $price->pivot->carrier_id)
								<p class="price">{{ $country->currency_code . ' ' . number_format($price->pivot->price, 2) }}</p>
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
