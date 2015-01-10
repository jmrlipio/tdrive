@foreach ($games as $game)

	<div class="item">
		<div class="thumb relative">
			@if ($game->default_price == 0)
				<a href="{{ URL::route('game.show', $game->id) }}">{{ HTML::image('images/ribbon.png', 'Free', array('class' => 'free auto')) }}</a>
			@endif

			{{ HTML::image('images/games/thumb-' . $game->slug . '.jpg', $game->main_title) }}
		</div>

		<div class="meta">
			<p>{{ $game->main_title }}</p>

			@unless ($game->default_price == 0)
				@foreach($game->prices as $price) 
					@if($country->id == $price->pivot->country_id)
						<p class="price">{{ $country->currency_code . ' ' . number_format($price->pivot->price, 2) }}</p>
					@endif
				@endforeach
			@endunless
		</div>

		@if ($game->default_price == 0)
			<div class="button center"><a href="#">Get</a></div>
		@else
			<div class="button center"><a href="#">Buy</a></div>
		@endif
	</div>

@endforeach
