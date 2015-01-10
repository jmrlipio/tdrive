@extends('_layouts/default')

@section('stylesheets')
	{{ HTML::style("css/lightSlider.css"); }}
	{{ HTML::style("css/jquery-ui.css"); }}
	{{ HTML::style("css/idangerous.swiper.css"); }}
@stop

@section('content')

	<div class="slider-container container">
		<ul id="slider" class="content-slider">

			@foreach($games as $game)
				@foreach($game->contents as $content)

					@if($game->featured == 1)
						<li class="slider-item">
							<img src="images/slider/{{ $game->slug }}.jpg" alt="{{ $game->main_title }}">

							<div class="details clearfix">
								<div class="date">
									<div class="vhparent"><p class="vhcenter">{{ Carbon::parse($game->release_date)->format('M j') }}</p></div>
								</div>

								<div class="description">
									<div class="vparent"><p class="vcenter">{{ $content->pivot->excerpt }}</p></div>
								</div>

								<a href="{{ route('game.show', $game->id) }}" class="go">
									<div class="vhparent"><p class="vhcenter hide-text">Go</p></div>
								</a>
							</div>
						</li>
					@endif

				@endforeach
			@endforeach

		</ul><!-- end #slider -->
	</div>

	<div id="latest-games" class="container">
		<h1 class="title">New and updated games</h1>

		<div class="swiper-container thumbs-container">
			<div class="swiper-wrapper">

				@foreach($games as $game)

					<div class="swiper-slide item">
						<div class="thumb relative">
							@if ($game->default_price == 0)
								{{ HTML::image('images/ribbon.png', 'Free', array('class' => 'free auto')) }}
							@endif

							<a href="{{ URL::route('game.show', $game->id) }}"><img src="images/games/thumb-{{ $game->slug }}.jpg" alt=""></a>
						</div>

						<div class="meta">
							<p class="name">{{{ $game->main_title }}}</p>

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

			</div>
		</div>

		<div class="more"><a href="{{ route('games.all') }}">More +</a></div>
	</div><!-- end #latest-games -->

	<div id="games-heading" class="container">
		<h1 class="title">Games</h1>
	</div>

	@foreach($categories as $cat)

		<div class="game-category container">
			<div class="clearfix">
				<h2 class="title fl">{{ $cat->category }}</h2>
				<div class="more fr"><a href="{{ route('category.show', $cat->id) }}">See all</a></div>
			</div>

			<div class="swiper-container thumbs-container">
				<div class="swiper-wrapper">

						@foreach($games as $game)
							@foreach($game->categories as $gcat)

								@if($gcat->id == $cat->id)
			
									<div class="swiper-slide item">
										<div class="thumb relative">
											@if ($game->default_price == 0)
												{{ HTML::image('images/ribbon.png', 'Free', array('class' => 'free auto')) }}
											@endif

											<a href="{{ URL::route('game.show', $game->id) }}"><img src="images/games/thumb-{{ $game->slug }}.jpg" alt=""></a>
										</div>

										<div class="meta">
											<p class="name">{{{ $game->main_title }}}</p>

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

								@endif

							@endforeach
						@endforeach

				</div>
			</div>
		</div>

	@endforeach

	<div id="news" class="container">
		<div class="clearfix">
			<h1 class="title">Latest news</h1>

			<form action="#" id="year" method="post">

				<div id="token">{{ Form::token() }}</div>

				<select name="year">
					<option value="">select year</option>
					<option value="2015">2015</option>
				</select>
			</form>
		</div>

		<div class="top clearfix">

			@foreach($latest_news as $item)
				@foreach($item->contents as $content)

				<div>
					<div class="date">
						<div class="vhparent">
							<p class="vhcenter">{{ Carbon::parse($item->release_date)->format('M j') }}</p>
						</div>
					</div>

					<img src="images/news/{{ $item->slug }}.jpg" alt="{{ $item->main_title }}">

					<div class="details">
						<h3>{{ $item->main_title }}</h3>
						<p>{{{ $content->pivot->excerpt }}}</p>
					</div>	

					<div class="readmore clearfix"><a href="{{ 'news/'. $item->id }}">Read more <i class="fa fa-angle-right"></i></a></div>
				</div>

				@endforeach
			@endforeach

		</div>

		<div class="bottom">

			@foreach($previous_news as $item)
				@foreach($item->contents as $content)

				<div>
					<div class="date">
						<div class="vhparent">
							<p class="vhcenter">{{ Carbon::parse($item->release_date)->format('M j') }}</p>
						</div>	
					</div>	

					<div class="details">
						<div class="vparent">
							<div class="vcenter">
								<h3>{{{ $item->main_title }}}</h3>
								<p>{{{ $content->pivot->excerpt }}}</p>
							</div>	
						</div>
					</div>	

					<div class="readmore">
						<a href="{{ 'news/'. $item->id }}">
							<div class="vhcenter"><i class="fa fa-angle-right"></i></div>
						</a>
					</div>
				</div>

				@endforeach
			@endforeach

		</div>

		<div class="more"><a href="{{ route('news.all') }}">More +</a></div>
	</div><!-- end #news -->

	<div id="faqs" class="container">
		<h1 class="title">FAQs</h1>

		<p>Find answers to Frequently Asked Questions about TDrive and our services below.</p>

		<div id="questions">

			@foreach($faqs as $faq)

				<h3>{{{ $faq->question }}}</h3>
				<div><p>{{{ $faq->answer }}}</p></div>

			@endforeach

		</div>
	</div><!-- end #faqs -->

	<div id="contact" class="container">
		<h1 class="title">Contact us</h1>
		<p>Your comments and suggestions are important to us. You can reach us via the contact points below.</p>

		{{ Form::open(array(URL::to(Request::segment(1)))) }}

			<div class="control clearfix">
				<label class="common" for="name">Name</label>
				<input type="text" name="name" id="name">
			</div>

			<div class="control clearfix">
				<label class="common" for="email">Email</label>
				<input type="email" name="email" id="email">
			</div>

			<div class="select clearfix">
				<label for="game">Game Title</label>

				<select name="game" class="clearfix" id="game">
					<option value="">General Inquiry</option>

					@foreach($games as $game)
						<option value="{{ $game->main_title }}">{{ $game->main_title }}</option>
					@endforeach

				</select>
			</div>

			<div class="captcha control clearfix">
				{{ HTML::image(Captcha::img(), 'Captcha image') }}
				{{ Form::text('captcha', null, array('placeholder' => 'Type what you see...')) }}

				<?php if (Request::getMethod() == 'POST') {
					$rules =  array('captcha' => array('required', 'captcha'));
					$validator = Validator::make(Input::all(), $rules);

					if ($validator->fails()) {
						echo '<p class="captcha-error"><i class="fa fa-close"></i> Incorrect</p>';
					} else {
						echo '<p class="captcha-correct"><i class="fa fa-check"></i> Matched</p>';
					}
				} ?>
			</div>

			<div class="control clearfix">
				<label class="common" for="message">Message</label>
				<textarea name="message" id="message"></textarea>
			</div>

			<div class="control clearfix">
				<input type="submit" value="Submit &raquo;">
			</div>

		{{ Form::close(); }}

	</div><!-- end #contact -->

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/jquery.lightSlider.min.js"); }}
	{{ HTML::script("js/idangerous.swiper.min.js"); }}
	{{ HTML::script("js/jquery-ui.min.js"); }}

	<script>
		FastClick.attach(document.body);

		/*$('.menu a').click(function() {
			$('body, html').animate({ scrollTop: $($(this).attr('href')).offset().top - $('#header').height() + 2 }, 1000);
		});*/

		$("#slider").lightSlider({
			auto: true,
			pause: 6000,
			loop: true,
			item: 1,
			adaptiveHeight: true,
			slideMargin: 0,
			controls: false,
			pager: false
		});

		$('.thumbs-container').each(function() {
			$(this).swiper({
				slidesPerView: 'auto',
				offsetPxBefore: 0,
				offsetPxAfter: 10,
				calculateHeight: true
			})
		})

		$("#questions").accordion({ 
			heightStyle: 'panel', 
			active: 'none' 
		});

		$('#year').change(function() {
			var year = $(this).find('select').val();

			$(this).attr('action', 'news/year/' + year);
			$(this).submit();
		});

	</script>
@stop
