@extends('_layouts/listing')

@section('stylesheets')
@stop

@section('content')
	<div class="container">
		<h1 class="title">{{ trans('global.All Categories') }}</h1>
		<div class="clear"></div>	
		<div id="token">{{ Form::token() }}</div>
		<div class="grid">
			<div class="row">
				<div id="scroll" class="clearfix">

					@foreach ($games as $game)												
						@foreach($game->apps as $app)
							<?php $iso_code = ''; ?>
							@foreach($languages as $language)
								@if($language->id == $app->pivot->language_id)
									<?php $iso_code = strtolower($language->iso_code); ?>
								@endif
							@endforeach
							
							@if($app->pivot->status != Constant::PUBLISH)
								<?php continue; ?>
							@endif	

							@if($iso_code == Session::get('locale') && $app->pivot->carrier_id == Session::get('carrier'))
								
								@foreach ($game->media as $media)
									@if ($media->type == 'icons')
										<div class="item">
											<div class="thumb relative">

												@if ($app->pivot->price == 0)
												<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon.png', 'Free', array('class' => 'free-back auto')) }}</a>
												@endif

												<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}" class="thumb-image"><img src="{{ URL::to('/') }}/assets/games/icons/{{ $media->url }}" alt="{{ $game->main_title }}"></a>

												@if ($app->pivot->price == 0)
												<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
												@endif

												@if($discounts)
													@foreach($discounts as $discount)
														@if($discount['game_id'] == $app->pivot->game_id)
															<a href="{{ URL::route('game.show', array('id' => $app->pivot->game_id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-discounted-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
															<a href="{{ URL::route('game.show', array('id' => $app->pivot->game_id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
														<?php break; ?>
														@endif
													@endforeach
												@endif
											</div>

											<div class="meta">
												<p>{{ $game->main_title }}</p>
													@if($discounts)
														<?php $sale_price = ($app->pivot->price) - (($discount['discount'] / 100) * $app->pivot->price)  ?>
														@foreach($discounts as $discount)
															@if($discount['game_id'] == $app->pivot->game_id)
																<p class="price-original">{{ $app->pivot->currency_code . ' ' . number_format($app->pivot->price, 2) }}</p>
																<p class="price price">{{ $app->pivot->currency_code . ' ' . number_format($sale_price, 2) }}</p>	
																<?php break; ?>
															@else
																<p class="price">{{ $app->pivot->currency_code . ' ' . number_format($app->pivot->price, 2) }}</p>
																<?php break; ?>
															@endif												
														@endforeach
													@endif
											</div>
										</div>
									@endif
								@endforeach
							@endif

						@endforeach
					@endforeach

				</div>
			</div>
		</div>
		<div class="ajax-loader center"><i class="fa fa-cog fa-spin"></i> loading&hellip;</div>
	</div>

@stop
	
@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}
	
	@include('_partials/scripts')
	
	<script>
		FastClick.attach(document.body);

		var load = 0;
		var num = {{ $count }};
		var page = ({{ $page }} / 2);

		$(window).scroll(function() {
			var bottom = 50;
				if ($(window).scrollTop() + $(window).height() > $(document).height() - bottom) 
				{
					$.ajax({
						url: "{{ url() }}/games/all/more",
						type: "POST",
						data: {
							page: page,
							_token: _token
						},
						success: function(data) {
							console.log(data);
							page++;
							$('#scroll').append(data);
							$('.ajax-loader').hide();
						}
					});
				}
			});
	</script>
@stop
