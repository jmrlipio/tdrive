<div class="swiper-slide item">
	<div class="thumb relative">
		<a href="{{ URL::route('game.show', array('id' => $game['id'], $game['app_id'])) }}" class="thumb-image"><img src="assets/games/icons/{{ Media::getGameIcon($game['id']) }}"></a>
		<?php $discounted_price = Discount::checkDiscountedGame($game['id']); ?>
		@if($discounted_price && $game['price'] != 0)
			<a href="{{ URL::route('game.show', array('id' => $game['id'], $game['app_id'])) }}">{{ HTML::image('images/ribbon-discounted-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
			<a href="{{ URL::route('game.show', array('id' => $game['id'], $game['app_id'])) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
		@elseif( $game['price'] == 0 )
			<a href="{{ URL::route('game.show', array('id' => $game['id'], $game['app_id'])) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
			<a href="{{ URL::route('game.show', array('id' => $game['id'], $game['app_id'])) }}">{{ HTML::image('images/ribbon-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
		@endif
	</div>

	<div class="meta">
		<p class="name">{{{ $game['title'] }}}</p>
		
		@if($discounted_price && $game['price'] != 0)
			<?php $sale_price = ($game['price']) - (($discounted_price / 100) * $game['price'])  ?>
			<p class="price-original">{{ $game['currency_code'] . ' ' . number_format($sale_price, 2) }}</p>	
			<p class="price">{{ $game['currency_code'] . ' ' . number_format($game['price'], 2) }}</p>
		@else
			<p class="price">{{ $game['currency_code'] . ' ' . number_format($game['price'], 2) }}</p>
		@endif
	</div>
	<div class="game-button">
		@if ($game['price'] == 0)
			<a href="#" data-id="{{ $game['id'] }}" class="game-free">Free</a>
		@else
			<a href="#" id="buy" data-id="{{ $game['id'] }}" class="game-buy buy">{{ trans('global.Buy') }}</a>	
		@endif
	</div>
</div>