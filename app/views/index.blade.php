@extends('_layouts/default')

@section('stylesheets')
	{{ HTML::style("css/lightSlider.css"); }}
	{{ HTML::style("css/slick.css"); }}
	{{ HTML::style("css/jquery-ui.css"); }}
@stop

@section('content')

	<div class="container">
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

								<div class="go">
									<div class="vhparent"><a href="{{ route('game.show', $game->id) }}" class="vhcenter hide-text">Go</a></div>
								</div>
							</div>
						</li>
					@endif

				@endforeach
			@endforeach

		</ul><!-- end #slider -->
	</div>

	<div id="latest-games" class="container">
		<h1 class="title">New and updated games</h1>

		<div class="items">

			@foreach($games as $game)
				
				<div class="item">
					<div class="thumb">
						<a href="{{ 'game/'. $game->id }}"><img src="images/games/thumb-{{ $game->slug }}.jpg" alt="{{ $game->main_title }}"></a>
					</div>

					<div class="meta">
						<p class="name">{{{ $game->main_title }}}</p>
						<p class="price">P{{{ $game->default_price }}}.00</p>
					</div>

					<div class="button center"><a href="#">Buy</a></div>
				</div>

			@endforeach

		</div>

		<div class="more"><a href="{{ route('games.all') }}">More +</a></div>
	</div><!-- end #latest-games -->

	<div id="games-heading" class="container">
		<h1 class="title">Games</h1>
	</div>

	<div id="memory-games" class="game-category container">
		<div class="clearfix">
			<h2 class="title fl">Brain and Puzzle</h2>
			<div class="more fr"><a href="{{ route('category.show', 1) }}">See all</a></div>
		</div>

		<div class="items">

			@foreach($games as $game)
				@foreach($game->categories as $category)

					@if($category->id == 1)
					
						<div class="item">
							<div class="thumb">
								<a href="{{ 'game/'. $game->id }}"><img src="images/games/thumb-{{ $game->slug }}.jpg" alt="{{ $game->main_title }}"></a>
							</div>

							<div class="meta">
								<p class="name">{{{ $game->main_title }}}</p>
								<p class="price">P{{{ $game->default_price }}}.00</p>
							</div>

							<div class="button center"><a href="#">Buy</a></div>
						</div>

					@endif

				@endforeach
			@endforeach

		</div>
	</div><!-- end #memory-games -->

	<div id="casual-games" class="game-category container">
		<div class="clearfix">
			<h2 class="title fl">Casual</h2>
			<div class="more fr"><a href="{{ route('category.show', 2) }}">See all</a></div>
		</div>

		<div class="items">

			@foreach($games as $game)
				@foreach($game->categories as $category)

					@if($category->id == 2)
					
						<div class="item">
							<div class="thumb">
								<a href="{{ 'game/'. $game->id }}"><img src="images/games/thumb-{{ $game->slug }}.jpg" alt="{{ $game->main_title }}"></a>
							</div>

							<div class="meta">
								<p class="name">{{{ $game->main_title }}}</p>
								<p class="price">P{{{ $game->default_price }}}.00</p>
							</div>

							<div class="button center"><a href="#">Buy</a></div>
						</div>

					@endif

				@endforeach
			@endforeach

		</div>
	</div><!-- end #casual-games -->

	<div id="arcade-games" class="game-category container">
		<div class="clearfix">
			<h2 class="title fl">Arcade</h2>
			<div class="more fr"><a href="{{ route('category.show', 3) }}">See all</a></div>
		</div>

		<div class="items">

			@foreach($games as $game)
				@foreach($game->categories as $category)

					@if($category->id == 3)
					
						<div class="item">
							<div class="thumb">
								<a href="{{ 'game/'. $game->id }}"><img src="images/games/thumb-{{ $game->slug }}.jpg" alt="{{ $game->main_title }}"></a>
							</div>

							<div class="meta">
								<p class="name">{{{ $game->main_title }}}</p>
								<p class="price">P{{{ $game->default_price }}}.00</p>
							</div>

							<div class="button center"><a href="#">Buy</a></div>
						</div>

					@endif

				@endforeach
			@endforeach

		</div>
	</div><!-- end #arcade-games -->

	<div id="card-games" class="game-category container">
		<div class="clearfix">
			<h2 class="title fl">Cards and Casino</h2>
			<div class="more fr"><a href="{{ route('category.show', 4) }}">See all</a></div>
		</div>

		<div class="items">

			@foreach($games as $game)
				@foreach($game->categories as $category)

					@if($category->id == 4)
					
						<div class="item">
							<div class="thumb">
								<a href="{{ 'game/'. $game->id }}"><img src="images/games/thumb-{{ $game->slug }}.jpg" alt="{{ $game->main_title }}"></a>
							</div>

							<div class="meta">
								<p class="name">{{{ $game->main_title }}}</p>
								<p class="price">P{{{ $game->default_price }}}.00</p>
							</div>

							<div class="button center"><a href="#">Buy</a></div>
						</div>

					@endif

				@endforeach
			@endforeach

		</div>
	</div><!-- end #card-games -->

	<div id="classic-games" class="game-category container">
		<div class="clearfix">
			<h2 class="title fl">Classic</h2>
			<div class="more fr"><a href="{{ route('category.show', 5) }}">See all</a></div>
		</div>

		<div class="items">

			@foreach($games as $game)
				@foreach($game->categories as $category)

					@if($category->id == 5)
					
						<div class="item">
							<div class="thumb">
								<a href="{{ 'game/'. $game->id }}"><img src="images/games/thumb-{{ $game->slug }}.jpg" alt="{{ $game->main_title }}"></a>
							</div>

							<div class="meta">
								<p class="name">{{{ $game->main_title }}}</p>
								<p class="price">P{{{ $game->default_price }}}.00</p>
							</div>

							<div class="button center"><a href="#">Buy</a></div>
						</div>

					@endif

				@endforeach
			@endforeach

		</div>
	</div><!-- end #classic-games -->

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
						<div>
							<a href="{{ 'news/'. $item->id }}" class="vhcenter"><i class="fa fa-angle-right"></i></a>
						</div>
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

		<form action="#" method="post">
			<div class="control clearfix">
				<label for="name">Name</label>
				<input type="text" name="name" id="name">
			</div>

			<div class="control clearfix">
				<label for="email">Email</label>
				<input type="email" name="email" id="email">
			</div>

			<div class="control clearfix">
				<label for="game">Game Title</label>
				<input type="text" name="game" id="game">
			</div>

			<div class="control clearfix">
				<label for="message">Message</label>
				<textarea name="message" id="message"></textarea>
			</div>

			<div class="control clearfix">
				<input type="submit" value="Submit &raquo;">
			</div>
		</form>
	</div><!-- end #contact -->

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/jquery.lightSlider.min.js"); }}
	{{ HTML::script("js/jquery-ui.min.js"); }}
	{{ HTML::script("js/slick.min.js"); }}

	<script>
		FastClick.attach(document.body);

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

		$('.items').slick({
			infinite: false,
			//slidesToScroll: 1,
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
		});

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
