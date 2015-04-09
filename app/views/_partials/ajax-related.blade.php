@foreach($related_games as $game)
						@foreach($game->apps as $app)
							<?php $iso_code = ''; ?>
							@foreach($languages as $language)
								@if($language->id == $app->pivot->language_id)
									<?php $iso_code = strtolower($language->iso_code); ?>
								@endif
							@endforeach

							@if($iso_code == Session::get('locale') && $app->pivot->carrier_id == Session::get('carrier'))													
								@foreach($game->media as $media)
									@if($media->type == 'icons')
										<div class="swiper-slide item">
											<input type="hidden" class="game-id" value="{{ $game->id }}">
											<div class="thumb relative">
												@if ($app->pivot->price == 0)
													<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
												@endif

												<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}" class="thumb-image">{{ HTML::image('assets/games/icons/' . $media->url) }}</a>

												@if ($app->pivot->price == 0)
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
												<p class="name">{{{ $game->main_title }}}</p>

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
							@endif						
						@endforeach
					@endforeach
