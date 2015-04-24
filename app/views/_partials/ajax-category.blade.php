@foreach ($games as $game)
	@foreach ($game->apps as $app)
			@if(Language::getLangID(Session::get('locale')) == $app->pivot->language_id && $app->pivot->carrier_id == Session::get('carrier') )
				<div class="item">
					<div class="thumb relative">
						<a href="{{ URL::route('game.show', array('id' => $app->pivot->game_id, $app->pivot->app_id)) }}" class="thumb-image"><img src="{{ URL::to('/') }}/assets/games/icons/{{ Media::getGameIcon($game->id) }}" alt="{{ $game->main_title }}"></a>
						<?php $discounted_price = Discount::checkDiscountedGame($app->pivot->game_id); ?>
						@if($discounted_price && $app->pivot->price != 0)
							<a href="{{ URL::route('game.show', array('id' => $app->pivot->game_id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-discounted-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
							<a href="{{ URL::route('game.show', array('id' => $app->pivot->game_id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
						@elseif( $app->pivot->price == 0 )
							<a href="{{ URL::route('game.show', array('id' => $app->pivot->game_id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
							<a href="{{ URL::route('game.show', array('id' => $app->pivot->game_id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
						@endif
					</div>

					<div class="meta">
						<p class="name">{{{  $app->pivot->title }}}</p>
						
						@if($discounted_price && $app->pivot->price != 0)
							<?php $sale_price = ($app->pivot->price) - (($discounted_price / 100) * $app->pivot->price)  ?>
							<p class="price-original">{{ $app->pivot->currency_code . ' ' . number_format($app->pivot->price, 2) }}</p>
							<p class="price price">{{ $app->pivot->currency_code . ' ' . number_format($sale_price, 2) }}</p>	
						@else
							<p class="price">{{ $app->pivot->currency_code . ' ' . number_format($app->pivot->price, 2) }}</p>
						@endif
					</div>
				</div>
			@endif
	@endforeach
@endforeach
