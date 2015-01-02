@foreach ($games as $game)

	<div class="item">
		<div class="thumb"><img src="/images/games/thumb-{{ $game->slug }}.jpg" alt="{{ $game->main_title }}"></div>

		<div class="meta">
			<p>{{ $game->main_title }}</p>
			<p>P{{ $game->default_price }}.00</p>
		</div>

		<div class="button"><a href="#">Buy</a></div>
	</div>

@endforeach
