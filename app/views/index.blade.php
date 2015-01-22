@extends('_layouts/default')

@section('stylesheets')
	{{ HTML::style("css/bootstrap.min.css"); }}
	{{ HTML::style("css/lightSlider.css"); }}
	{{ HTML::style("css/jquery.fancybox.css"); }}
	{{ HTML::style("css/jquery-ui.css"); }}
	{{ HTML::style("css/idangerous.swiper.css"); }}

	<style>

		div#image-container {
			width: 100%;
		}

		div#image-container img{
			width: 100%;
			height: 205px;
		}

		div.modal-content {
			top:60px;
		}

		.modal-title {
			margin: 20px 0;
		}

		div#btn-link {
			background: #e9548e;
			width: 20%;
			text-align: center;
			margin: 0 auto;
			padding: 3px;
			margin-top:10px;
		}
		div#btn-link a {
			color: #fff;
			display: block;
		}

	</style>

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
										<a href="{{ URL::route('game.show', $game->id) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
									@endif

									<a href="{{ URL::route('game.show', $game->id) }}" class="thumb-image"><img src="assets/games/icons/{{ $media->url }}"></a>

									@if ($game->default_price == 0)
										<a href="{{ URL::route('game.show', $game->id) }}">{{ HTML::image('images/ribbon-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
									@endif
								</div>
								<div class="meta">
									<p class="name">{{{ $game->main_title }}}</p>

									@unless ($game->default_price == 0)
										@foreach($game->prices as $price) 
											@if(Session::get('country_id') == $price->pivot->country_id && Session::get('carrier') == $price->pivot->carrier_id)
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
							
							@foreach($game->media as $media)

								@if($media->type == 'icons')

									@if($gcat->id == $cat->id)
				
										<div class="swiper-slide item">
											<div class="thumb relative">
												@if ($game->default_price == 0)
													<a href="{{ URL::route('game.show', $game->id) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
												@endif

												<a href="{{ URL::route('game.show', $game->id) }}" class="thumb-image"><img src="assets/games/icons/{{ $media->url }}"></a>

												@if ($game->default_price == 0)
													<a href="{{ URL::route('game.show', $game->id) }}">{{ HTML::image('images/ribbon-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
												@endif
											</div>

											<div class="meta">
												<p class="name">{{{ $game->main_title }}}</p>

												@unless ($game->default_price == 0)
													@foreach($game->prices as $price) 
														@if(Session::get('country_id') == $price->pivot->country_id && Session::get('carrier') == $price->pivot->carrier_id)
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
		

@if($first_visit)

<?php $ctr = 0; ?>

	@if(count($discounts) != 0)		

		@foreach($discounts as $data)
		<!-- Modal -->
		<?php $ctr++; ?>
			<div class="modal fade" id="myModal{{ $ctr }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					
					<div class="modal-content">	

						<div class="modal-header">
						        <a title="Close" class="fancybox-item fancybox-close" data-dismiss="modal" aria-label="Close"></a>
					        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>		 -->			      
					    </div>				
					  
						<div class="modal-body">
						  	
						  	<div id="image-container">
						  		
						  		{{ HTML::image("assets/discounts/$data->featured_image", null, array('class' => 'auto', 'id' => 'discount-img')) }}
						  
						  	</div>
						  	
						  	<div class="clearfix"></div>

						  	<h2 class="modal-title center" id="myModalLabel">{{{ ucfirst($data->title) }}}</h2>	
						   
						    <p> {{ str_limit($data->description, $limit = 200, $end = '...') }} </p>

						    <div id="btn-link">

								<a href="{{ URL::route('game.show', $data->game_id) }}">View</a>

							</div>						    
						  
						</div>
					 
					</div>

				</div>

			</div>

		@endforeach

		<input type="hidden" id="ctr" value="{{ $ctr }}">

	@endif

<?php $ctr2 = 0; ?>

	@if(count($news_alert) != 0)		

		@foreach($news_alert as $data)
		<!-- Modal -->
		<?php $ctr2++; ?>
			<div class="modal fade" id="newsAlert{{ $ctr2 }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					
					<div class="modal-content">

						<div class="modal-header">
					        <a title="Close" class="fancybox-item fancybox-close" data-dismiss="modal" aria-label="Close"></a>
					       					      
					    </div>
									  
						<div class="modal-body">

						  	<div id="image-container">
						  		
						  		{{ HTML::image("assets/news/$data->featured_image", null, array('class' => 'auto', 'id' => 'discount-img')) }}
						  	
						  	</div>
						  	
						  	<div class="clearfix"></div>

						  	<h2 class="modal-title center" id="myModalLabel">{{{ ucfirst($data->main_title) }}}</h2>	
							
							@foreach($data->contents as $row)

						  		<p> {{{ str_limit($row->pivot->content, $limit = 200, $end = '...') }}} </p>	
						  						    
						    @endforeach	
							
							<div id="btn-link">

								<a href="{{ 'news/'. $data->id }}">View</a>

							</div>
						   		  										
						</div>
					 
					</div>

				</div>

			</div>

		@endforeach

		<input type="hidden" id="ctr2" value="{{ $ctr2 }}">

	@endif

@endif

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js") }}
	{{ HTML::script("js/bootstrap.min.js") }}
	{{ HTML::script("js/jquery.lightSlider.min.js") }}
	{{ HTML::script("js/jquery.fancybox.js") }}
	{{ HTML::script("js/idangerous.swiper.min.js") }}
	{{ HTML::script("js/jquery-ui.min.js") }}
	{{ HTML::script("js/jquery.ddslick.min.js") }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js") }}

	<script>
		FastClick.attach(document.body);

		var ctr = $('#ctr').val();
		var ctr2 = $('#ctr2').val();

		$(window).load(function(){
			
			for(var i=0; i<ctr; i++){
	        	
	        	$('#myModal'+ (i+1)).modal('show');
	        }

	        for(var i=0; i<ctr2; i++){
	        	
	        	$('#newsAlert'+ (i+1)).modal('show');
	        }

	    });

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
