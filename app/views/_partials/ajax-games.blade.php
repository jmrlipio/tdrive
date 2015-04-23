@foreach ($games as $game)
	@foreach ($game->apps as $app)
			@if(Language::getLangID(Session::get('locale')) == $app->pivot->language_id && $app->pivot->carrier_id == Session::get('carrier') )
			<div class="item">
				<div class="thumb relative">
					@if ($game->default_price == 0)
						<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
					@endif
					
					<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}" class="thumb-image">{{ HTML::image('assets/games/icons/' . Media::getGameIcon($game->id) ) }}</a>

					@if ($game->default_price == 0)
						<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
					@endif
					
					@if($discounts)
						@foreach($discounts as $discount)
							@if($discount['game_id'] == $game->id)
								<a href="{{ URL::route('game.show', array('id' => $game->id, $game['app_id'])) }}">{{ HTML::image('images/ribbon-discounted-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
								<a href="{{ URL::route('game.show', array('id' => $game->id, $game['app_id'])) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
							<?php break; ?>
							@endif
						@endforeach
					@endif
				</div>

				<div class="meta">
					<p>{{ $game->main_title }}</p>
						@if($discounts)
							<?php $sale_price = ($game['price']) - (($discount['discount'] / 100) * $game['price'])  ?>
							@foreach($discounts as $discount)
								@if($discount['game_id'] == $game->id)
									<p class="price-original">{{ $game['currency_code'] . ' ' . number_format($sale_price, 2) }}</p>	
									<p class="price">{{ $game['currency_code'] . ' ' . number_format($game['price'], 2) }}</p>
									<?php break; ?>
								@else
									<p class="price">{{ $game['currency_code'] . ' ' . number_format($game['price'], 2) }}</p>
									<?php break; ?>
								@endif												
							@endforeach
						@endif
				</div>
			</div>
			@endif
	@endforeach
@endforeach
