@extends('_layouts/single')

@section('stylesheets')
	{{ HTML::style("css/slick.css"); }}
	{{ HTML::style("css/jquery.fancybox.css"); }}
	{{ HTML::style("css/idangerous.swiper.css"); }}
	<style>
		
		.discounted { 
			text-decoration: line-through; 
			position: relative;
  			top: -10;
  			font-size: 14px;
		}
		#game-detail #buttons .buy .image span{
			padding-top: 0 !important;
		}
		.repo { position: relative;	top: -10;}

	</style>
@stop

@section('content')
	<?php $game_image = $game->slug;  ?>
	{{ Form::token() }}
	@foreach($game->media as $media)	
		@if($media->type == 'promos')
			{{ HTML::image('assets/games/promos/' . $media->url, $game->main_title, array('id' => 'featured')) }}
		@endif
	@endforeach
	
	<div style="display:none"><div id="carrier-form"><h1>This is a test</h1></div></div>

	<div id="top" class="clearfix container">
		<div class="thumb">

			@foreach($game->media as $media)
				@if($media->type == 'icons')
					{{ HTML::image('assets/games/icons/' . $media->url, $game->main_title) }}
				@endif
			@endforeach

		</div>

		<div class="title">
			<h3>{{{ $game->main_title }}}</h3>

			<ul class="categories clearfix">

				@foreach ($game->categories as $item)
					<li><a href="#">{{ trans('global.'.$item->category) }}</a></li>
				@endforeach

			</ul>

			<p>{{ trans('global.Release') }}: {{{ $game->release_date }}}</p>
		</div>
	</div><!-- end #top -->

	<div id="buttons" class="container clearfix">
		<div class="downloads">
			<div class="vcenter">
				<p class="count">
				
				@if($game->downloads == 0)
					{{ number_format($game->actual_downloads, 0) }}
				@else
					{{ number_format($game->downloads, 0) }}
				@endif
				</p>
				<p class="words"><!--<span>Thousand</span>--> {{ trans('global.Downloads') }}</p>
			</div>
		</div>

		<div class="ratings">
			<div class="vhcenter">
				<p class="count">{{ $ratings['average'] ? $ratings['average'] : 0 }}</p>

				<?php $ctr = $ratings['average'] ? $ratings['average'] : 0; ?>

				<div class="stars">
	
					@for ($i=1; $i <= 5; $i++)						
						@if($i <= $ctr)
							<i class="fa fa-star active"></i>
						@else
							<i class="fa fa-star"></i>
						@endif
					@endfor  
					
				</div>
			</div>
		</div>

		@if ($game->default_price < 1)

			<a href="#" class="download">
				<div>
					<p class="clearfix">{{ HTML::image('images/download.png', 'Download', array('class' => 'auto')) }}<span>{{ trans('global.Download') }}</span></p>
				</div>
			</a>

		@else

			<a href="#" class="download" id="game-download">
				<div>
					<p class="clearfix">{{ HTML::image('images/download.png', 'Download', array('class' => 'auto')) }}<span>{{ trans('global.Download') }}</span></p>
				</div>
			</a>
		
		@if(Auth::check())
			<a href="#" class="buy" id="buy">
				<div>
					<p class="image clearfix">{{ HTML::image('images/buy.png', 'Buy', array('class' => 'auto')) }}<span>{{ trans('global.Buy Now') }}</span></p>

						@foreach($game->apps as $apps)

							@if($apps->pivot->app_id == $app_id)

								@unless ($apps->pivot->price == 0)
            
					            	<?php $dc = GameDiscount::checkDiscountedGames($game->id, $discounted_games);
					              		$sale_price = $apps->pivot->price * (1 - ($dc/100));
					              	?>
					             
						            @if($dc != 0)
						              
						            	<p class="price">{{ $apps->pivot->currency_code . ' ' . number_format($sale_price, 2) }}</p> 

						            @else
						            
						            	<p class="price">{{ $apps->pivot->currency_code . ' ' . number_format($apps->pivot->price, 2) }}</p>

						            @endif            
					             
					            @endunless

							@endif

						@endforeach

				</div>
			</a>
			
			@else 
			{{ Session::put('pre_login_url', Request::url()); }}
			<a href="#" class="buy" id="buy">
				<div>
					<p class="image clearfix">{{ HTML::image('images/buy.png', 'Buy', array('class' => 'auto')) }}<span>{{ trans('global.Buy Now') }}</span></p>

					@foreach($game->apps as $apps)

						@if($apps->pivot->app_id == $app_id)

							@unless ($apps->pivot->price == 0)
            
				            	<?php $dc = GameDiscount::checkDiscountedGames($game->id, $discounted_games);
				              		$sale_price = $apps->pivot->price * (1 - ($dc/100));
				              	?>
				             
					            @if($dc != 0)
					              
					            	<p class="price">{{ $apps->pivot->currency_code . ' ' . number_format($sale_price, 2) }}</p> 

					            @else
					            
					            	<p class="price">{{ $apps->pivot->currency_code . ' ' . number_format($apps->pivot->price, 2) }}</p>

					            @endif            
				             
				            @endunless

						@endif

					@endforeach

				</div>
			</a>


			@endif

			<div style="display:none">
				<div class="carrier-container" id="carrier-select-container">
					{{ Form::open(array('route' => array('games.carrier.details', $game->id), 'id' => 'carrier')) }}
						<h3>Select Carrier</h3>
						<input type="submit" id="submit-carrier" class="carrier-submit" value="choose">
					{{ Form::close() }}
				</div>
			</div>

		@endif
	</div><!-- end #buttons -->

	<div id="description" class="container">
		<?php $excerpt = '';  ?>
		{{-- @foreach($game->contents as $item)
			@if(Session::has('locale'))
				@if(Session::get('locale') == strtolower($item->iso_code))
					<div class="content">{{ htmlspecialchars_decode($item->pivot->excerpt) }} <a href="" class="readmore">Read more</a></div>
					
				@endif
			@else
				@if(strtolower($item->iso_code) == 'us')
					<div class="content">{{ htmlspecialchars_decode($item->pivot->excerpt) }} <a href="" class="readmore">Read more</a></div>
					
				@endif
			@endif
  		@endforeach --}}
  		
			<div class="content hey">{{ htmlspecialchars_decode($preview['excerpt']) }} <a href="#" class="readmore">Read more</a></div>
			<?php $game_excerpt = htmlspecialchars_decode($preview['excerpt']); ?>
			
  		<input type="hidden" id="game_content" value="{{htmlspecialchars_decode($preview['content'])}}">

	</div><!-- end #description -->

	<div id="screenshots" class="container">
		<div class="swiper-container thumbs-container">
			<div class="swiper-wrapper">
				@foreach($game->media as $screenshots)

					@if($screenshots->type == 'video')

						<div class="swiper-slide item">
							<a href="{{ $screenshots->url }}" rel="group" class="fancybox-media">{{ HTML::image('images/video.png') }}</a>
						</div>
					@endif	

				@endforeach

				@foreach($game->media as $screenshots)

					@if($screenshots->type == 'screenshots')
						<div class="swiper-slide item">
							<a href="{{ url() }}/assets/games/screenshots/{{ $game->image_orientation . '-' . $screenshots->url }}" rel="group" class="fancybox-media">
								{{ HTML::image('assets/games/screenshots/' . $game->image_orientation . '-' . $screenshots->url, $game->main_title) }}
							</a>
						</div>
					@endif	
					
				@endforeach

			</div>
		</div>
	</div>

	<div id="statistics" class="container">
		<div class="top clearfix">			

			<?php $ctr = 0; ?>

			@foreach($game->review as $data)
				
				<?php $ctr++; ?>
			
			@endforeach
			
			@if($ctr != 0)

				<p class="count">{{ $ratings['average'] ? $ratings['average'] : 0 }}</p>

				<div class="stars-container">
					<div class="stars">
						<i class="fa fa-star active"></i>
						<i class="fa fa-star active"></i>
						<i class="fa fa-star active"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
					</div>

					<p class="total">{{ $ratings['count'] ? $ratings['count'] : 0 }} {{ trans('global.total') }}</p>
				</div>

			@else

				<p class="count">0</p>

				<div class="stars-container">
					<div class="stars">
						<i class="fa fa-star active"></i>
						<i class="fa fa-star active"></i>
						<i class="fa fa-star active"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
					</div>

					<p class="total">0 total</p>
				</div>

			@endif

			<div class="social clearfix">
		  		@foreach($game->apps as $app)
				    @if($app->pivot->app_id == $app_id)
				     	<?php $iso_code = ''; ?>
				      @foreach($languages as $language)
					       @if($language->id == $app->pivot->language_id)
					        <?php $iso_code = strtolower($language->iso_code); ?>
					       @endif
				      @endforeach

					    @if(Session::get('locale') == $iso_code)
					       <?php $excerpt = htmlspecialchars_decode($app->pivot->excerpt); ?> 
					    @endif

				     @endif

			    @endforeach

				<a href="#share" id="inline" class="share" >
					{{ HTML::image('images/share.png', 'Share', array('class' => 'auto')) }}
					<span>{{ trans('global.Share') }}</span>
				</a>
				
				<div style="display:none">
					<div id="share" style="text-align:center;">
						<h4 style="margin: 10px 0;">{{ trans('global.Share the game to the following social networks.') }}</h4>
						
						<!-- TWITTER SHARE -->
						<a style="margin:0 2px;" href="#" data-social='{"type":"twitter", "url":"{{URL::current()}}", "text": "{{{$excerpt}}}"}' title="\n{{ $game->main_title }}">

							{{ HTML::image('images/icon-social-twitter.png', 'Share', array('class' => 'auto')) }}
						</a>

						<!-- FACEBOOK SHARE -->
						<a style="margin:0 2px;" href="#" data-social='{"type":"facebook", "url":"{{URL::current()}}", "text": "{{ $game->main_title }}"}' title="{{ $game->main_title }}">
							{{ HTML::image('images/icon-social-facebook.png', 'Share', array('class' => 'auto')) }}
						</a>
					</div>
				</div>

				<div class="likes">
					<div id="game_like" class="fb-like" data-href="{{URL::current()}}" data-layout="box_count" data-action="like" data-show-faces="false" data-share="false"></div>
				</div>
			</div>
		</div>

		<div class="bottom">

			<div class="center">

				<?php $ctr = 0; ?>

				@foreach($game->review as $data)
					<?php $ctr++; ?>
				@endforeach

				@if($ctr !=0 ) 

					<div class="five clearfix">

						<div class="stars">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						</div>

						<div class="meter clearfix">
							<span style="width: {{ ($ratings['five'] != 0) ? ($ratings['five'] / $ratings['count']) * 100 : 2.5 }}%"></span>

							<p class="total">{{ $ratings['five'] }}</p>
						</div>
					
					</div>

					<div class="four clearfix">
						<div class="stars">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						</div>

						<div class="meter clearfix">
							<span style="width: {{ ($ratings['four'] != 0) ? ($ratings['four'] / $ratings['count']) * 100 : 2.5 }}%"></span>

							<p class="total">{{ $ratings['four'] }}</p>
						</div>
					</div>

					<div class="three clearfix">
						<div class="stars">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						</div>

						<div class="meter clearfix">
							<span style="width: {{ ($ratings['three'] != 0) ? ($ratings['three'] / $ratings['count']) * 100 : 2.5 }}%"></span>

							<p class="total">{{ $ratings['three'] }}</p>
						</div>
					</div>

					<div class="two clearfix">
						<div class="stars">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						</div>

						<div class="meter clearfix">
							<span style="width: {{ ($ratings['two'] != 0) ? ($ratings['two'] / $ratings['count']) * 100 : 2.5 }}%"></span>

							<p class="total">{{ $ratings['two'] }}</p>
						</div>
					</div>

					<div class="one clearfix">
						<div class="stars">
							<i class="fa fa-star"></i>
						</div>

						<div class="meter clearfix">
							<span style="width: {{ ($ratings['one'] != 0) ? ($ratings['one'] / $ratings['count']) * 100 : 2.5 }}%"></span>

							<p class="total">{{ $ratings['one'] }}</p>
						</div>
					</div>

				@else

					<div class="five clearfix">

						<div class="stars">
							<a href="#"><i class="fa fa-star"></i></a>
							<a href="#"><i class="fa fa-star"></i></a>
							<a href="#"><i class="fa fa-star"></i></a>
							<a href="#"><i class="fa fa-star"></i></a>
							<a href="#"><i class="fa fa-star"></i></a>
						</div>

						<div class="meter clearfix">
							<span style="width: 5px;"></span>

							<p class="total">0</p>
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
							<span style="width: 5px;"></span>

							<p class="total">0</p>
						</div>
					</div>

					<div class="three clearfix">
						<div class="stars">
							<a href="#"><i class="fa fa-star"></i></a>
							<a href="#"><i class="fa fa-star"></i></a>
							<a href="#"><i class="fa fa-star"></i></a>
						</div>

						<div class="meter clearfix">
							<span style="width: 5px;"></span>

							<p class="total">0</p>
						</div>
					</div>

					<div class="two clearfix">
						<div class="stars">
							<a href="#"><i class="fa fa-star"></i></a>
							<a href="#"><i class="fa fa-star"></i></a>
						</div>

						<div class="meter clearfix">
							<span style="width: 5px;"></span>

							<p class="total">0</p>
						</div>
					</div>

					<div class="one clearfix">
						<div class="stars">
							<a href="#"><i class="fa fa-star"></i></a>
						</div>

						<div class="meter clearfix">
							<span style="width: 5px;"></span>

							<p class="total">0</p>
						</div>
					</div>

				@endif	

			</div>

		</div>
	</div><!-- end #statistics -->

	<div id="review" class="container">

		@if (Auth::check())
			@if(Session::has('message'))
				<p class="form-success">{{ Session::get('message') }}</p>
			@endif

			<form>
				
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
				<a href="#">{{ trans('global.Login to write a review') }} <i class="fa fa-pencil"></i></a>
			</div>

		@endif

	</div><!-- end #review -->

	<div id="reviews" class="container">
		<?php $ctr = 0; ?>
		@forelse($game->review as $data)
			@if($data->pivot->status == 1)
				<?php $ctr++; ?>
				@if($ctr <= 4)
					<div class="entry clearfix">
						{{ HTML::image('images/avatars/placeholder.jpg', 'placeholder') }}
			
						<div>
							<p class="name">{{ $data->first_name }}</p>

							<div class="stars">
								@for ($i=1; $i <= 5 ; $i++)
				                    <i class="fa fa-star{{ ($i <= $data->pivot->rating) ? '' : '-empty'}}"></i>
				                 @endfor    
							</div>

							<p class="date">{{ Carbon::parse($data->pivot->created_at)->format('M j') }}</p>

							<p class="message">{{{ $data->pivot->review }}}</p>
						</div>
					</div>
				@endif
			@endif
		@empty
			<!-- <p>be the first one to add a review!</p> -->
		@endforelse
		
	@if($ctr > 4)	
		
		<div class="link center"><a href="#">{{ trans('global.See all reviews') }} &raquo;</a></div>

	@else

		<br>
		
	@endif
	
	</div><!-- end #reviews -->
	
	<div id="related-games" class="container">
		<h1 class="title">{{ trans('global.Related games') }}</h1>
		
		@if(!empty($related_games))

			<div class="swiper-container thumbs-container">
				<div class="swiper-wrapper">

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
											<div class="thumb relative">
												@if ($app->pivot->price == 0)
													<a href="# }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
												@endif

												<a href="#" class="thumb-image">{{ HTML::image('assets/games/icons/' . $media->url) }}</a>

												@if ($app->pivot->price == 0)
													<a href="#">{{ HTML::image('images/ribbon-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
												@endif
										
												@if($dc = GameDiscount::checkDiscountedGames($game->id, $discounted_games) != 0)
													<a href="#">{{ HTML::image('images/ribbon-discounted-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
												@endif

												@if($dc = GameDiscount::checkDiscountedGames($game->id, $discounted_games) != 0)
													<a href="#">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
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

				</div>
			</div>

		@else

			<p>{{ trans('global.No related games.') }}</p>

		@endif

		<div class="more"><a href="#">{{ trans('global.More') }} +</a></div>
	</div><!-- end #related-games -->

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/slick.min.js"); }}
	{{ HTML::script("js/jquery.fancybox.js"); }}
	{{ HTML::script("js/jquery.fancybox-media.js"); }}
	{{ HTML::script("js/idangerous.swiper.min.js"); }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}
	{{ HTML::script("js/jqSocialSharer.min.js"); }}
	{{ HTML::script("js/jquery.event.move.js"); }}
	{{ HTML::script("js/jquery.event.swipe.js"); }}
	{{ HTML::script("js/share.js"); }}


	<script>
		FastClick.attach(document.body);
		
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

		$('.fancybox').fancybox({ 
			padding: 0 
		});

		$('.fancybox-media').fancybox({ 
			padding: 0, 
			helpers: { media: true }
		});

		$('.thumbs-container').each(function() {
			$(this).swiper({
				slidesPerView: 'auto',
				offsetPxBefore: 0,
				offsetPxAfter: 10,
				calculateHeight: true
			})
		});

		$("#inline").fancybox({
            'titlePosition'     : 'inside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none'
        });

       
	</script>

	<script>
	$(document).ready(function(){
	
		$('#description .readmore').click(function(e) {
			e.preventDefault();
			
			$('#description .content').html($('#game_content').val());
		});
	});
	</script>
@stop
