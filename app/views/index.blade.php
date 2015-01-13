@extends('_layouts/default')

@section('stylesheets')
	{{ HTML::style("css/lightSlider.css"); }}
	{{ HTML::style("css/jquery-ui.css"); }}
	{{ HTML::style("css/idangerous.swiper.css"); }}
@stop

@section('content')

	<div id="slider" class="swiper-container featured container">
		<div class="swiper-wrapper">

			@foreach($featured_games as $featured_game)
				@foreach($featured_game->media as $media)

				@if ($featured_game->featured == 1)

					@if ($media->type == 'promos')
						<div class="swiper-slide">
							@if(File::exists(public_path() . '/assets/games/promos/'. $media->url))
								<a href="{{ URL::route('game.show', $featured_game->id) }}"><img src="assets/games/promos/{{ $media->url }}" alt="{{ $featured_game->main_title }}"></a>
							@else
								<a href="{{ URL::route('game.show', $featured_game->id) }}"><img src="assets/featured/placeholder.jpg" alt="{{ $featured_game->main_title }}"></a>
							@endif
						</div>
					@endif
				@endif

				@endforeach
			@endforeach

		</div>
	</div>

	<div id="latest-games" class="container">
		<h1 class="title">New and updated games</h1>

		<div class="swiper-container thumbs-container">
			<div class="swiper-wrapper">

				@foreach($games as $game)
					@foreach($game->media as $media)
						@if($media->type == 'icons')

							<div class="swiper-slide item">
								<div class="thumb relative">
									@if ($game->default_price == 0)
										<a href="{{ URL::route('game.show', $game->id) }}">{{ HTML::image('images/ribbon.png', 'Free', array('class' => 'free auto')) }}</a>
									@endif

									<a href="{{ URL::route('game.show', $game->id) }}"><img src="assets/games/icons/{{ $media->url }}"></a>
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
									<!--<div class="button center"><a href="#">Get</a></div>-->
								@else
									<!--<div class="button center"><a href="#">Buy</a></div>-->
								@endif
							</div>

						@endif
					@endforeach
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
							.
							@foreach($game->media as $media)

								@if($media->type == 'icons')

									@if($gcat->id == $cat->id)
				
										<div class="swiper-slide item">
											<div class="thumb relative">
												@if ($game->default_price == 0)
													<a href="{{ URL::route('game.show', $game->id) }}">{{ HTML::image('images/ribbon.png', 'Free', array('class' => 'free auto')) }}</a>
												@endif

												<a href="{{ URL::route('game.show', $game->id) }}"><img src="assets/games/icons/{{ $media->url }}"></a>
											</div>

											<div class="meta">
												<p class="name">{{{ $game->main_title }}}</p>

												@unless ($game->default_price == 0)
													@foreach($game->prices as $price) 
														@if(Session::get('country_id') == $price->pivot->country_id)
															<p class="price">{{ $country->currency_code . ' ' . number_format($price->pivot->price, 2) }}</p>
														@endif
													@endforeach
												@endunless
											</div>

											@if ($game->default_price == 0)
												<!-- <div class="button center"><a href="#">Get</a></div> -->
											@else
												<!-- <div class="button center"><a href="#">Buy</a></div> -->
											@endif
										</div>

									@endif
									
								@endif

							@endforeach
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

				 {{ Form::select('year', array('default' => 'Please select') + $year, 'default', array('class' => 'select-year', 'id' => 'select-year')) }}
			</form>
		</div>

		<div class="top clearfix">

			@foreach($latest_news as $item)
				@foreach($item->contents as $content)

				<div>
					<div class="date">
						<div class="vhparent">
							<p class="vhcenter">{{ Carbon::parse($item->created_at)->format('M j') }}</p>
						</div>
					</div>

					<img src="assets/news/{{ $item->featured_image }}" alt="{{ $item->main_title }}">

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
							<p class="vhcenter">{{ Carbon::parse($item->created_at)->format('M j') }}</p>
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

		{{ Form::open(array('route'=>'admin.reports.inquiries.store', 'method' => 'post')) }}

			@if(Session::has('message'))
				<br>
				<p class="form-success">{{ Session::get('message') }}</p>
			@endif

			<div class="control clearfix">
				<input type="text" name="name" id="name" placeholder="name" required>

				{{ $errors->first('name', '<p class="form-error">:message</p>') }}
			</div>

			<div class="control clearfix">
				<input type="email" name="email" id="email" placeholder="email" required>

				{{ $errors->first('email', '<p class="form-error">:message</p>') }}
			</div>

			<div class="select clearfix">
				<select name="game_title" class="clearfix" id="game" required>
					<option value="General Inquiry">General Inquiry</option>

					@foreach($games as $game)
						<option value="{{ $game->main_title }}">{{ $game->main_title }}</option>
					@endforeach

				</select>

				{{ $errors->first('game_title', '<p class="form-error">:message</p>') }}
			</div>

			<div class="captcha control clearfix">
				{{ HTML::image(Captcha::img(), 'Captcha image') }}
				{{ Form::text('captcha', null, array('placeholder' => 'Type what you see...', 'required' => 'required')) }}

				{{ $errors->first('captcha', '<p class="form-error">:message</p>') }}
			</div>

			<div class="control clearfix">
				<textarea name="message" id="message" placeholder="message" required></textarea>

				{{ $errors->first('message', '<p class="form-error">:message</p>') }}
			</div>

			<div class="control clearfix">
				<input type="submit" value="Submit &raquo;">
			</div>

		{{ Form::close() }}

	</div><!-- end #contact -->

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/jquery.lightSlider.min.js"); }}
	{{ HTML::script("js/idangerous.swiper.min.js"); }}
	{{ HTML::script("js/jquery-ui.min.js"); }}
	{{ HTML::script("js/jquery.ddslick.min.js"); }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}

	<script>
		FastClick.attach(document.body);

		var token = $('#token input').val();

		$('#polyglotLanguageSwitcher1').polyglotLanguageSwitcher1({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',

			onChange: function(evt){

				$.ajax({
					url: "language",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: token
					},
					success: function(data) {
					}
				});

				return true;
			}
		});

		$('#polyglotLanguageSwitcher2').polyglotLanguageSwitcher2({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',

			onChange: function(evt){

				$.ajax({
					url: "language",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: token
					},
					success: function(data) {
					}
				});

				return true;
			}
		});

		$('.featured').swiper({
			slidesPerView: 'auto',
			centeredSlides: true,
			calculateHeight: true,
			initialSlide: 2
		})

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
