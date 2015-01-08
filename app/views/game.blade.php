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

			<p>Android</p>
			<p>Release: {{{ $game->release_date }}}</p>
		</div>
	</div><!-- end #top -->

	<div id="buttons" class="container clearfix">
		<div class="downloads">
			<div class="vcenter">
				<p class="count">100</p>
				<p class="words"><span>Thousand</span> Downloads</p>
			</div>
		</div>

		<div class="ratings">
			<div class="vcenter">
				<p class="count">4.3</p>

				<div class="stars">
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<p class="total">453,962 Total</p>
			</div>
		</div>

		<a href="#" class="buy">
			<div>
				<p class="image clearfix">{{ HTML::image('images/buy.png', 'Buy', array('class' => 'auto')) }}<span>Buy Now</span></p>
				<p class="price">P{{{ $game->default_price }}}.00</p>
			</div>
		</a>

		<!--<a href="#" class="download">
			<div>
				<p class="clearfix">{{ HTML::image('images/download.png', 'Download', array('class' => 'auto')) }}<span>Download</span></p>
			</div>
		</a>-->
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
			<p class="count">4.3</p>

			<div class="stars-container">
				<div class="stars">
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star active"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<p class="total">5,649,796 Total</p>
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
					<span></span>
					<p class="total">3,677,764</p>
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
					<span></span>
					<p class="total">1,009,887</p>
				</div>
			</div>

			<div class="three clearfix">
				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<div class="meter clearfix">
					<span></span>
					<p class="total">443,260</p>
				</div>
			</div>

			<div class="two clearfix">
				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<div class="meter clearfix">
					<span></span>
					<p class="total">189,961</p>
				</div>
			</div>

			<div class="one clearfix">
				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<div class="meter clearfix">
					<span></span>
					<p class="total">328,887</p>
				</div>
			</div>
		</div>
	</div><!-- end #statistics -->

	<div id="review" class="container">

		@if (Auth::check())
			<form action="#" method="post">
				<div class="control">
					<input type="text" name="username" placeholder="username">
				</div>

				<div class="control">
					<input type="text" name="subject" placeholder="subject">
				</div>

				<div class="control">
					<textarea name="message" placeholder="message"></textarea>
				</div>

				<div class="control">
					<input type="submit" value="Submit">
				</div>
			</form>
		@else
			<div class="button">
				<a href="#">Login to write a review <i class="fa fa-pencil"></i></a>
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

		<div class="swiper-container thumbs-container">
			<div class="swiper-wrapper">

				@foreach($related_games as $game)
					@foreach($game->categories as $category)

						<div class="swiper-slide item">
							<div class="thumb">
								<a href="{{ URL::route('game.show', $game->id) }}">{{ HTML::image("images/games/thumb-{$game->slug}.jpg") }}</a>
							</div>

							<div class="meta">
								<p class="name">{{{ $game->main_title }}}</p>
								<p class="price">P{{{ $game->default_price }}}.00</p>
							</div>

							<div class="button center"><a href="#">Buy</a></div>
						</div>

					@endforeach
				@endforeach

			</div>
		</div>

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

		/*$('#screenshots .items').slick({
			infinite: true,
			slidesToScroll: 1,
			centerMode: true,
			centerPadding: 20,
			lazyLoad: 'progressive',
			arrows: false,

			responsive: [
				{
					breakpoint: 1025,
					settings: {
						slidesToShow: 5
					}
				},

				{
					breakpoint: 769,
					settings: {
						slidesToShow: 4,
					}
				},

				{
					breakpoint: 641,
					settings: {
						slidesToShow: 5,
					}
				},

				{
					breakpoint: 601,
					settings: {
						slidesToShow: 2,
					}
				},

				{
					breakpoint: 401,
					settings: {
						slidesToShow: 3,
					}
				},

				{
					breakpoint: 321,
					settings: {
						slidesToShow: 2
					}
				},
			]
		});*/

		/*$('#related-games .items').slick({
			infinite: false,
			swipeToSlide: true,
			//centerMode: true,
			centerPadding: 20,
			lazyLoad: 'progressive',
			arrows: false,

			responsive: [
				{
					breakpoint: 1025,
					settings: {
						slidesToShow: 5
					}
				},

				{
					breakpoint: 769,
					settings: {
						slidesToShow: 4,
					}
				},

				{
					breakpoint: 641,
					settings: {
						slidesToShow: 5,
					}
				},

				{
					breakpoint: 601,
					settings: {
						slidesToShow: 3,
					}
				},

				{
					breakpoint: 321,
					settings: {
						slidesToShow: 2
					}
				},
			]
		});*/

		$('.thumbs-container').each(function() {
			$(this).swiper({
				slidesPerView: 'auto',
				offsetPxBefore: 0,
				offsetPxAfter: 10,
				calculateHeight: true
			})
		})

		$('.fancybox').fancybox({ padding: 0 });
	</script>
@stop
