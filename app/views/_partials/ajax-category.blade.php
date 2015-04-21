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
					
					
						@if($dc = GameDiscount::checkDiscountedGames($game->id, $discounted_games) != 0)
							<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-discounted-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
						@endif

						@if($dc = GameDiscount::checkDiscountedGames($game->id, $discounted_games) != 0)
							<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
						@endif
					
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
@endforeach
