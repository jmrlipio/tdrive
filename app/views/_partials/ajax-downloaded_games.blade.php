@foreach ($games as $game)
	@foreach ($game->apps as $app)
			@if(Language::getLangID(Session::get('locale')) == $app->pivot->language_id && $app->pivot->carrier_id == Session::get('carrier') )
				<div class="item">
					<div class="image">
						<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}">

							{{ HTML::image('assets/games/icons/' . Media::getGameIcon($game->id), $game->main_title ) }}
						</a>
					</div>																		
					<div class="meta">
						<p>{{{ $app->pivot->title }}}</p>									
					</div>									
				</div>			
			@endif
	@endforeach
@endforeach
