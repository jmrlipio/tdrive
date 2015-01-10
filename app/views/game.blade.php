@extends('_layouts/single')

@section('stylesheets')
	{{ HTML::style("css/slick.css"); }}
	{{ HTML::style("css/jquery.fancybox.css"); }}
	{{ HTML::style("css/idangerous.swiper.css"); }}
@stop

@section('content')

	{{ HTML::image("images/games/{$game->slug}.jpg", $game->main_title, array('id' => 'featured')) }}

	<div id="top" class="clearfix container">
		<div class="thumb">
			{{ HTML::image("images/games/thumb-{$game->slug}.jpg", $game->main_title) }}
		</div>

		<div class="title">
			<h3>{{{ $game->main_title }}}</h3>

			<ul class="categories clearfix">

				@foreach ($game->categories as $item)
					<li><a href="{{ route('category.show', $item->id) }}">{{ $item->category }}</a></li>
				@endforeach

			</ul>

			<p>Release: {{{ $game->release_date }}}</p>
		</div>
	</div><!-- end #top -->

	<div id="buttons" class="container clearfix">
		<div class="downloads">
			<div class="vcenter">
				<p class="count">{{ number_format($game->downloads, 0) }}</p>
				<p class="words"><!--<span>Thousand</span>--> Downloads</p>
			</div>
		</div>

		<div class="ratings">
			<div class="vcenter">
				<p class="count">{{ $ratings['average'] ? $ratings['average'] : 0 }}</p>

				<div class="stars">
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<p class="total">{{ $ratings['count'] ? $ratings['count'] : 0 }} total</p>
			</div>
		</div>

		@if ($game->default_price == 0)
			<a href="#" class="download">
				<div>
					<p class="clearfix">{{ HTML::image('images/download.png', 'Download', array('class' => 'auto')) }}<span>Download</span></p>
				</div>
			</a>
		@else
			<a href="#" class="buy">
				<div>
					<p class="image clearfix">{{ HTML::image('images/buy.png', 'Buy', array('class' => 'auto')) }}<span>Buy Now</span></p>

					@foreach($game->prices as $price) 
						@if($country->id == $price->pivot->country_id)
							<p class="price">{{ $country->currency_code . ' ' . number_format($price->pivot->price, 2) }}</p>
						@endif
					@endforeach
				</div>
			</a>
		@endif
	</div><!-- end #buttons -->

	<div id="description" class="container">

		@foreach($game->contents as $item)
			{{ $item->pivot->content }}
		@endforeach

		<!--<p>Stack as many cats as possible. All kinds of cats will appear. Fat cats, kittens, even cats with top hats!</p>	
		<p>Touch and tilt, but be careful. The tower may fall apart!</p>	
		<p>Mew Mew Tower Premium is a simple and exciting game enjoyed by all ages.</p>	
		<p>Test you skills and luck with friends in 2 player mode! Cute backgrounds are also unlockable wallpapers!</p>	-->
	</div><!-- end #description -->

	<div id="screenshots" class="container">
		<div class="swiper-container thumbs-container">
			<div class="swiper-wrapper">

				@foreach($related_games as $game)
					@foreach($game->categories as $category)

						<div class="swiper-slide item"><a href="{{ url() }}/images/screenshots/mew-mew-tower-sc1.jpg" class="fancybox">{{ HTML::image('images/screenshots/mew-mew-tower-sc1.jpg', 'Mew Mew Tower') }}</a></div>
						<div class="swiper-slide item"><a href="{{ url() }}/images/screenshots/mew-mew-tower-sc2.jpg" class="fancybox">{{ HTML::image('images/screenshots/mew-mew-tower-sc2.jpg', 'Mew Mew Tower') }}</a></div>
						<div class="swiper-slide item"><a href="{{ url() }}/images/screenshots/mew-mew-tower-sc3.jpg" class="fancybox">{{ HTML::image('images/screenshots/mew-mew-tower-sc3.jpg', 'Mew Mew Tower') }}</a></div>
						<div class="swiper-slide item"><a href="{{ url() }}/images/screenshots/mew-mew-tower-sc1.jpg" class="fancybox">{{ HTML::image('images/screenshots/mew-mew-tower-sc1.jpg', 'Mew Mew Tower') }}</a></div>
						<div class="swiper-slide item"><a href="{{ url() }}/images/screenshots/mew-mew-tower-sc2.jpg" class="fancybox">{{ HTML::image('images/screenshots/mew-mew-tower-sc2.jpg', 'Mew Mew Tower') }}</a></div>
						<div class="swiper-slide item"><a href="{{ url() }}/images/screenshots/mew-mew-tower-sc3.jpg" class="fancybox">{{ HTML::image('images/screenshots/mew-mew-tower-sc3.jpg', 'Mew Mew Tower') }}</a></div>

					@endforeach
				@endforeach

			</div>
		</div>
	</div>

	<div id="statistics" class="container">
		<div class="top clearfix">
			<p class="count">{{ $ratings['average'] ? $ratings['average'] : 0 }}</p>

			<div class="stars-container">
				<div class="stars">
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<p class="total">{{ $ratings['count'] ? $ratings['count'] : 0 }} total</p>
			</div>

			<div class="social clearfix">
				<a href="#" class="share">
					{{ HTML::image('images/share.png', 'Share', array('class' => 'auto')) }}
					<span>Share</span>
				</a>

				<a href="#" class="likes">
					{{ HTML::image('images/likes.png', 'Likes', array('class' => 'auto')) }}
					<span>10,000,000 liked this</span>
				</a>
			</div>
		</div>

		<div class="bottom">
			<div class="five clearfix">
				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<div class="meter clearfix">
					<span style="width: {{ ($ratings['count'] != 0) ? ($ratings['five'] / $ratings['count']) * 100 : 0 }}%"></span>

					<p class="total">{{ $ratings['five'] }}</p>
				</div>
			</div>

			<div class="four clearfix">
				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<div class="meter clearfix">
					<span style="width: {{ ($ratings['count'] != 0) ? ($ratings['four'] / $ratings['count']) * 100 : 0 }}%"></span>

					<p class="total">{{ $ratings['four'] }}</p>
				</div>
			</div>

			<div class="three clearfix">
				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<div class="meter clearfix">
					<span style="width: {{ ($ratings['count'] != 0) ? ($ratings['three'] / $ratings['count']) * 100 : 0 }}%"></span>

					<p class="total">{{ $ratings['three'] }}</p>
				</div>
			</div>

			<div class="two clearfix">
				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<div class="meter clearfix">
					<span style="width: {{ ($ratings['count'] != 0) ? ($ratings['two'] / $ratings['count']) * 100 : 0 }}%"></span>

					<p class="total">{{ $ratings['two'] }}</p>
				</div>
			</div>

			<div class="one clearfix">
				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<div class="meter clearfix">
					<span style="width: {{ ($ratings['count'] != 0) ? ($ratings['one'] / $ratings['count']) * 100 : 0 }}%"></span>

					<p class="total">{{ $ratings['one'] }}</p>
				</div>
			</div>
		</div>
	</div><!-- end #statistics -->

	<div id="review" class="container">

		@if (Auth::check())
			@if(Session::has('message'))
				<p class="form-success">{{ Session::get('message') }}</p>
			@endif

			{{ Form::open(array('route'=>'review.post', 'method' => 'post')) }}

				{{ Form::hidden('status', 1) }}
				{{ Form::hidden('game_id', $current_game->id) }}
				{{ Form::hidden('user_id', Auth::id()) }}

				<div class="rating-control clearfix control">
					<label class="rating" for="rating">Rating</label>

					{{ Form::selectRange('rating', 1, 5) }}

					{{ $errors->first('rating', '<p class="form-error">:message</p>') }}
				</div>

				<div class="control">
					<textarea name="review" placeholder="write a review" required></textarea>

					{{ $errors->first('review', '<p class="form-error">:message</p>') }}
				</div>

				<div class="captcha control clearfix">
					{{ HTML::image(Captcha::img(), 'Captcha image') }}
					{{ Form::text('captcha', null, array('placeholder' => 'Type what you see...', 'required' => 'required')) }}

					{{ $errors->first('captcha', '<p class="form-error">:message</p>') }}
				</div>


				<div class="control">
					<input type="submit" value="Submit">
				</div>
			</form>

		@else

			<div class="button">
				<a href="{{ route('users.login') }}">Login to write a review <i class="fa fa-pencil"></i></a>
			</div>

		@endif

	</div><!-- end #review -->

	<div id="reviews" class="container">
		<div class="entry clearfix">
			{{ HTML::image('images/avatars/jaypee-onza.jpg', 'Jaypee Onza') }}
			
			<div>
				<p class="name">Jaypee Onza</p>

				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<p class="date">August 8, 2014</p>

				<p class="message">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
			</div>
		</div>

		<div class="entry clearfix">
			{{ HTML::image('images/avatars/julius-caluminga.jpg', 'Julius Caluminga') }}
			
			<div>
				<p class="name">Julius Caluminga</p>

				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<p class="date">August 8, 2014</p>

				<p class="message">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>

		<div class="entry clearfix">
			{{ HTML::image('images/avatars/michelle-yang.jpg', 'Michelle Yang') }}
			
			<div>
				<p class="name">Michelle Yang</p>

				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<p class="date">August 8, 2014</p>

				<p class="message">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>

		<div class="link center"><a href="{{ route('reviews', $game->id) }}">See all reviews &raquo;</a></div>
	</div><!-- end #reviews -->

	<div id="related-games" class="container">
		<h1 class="title">Related games</h1>

		@if(!empty($related_games))

			<div class="swiper-container thumbs-container">
				<div class="swiper-wrapper">

					@foreach($related_games as $game)

						<div class="swiper-slide item">
							<div class="thumb relative">
								@if ($game->default_price == 0)
									{{ HTML::image('images/ribbon.png', 'Free', array('class' => 'free auto')) }}
								@endif

								<a href="{{ URL::route('game.show', $game->id) }}">{{ HTML::image("images/games/thumb-{$game->slug}.jpg") }}</a>
							</div>

							<div class="meta">
								<p class="name">{{{ $game->main_title }}}</p>

								@unless ($game->default_price == 0)
									<p class="price">P{{{ $game->default_price }}}.00</p>
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

		@else

			<p>No related games.</p>

		@endif

		<div class="more"><a href="{{ route('games.all') }}">More +</a></div>
	</div><!-- end #related-games -->

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/slick.min.js"); }}
	{{ HTML::script("js/jquery.fancybox.js"); }}
	{{ HTML::script("js/idangerous.swiper.min.js"); }}

	<script>
		FastClick.attach(document.body);

		$('.thumbs-container').each(function() {
			$(this).swiper({
				slidesPerView: 'auto',
				offsetPxBefore: 0,
				offsetPxAfter: 10,
				calculateHeight: true
			})
		});



		$('.fancybox').fancybox({ padding: 0 });
	</script>
@stop
