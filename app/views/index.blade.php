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

		.view-all {
			background: #61ded0;
		}
		
		.discounted { text-decoration: line-through; }

	</style>

@stop

@section('content')
	{{-- Session::get('locale') --}}

	<div id="slider" class="swiper-container featured container swiper-container-horizontal">
		<div class="swiper-wrapper">
			@foreach($sliders as $slider)
				<div class="swiper-slide">
					@if($slider->slideable_type == 'Game')
						@foreach($games_slide as $key => $game)
							@if($key == $slider->slideable_id)
								@if(File::exists(public_path() . '/assets/games/homepage/'. $game['url']))					
									<a href="{{ URL::route('game.show', array('id' => $game['id'], 'slug' => $game['app_id']))}}"><img src="assets/games/homepage/{{ $game['url'] }}" alt="{{$game['title']}}"></a>
								@else
									<a href="{{ URL::route('game.show', array('id' => $game['id'], 'slug' => $game['app_id']))}}"><img src="assets/featured/placeholder.jpg" alt="{{$game['title']}}"></a>
								@endif
							@endif
						@endforeach
					@elseif($slider->slideable_type == 'News') 
						@foreach($news_slide as $key => $nw) 
							@if($key == $slider->slideable_id) 
								<a href="{{ 'news/'. $nw['id'] }}"><img src="assets/news/{{ $nw['image'] }}" alt="{{ $nw['title'] }}"></a>					
							@endif
						@endforeach
						
					@endif
				</div>		
			@endforeach
		</div>
		<div class="swiper-pagination swiper-pagination-clickable"></div>
	</div>
	{{ Form::token() }}
	<div id="latest-games" class="bb container">
		<h1 class="title fleft">{{ trans('global.Games') }}</h1>
		<select name="game-category" id="game-category">
			@foreach($categories as $cat)
				<option value="{{ $cat->slug }}">{{ $cat->category }}</option>
			@endforeach
		</select>
		<div class="clear"></div>
		<div class="swiper-container thumbs-container">
			<?php $count = 0; ?>
			@if($games_slide)
				<div class="swiper-wrapper">
				@foreach($games_slide as $game)
					@if($count >= $limit)
						<?php break; ?>
					@endif
					<?php $count++; ?>
						<div class="swiper-slide item">
							<div class="thumb relative">
								@if ($game['price'] == 0)
									<a href="{{ URL::route('game.show', array('id' => $game['id'], $game['app_id'])) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
								@endif

								<a href="{{ URL::route('game.show', array('id' => $game['id'], $game['app_id'])) }}" class="thumb-image"><img src="assets/games/icons/{{ Media::getGameIcon($game['id']) }}"></a>

								@if ($game['price'] == 0)
									<a href="{{ URL::route('game.show', array('id' => $game['id'], $game['app_id'])) }}">{{ HTML::image('images/ribbon-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
								@endif

								@if($dc = GameDiscount::checkDiscountedGames($game['app_id'], $discounted_games) != 0)
									<a href="{{ URL::route('game.show', array('id' => $game['id'], $game['app_id'])) }}">{{ HTML::image('images/ribbon-discounted-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
								@endif

								@if($dc = GameDiscount::checkDiscountedGames($game['app_id'], $discounted_games) != 0)
									<a href="{{ URL::route('game.show', array('id' => $game['id'], $game['app_id'])) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
								@endif
							</div>

							<div class="meta">
								<p class="name">{{{ $game['title'] }}}</p>
								@unless ($game['price']) == 0)
									<?php 
										$dc = GameDiscount::checkDiscountedGames($game['id'], $discounted_games);
										$sale_price = $game['price'] * (1 - ($dc/100));
									?>
									@if($dc != 0)
										<p class="price">{{ $game['currency_code'] . ' ' . number_format($sale_price, 2) }}</p>	
									@else
										<p class="price">{{ $game['currency_code'] . ' ' . number_format($game['price'], 2) }}</p>
									@endif												
								@endunless
							</div>
							<div class="game-button">
								@if ($game['price'] == 0)
									<a href="#" class="game-free">Free</a>
								@else
									<a href="#" id="buy" class="game-buy buy">Buy</a>	
								@endif
							</div>
						</div>
				@endforeach	
				</div>
			@else
				<div class="container">
					<p class="no-games">no games, please choose another carrier or another language for the selected carrier</p>
				</div>
			@endif		
		</div>

		<div class="more"><a href="{{ route('games.all') }}">{{ trans('global.More') }} +</a></div>
	</div><!-- end #latest-games -->

	{{-- <div id="games-heading" class="container"> --}}
		{{-- <h1 class="title">{{ trans('global.Games') }}</h1> --}}
	{{-- </div> --}}
	@foreach($categories as $cat)
		<?php $apps = Game::getAppsPerCategory($cat->id); ?>
		@if(!$apps)
			<?php continue; ?>
		@endif
		<div class="game-category container">
			<div class="clearfix">
				<h2 class="title fl">{{ trans('global.'.$cat->category) }}</h2>
			</div>

			<div class="swiper-container thumbs-container">
				<div class="swiper-wrapper">
					<?php $count = 0; ?>
					@foreach($apps as $app) 
						<div class="swiper-slide item">
							<div class="thumb relative">
								@if ($app->pivot->price == 0)
									<a href="{{ URL::route('game.show', array('id' => $app->pivot->game_id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
								@endif

								<a href="{{ URL::route('game.show', array('id' => $app->pivot->game_id, $app->pivot->app_id)) }}" class="thumb-image"><img src="assets/games/icons/{{ Media::getGameIcon($app->pivot->game_id) }}"></a>

								@if ($app->pivot->price == 0)
									<a href="{{ URL::route('game.show', array('id' => $app->pivot->game_id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
								@endif

								@if($dc = GameDiscount::checkDiscountedGames($app->pivot->game_id, $discounted_games) != 0)
									<a href="{{ URL::route('game.show', array('id' => $app->pivot->game_id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-discounted-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
								@endif

								@if($dc = GameDiscount::checkDiscountedGames($app->pivot->game_id, $discounted_games) != 0)
									<a href="{{ URL::route('game.show', array('id' => $app->pivot->game_id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
								@endif
							</div>

							<div class="meta">
								<p class="name">{{{ $app->pivot->title }}}</p>
								@unless ($app->pivot->price == 0)
									<?php 
										$dc = GameDiscount::checkDiscountedGames($app->pivot->game_id, $discounted_games);
										$sale_price = $app->pivot->price * (1 - ($dc/100));
									?>
									@if($dc != 0)
										<p class="price">{{ $app->pivot->currency_code . ' ' . number_format($sale_price, 2) }}</p>	
									@else
										<p class="price">{{ $app->pivot->currency_code . ' ' . number_format($app->pivot->price, 2) }}</p>
									@endif												
								@endunless
							</div>
							<div class="game-button">
								@if ($app->pivot->price == 0)
									<a href="#" class="game-free">Free</a>
								@else
									<a href="#" id="buy" class="game-buy buy">Buy</a>	
								@endif
							</div>
						</div>
					@endforeach  
				</div>
				<div class="more fr"><a href="{{ route('category.show', $cat->id) }}">{{ trans('global.More') }}+</a></div>
			</div>
		</div>
	@endforeach

	{{-- <div class="view-all container clearfix"> --}}
		{{-- <div class="more fr"><a href="{{ route('categories.all') }}">{{ trans('global.View all categories') }}</a></div> --}}
	{{-- </div> --}}

	<div id="news" class="container">
		<div class="clearfix">
			<h1 class="title">{{ trans('global.latest news') }}</h1>

			<form action="#" id="year" method="post">

				<div id="token">{{ Form::token() }}</div>

				 {{ Form::select('year', array('default' => trans('global.Please select')) + $year, 'default', array('class' => 'select-year', 'id' => 'select-year')) }}
			</form>
		</div>

		<div class="top clearfix">
			@foreach($latest_news as $item)
				@foreach($item->languages as $content)
					<?php $iso_code = ''; ?>
					@foreach($languages as $language)
						@if($language->id == $content->pivot->language_id)
							<?php $iso_code = strtolower($language->iso_code); ?>
						@endif
					@endforeach

					@if($iso_code == Session::get('locale'))
						<div>
							<div class="date">
								<div class="vhparent">
									<p class="vhcenter">{{ Carbon::parse($item->created_at)->format('M j') }}</p>
								</div>
							</div>

							<img src="assets/news/{{ $item->featured_image }}" alt="{{ $item->main_title }}">

							<div class="details">
								<h3>{{ $content->pivot->title }}</h3>
								<p>{{{ $content->pivot->excerpt }}}</p>
							</div>	

							<div class="readmore clearfix"><a href="{{ 'news/'. $item->id }}">{{ trans('global.Read more') }} <i class="fa fa-angle-right"></i></a></div>
						</div>
					@endif		

				@endforeach
			@endforeach

		</div>
		<div class="bottom">
			@foreach($previous_news as $item)
				@foreach($item->languages as $content)
					<?php $iso_code = ''; ?>
					@foreach($languages as $language)
						@if($language->id == $content->pivot->language_id)
							<?php $iso_code = strtolower($language->iso_code); ?>
						@endif
					@endforeach
					@if($iso_code == Session::get('locale'))
						<div>
							<div class="date">
								<div class="vhparent">
									<p class="vhcenter">{{ Carbon::parse($item->created_at)->format('M j') }}</p>
								</div>	
							</div>	

							<div class="details">
								<div class="vparent">
									<div class="vcenter">
										<h3>{{{ $content->pivot->title }}}</h3>
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
					@endif	
				@endforeach
			@endforeach

		</div>
		<br>
		<div class="more"><a href="{{ route('news.all') }}">{{ trans('global.More') }} +</a></div>
	</div><!-- end #news -->

	<div id="faqs" class="container">
		<h1 class="title">{{ trans('global.FAQs') }}</h1>
		<p>{{ trans('global.Find answers to Frequently Asked Questions about TDrive and our services below.') }}</p>
		<div id="questions">
			@foreach($faqs as $faq)
				@foreach($faq->languages as $fq)
					<?php $iso_code = ''; ?>
					@foreach($languages as $language)
						@if($language->id == $fq->pivot->language_id)
							<?php $iso_code = strtolower($language->iso_code); ?>
						@endif
					@endforeach
					@if($iso_code == Session::get('locale'))
						<h3>{{{ $fq->pivot->question }}}</h3>
						<div><p>{{{ $fq->pivot->answer }}}</p></div>
					@endif	
				@endforeach
			@endforeach
		</div>
	</div><!-- end #faqs -->
	<div id="contact" class="container">
		<h1 class="title">{{ trans('global.Contact us') }}</h1>
		<p>{{ trans('global.Your comments and suggestions are important to us. You can reach us via the contact points below.') }}</p>
		{{ Form::open(array('route'=>'reports.inquiries.store-inquiry', 'method' => 'post')) }}
			@if(Session::has('message'))
				<br>
				<p class="form-success">{{ Session::get('message') }}</p>
			@endif

			<div class="control clearfix">
				<input type="text" name="name" id="name" placeholder="{{ trans('global.name') }}" required>

				{{ $errors->first('name', '<p class="form-error">:message</p>') }}
			</div>

			<div class="control clearfix">
				<input type="email" name="email" id="email" placeholder="{{ trans('global.email') }}" required>

				{{ $errors->first('email', '<p class="form-error">:message</p>') }}
			</div>

			<div class="select clearfix">
				<select name="game_title" class="clearfix" id="game" required>
					<option value="General Inquiry">{{ trans('global.General Inquiry') }}</option>
					@foreach($games as $game)
						<option value="{{ $game->main_title }}">{{ $game->main_title }}</option>
					@endforeach
				</select>

				{{ $errors->first('game_title', '<p class="form-error">:message</p>') }}
			</div>

			<div class="captcha control clearfix">
				{{ HTML::image(Captcha::img(), 'Captcha image') }}
				<?php $test = trans('global.type what you see...'); ?>
				{{ Form::text('captcha', null, array('placeholder' => trans('global.type what you see...'), 'required' => 'required')) }}
				{{ $errors->first('captcha', '<p class="form-error">:message</p>') }}
			</div>

			<div class="control clearfix">
				<textarea name="message" id="message" placeholder="{{ trans('global.message') }}" required></textarea>

				{{ $errors->first('message', '<p class="form-error">:message</p>') }}
			</div>

			<div class="control clearfix">
				<input type="submit" value="{{ trans('global.submit') }} &raquo;">
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
						  		<p> {{ htmlspecialchars_decode(str_limit($row->pivot->content, $limit = 200, $end = '...')) }}</p>
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

		$(window).load(function() {

			$('#slider').show();

			$('.thumbs-container').each(function() {
				$(this).show();
			});

			for(var i = 0; i < ctr; i++) {
	        	$('#myModal' + (i + 1)).modal('show');
	        }

	        for(var i = 0; i < ctr2; i++) {
	        	$('#newsAlert' + (i + 1)).modal('show');
	        }

	        if($(window).width() >= 321){
	        	$('.featured').swiper({
					slidesPerView: 2,
					centeredSlides: true,
					calculateHeight: true,
					initialSlide: 2,
					pagination: '.swiper-pagination',
	        		paginationClickable: true
				});
	        } else {
	        	 $('.featured').swiper({
					slidesPerView: 1,
					centeredSlides: true,
					calculateHeight: true,
					pagination: '.swiper-pagination',
	        		paginationClickable: true
				});
	        }
	       

	        $(window).resize(function() {
	        	var height = $(window).height();
	        	var width = $(window).width();

	        	if(width >= 321){
	        		$('.featured').swiper({
						slidesPerView: 2,
						calculateHeight: true
					});
	        	} else if(width <= 320 ){
	        		$('.featured').swiper({
						slidesPerView: 1,
						calculateHeight: true
					});
	        	}
	        });

			$('.thumbs-container').each(function() {
				$(this).swiper({
					slidesPerView: 'auto',
					offsetPxBefore: 0,
					offsetPxAfter: 10,
					calculateHeight: true
				});
			});

	    });

		var token = $('#token input').val();

		$('#polyglotLanguageSwitcher1').polyglotLanguageSwitcher1({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',
			testMode: true,
			onChange: function(evt){
				$.ajax({
					url: "{{ URL::route('choose_language') }}",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: token
					},
					success: function(data) {
						location.reload();
					}
				});
			}
		});

		$('#polyglotLanguageSwitcher2').polyglotLanguageSwitcher2({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',
			testMode: true,
			onChange: function(evt){
				$.ajax({
					url: "{{ URL::route('choose_language') }}",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: token
					},
					success: function(data) {
					    location.reload();
					}
				});
			}
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

		$("#buy").on('click',function() {
			$('#carrier-select').remove();
			 $.ajax({
			 	type: "get",
			 	url: "{{ URL::route('games.carrier', $game->id) }}",
			 	dataType: "json",
			 	complete:function(data) {
			 		
			 		var carriers = $.parseJSON(data['responseText']);
					var append = '<select id="carrier-select">';

					for(x = 0; x < carriers.length; x++ ) 
					{
						append += '<option value="' + carriers[x].id + '">' + carriers[x].carrier + '</option>';
					}
					append += '</select>';
				
					if($('#carrier-container').find('#carrier-select').length == 0) 
					{
						$('#submit-carrier').before(append);
						append = '';
					}
                }
            });

			$('#buy').fancybox({
				'titlePosition'     : 'inside',
	            'transitionIn'      : 'none',
	            'transitionOut'     : 'none',
	            afterClose: function() {
	            	var app_id = 'blazing-dribble-globe-en';
	            	var user_id = '';
	            	$.fancybox({
			            'width': '80%',
			            'height': '60%',
			            'autoScale': true,
			            'transitionIn': 'fade',
			            'transitionOut': 'fade',
			            'type': 'iframe',
			            'href': 'http://106.186.24.12/tdrive_api/process_billing.php?app_id=' + app_id + '&uuid=' + user_id,
			            afterClose: function() {

			            	$.ajax({
							 	type: "get",
							 	url: "{{ URL::route('games.status', $game->id) }}",
							 	complete:function(data) {

							 		var response = JSON.parse(data['responseText']);
							 		console.log(response.status);
									if(response.status == 1) {
										$('#game-download').css('display', 'block');
										$('#buy').css('display', 'none');

										var url = 'http://122.54.250.228:60000/tdrive_api/download.php?transaction_id=' + response.transaction_id + '&receipt=' + response.receipt + '&uuid=1';
										$('#game-download').attr('href', url);
									}
				                }
				            });
			            }
			        });
	            }
			});
        });

	</script>
	<script>
		$(document).ready(function() {
			var resize = false;
			$('.tablet ul.menu li').each(function() {
				if($(this).height() > 70) 
				{
					resize = true;
				} 
				
			})
			if(resize) 
			{
				$('.tablet ul.menu li').find('a').css('font-size', '10px');
				$('.tablet ul.menu li').find('a').css('padding', '50px 0 5px');
				  
			}
				
			
		});
	</script>

@stop
