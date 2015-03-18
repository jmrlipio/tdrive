@extends('_layouts/single')

@section('stylesheets')
	{{ HTML::style("css/slick.css"); }}
	{{ HTML::style("css/jquery.fancybox.css"); }}
	{{ HTML::style("css/idangerous.swiper.css"); }}
@stop

@section('content')
	{{ Form::token() }}
	{{ HTML::image("images/games/{$game->slug}.jpg", $game->main_title, array('id' => 'featured')) }}
	
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
					<li><a href="{{ route('category.show', $item->id) }}">{{ $item->category }}</a></li>
				@endforeach

			</ul>

			<p>Release: {{{ $game->release_date }}}</p>
		</div>
	</div><!-- end #top -->
	{{ Session::get('locale') }}
	<div id="buttons" class="container clearfix">
		<div class="downloads">
			<div class="vcenter">
				<p class="count">
					@if($game->downloads == 0 )
						{{ number_format($game->actual_downloads, 0) }}
					@else
						{{ number_format($game->downloads, 0) }}
					@endif
				</p>
				<p class="words"><!--<span>Thousand</span>--> Downloads</p>
			</div>
		</div>

		<div class="ratings">
			<div class="vcenter">
				<p class="count">{{ $ratings['average'] ? $ratings['average'] : 0 }}</p>
				<?php $ctr = $ratings['average'] ? $ratings['average'] : 0; ?>
				<div class="stars">
	
					@for ($i=1; $i <= 5; $i++)						
						@if($i <= $ctr)
							<a href="#"><i class="fa fa-star active"></i></a>									
						@else
							<a href="#"><i class="fa fa-star"></i></a>
						@endif
					@endfor  
					
					
				</div>
			</div>
		</div>

		@if ($game->default_price == 0)
			<a href="#" class="download">
				<div>
					<p class="clearfix">{{ HTML::image('images/download.png', 'Download', array('class' => 'auto')) }}<span>Download</span></p>
				</div>
			</a>
		@else
			<!-- <a href="{{ URL::route('games.carrier', $game->id) }}" class="buy"> -->
			<a href="#" class="download" id="game-download">
				<div>
					<p class="clearfix">{{ HTML::image('images/download.png', 'Download', array('class' => 'auto')) }}<span>Download</span></p>
				</div>
			</a>
			<a href="#carrier-select-container" class="buy" id="buy">
				<div>
					<p class="image clearfix">{{ HTML::image('images/buy.png', 'Buy', array('class' => 'auto')) }}<span>Buy Now</span></p>

					@unless ($game->default_price == 0)
						@foreach($game->prices as $price) 
							@if(Session::get('country_id') == $price->pivot->country_id && Session::get('carrier') == $price->pivot->carrier_id)
								<p class="price">{{ $country->currency_code . ' ' . number_format($price->pivot->price, 2) }}</p>
							@endif
						@endforeach
					@endunless

				</div>
			</a>

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

		@foreach($game->contents as $item)
			@if(isset($_GET['locale']))
				@if($_GET['locale'] == strtolower($item->iso_code))
					{{ htmlspecialchars_decode($item->pivot->content) }}
				@endif
			@else
				@if(strtolower($item->iso_code) == 'us')
					{{ htmlspecialchars_decode($item->pivot->content) }}
				@endif
			@endif
		@endforeach

	</div><!-- end #description -->

	<div id="screenshots" class="container">
		<div class="swiper-container thumbs-container">
			<div class="swiper-wrapper">

				@foreach($game->media as $screenshots)
					@if($screenshots->type == 'screenshots')

						<div class="swiper-slide item">
							<a href="{{ url() }}/assets/games/screenshots/{{ $game->image_orientation . '-' . $screenshots->url }}" class="fancybox">
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
							<a href="#"><i class="fa fa-star active"></i></a>
							<a href="#"><i class="fa fa-star active"></i></a>
							<a href="#"><i class="fa fa-star active"></i></a>
							<a href="#"><i class="fa fa-star"></i></a>
							<a href="#"><i class="fa fa-star"></i></a>
						</div>

						<p class="total">{{ $ratings['count'] ? $ratings['count'] : 0 }} total</p>
					</div>
			@endif

			<div class="social clearfix">
				<a href="#share" id="inline" class="share" >
					{{ HTML::image('images/share.png', 'Share', array('class' => 'auto')) }}
					<span>Share</span>
				</a>
				<div style="display:none">
					<div id="share" style="text-align:center;">
						<h4 style="margin: 10px 0;">Share the game to the following social networks.</h4>
						
					<!-- FACEBOOK SHARE -->
						<a style="margin:0 2px;" href="http://www.facebook.com/sharer/sharer.php?s=100&amp;p[url]={{ url() }}/game/{{ $game->id }}&amp;p[images][0]={{ url() }}/images/games/azukitap.jpg" data-social='{"type":"facebook", "url":"{{ url() }}/game/{{ $game->id }}", "text": "{{ $game->main_title }}"}' title="{{ $game->main_title }}">
							{{ HTML::image('images/icon-social-facebook.png', 'Share', array('class' => 'auto')) }}
						</a>

					<!-- TWITTER SHARE -->
						<a style="margin:0 2px;" href="https://twitter.com/share?url={{ url() }}/game/{{ $game->id }}" data-social='{"type":"twitter", "url":"{{ url() }}/game/{{ $game->id }}", "text": "Hey! Checkout this new game named {{ $game->main_title }} at \n"}' title="{{ $game->main_title }}">
							{{ HTML::image('images/icon-social-twitter.png', 'Share', array('class' => 'auto')) }}
						</a>
						<!-- <a href="mailto:support@tdrive.co" target="_blank">Email</a> -->

					</div>
				</div>

				<div class="likes">
					<div id="game_like" class="fb-like" data-href="{{ url() }}/game/{{ $game->id }}" data-layout="box_count" data-action="like" data-show-faces="false" data-share="false"></div>
				</div>
			</div>
		</div>

		<div class="bottom">
			<div class="five clearfix">
			<?php $ctr = 0; ?>
			@foreach($game->review as $data)
				
				<?php $ctr++; ?>
			
			@endforeach
			
			@if($ctr !=0 ) 
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
			@endif	
		</div>
	</div><!-- end #statistics -->

	<div id="review" class="container">

		@if (Auth::check())
			@if(Session::has('message'))
				<p class="form-success">{{ Session::get('message') }}</p>
			@endif

			{{ Form::open(array('route' => array('review.post', $current_game->id), 'method' => 'post')) }}
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
		
		<div class="link center"><a href="{{ route('reviews', $game->id) }}">See all reviews &raquo;</a></div>

	@else

		<br>
		
	@endif
	
	</div><!-- end #reviews -->

	<div id="related-games" class="container">
		<h1 class="title">Related games</h1>
		
		@if(!empty($related_games))

			<div class="swiper-container thumbs-container">
				<div class="swiper-wrapper">

					@foreach($related_games as $game)
						@foreach($game->media as $media)

							@if($media->type == 'icons')
								<div class="swiper-slide item">
									<div class="thumb relative">

										@if ($game->default_price == 0)
												<a href="{{ URL::route('game.show', $game->id) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
											@endif
										
										<a href="{{ URL::route('game.show', $game->id) }}" class="thumb-image">{{ HTML::image('assets/games/icons/' . $media->url) }}</a>


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

		@else

			<p>No related games.</p>

		@endif

		<div class="more"><a href="{{ route('games.related', $game->id) }}">More +</a></div>
	</div><!-- end #related-games -->

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/slick.min.js"); }}
	{{ HTML::script("js/jquery.fancybox.js"); }}
	{{ HTML::script("js/idangerous.swiper.min.js"); }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}
	{{ HTML::script("js/jqSocialSharer.min.js"); }}

	<script>
		FastClick.attach(document.body);

		var token = $('input[name="_token"]').val();

		var carrier_form = '';

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
						// location.reload();
						console.log('success');
					}
				});
			}
		});

		$('#polyglotLanguageSwitcher2').polyglotLanguageSwitcher2({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',
			onChange: function(evt){
				$.ajax({
					url: "{{ URL::route('choose_language') }}",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: token
					},
					success: function(data) {
						// location.reload();
					}
				});
			}
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
        $("#share a").jqSocialSharer();
		$('.fancybox').fancybox({ padding: 0 });

		$("#buy").on('click',function() {
			 $.ajax({
			 	type: "get",
			 	url: "{{ URL::route('games.carrier', $game->id) }}",
			 	dataType: "json",
			 	complete:function(data) {
			 		console.log(data['responseText']);
					var append = '<select id="carrier-select">';

					JSON.parse(data['responseText'], function (id, carrier) {		    
					    append += '<option value="' + id + '">' + carrier + '</option>';
					});

					append += '</select><br>';
					
					if($('#carrier-container').find('#carrier-select').length == 0) {
						$('#submit-carrier').before(append);
						}

					$('#carrier-select option:last').remove();
					$('#carrier-select option:last').remove();
                }
            });

			$('#buy').fancybox({
				'titlePosition'     : 'inside',
	            'transitionIn'      : 'none',
	            'transitionOut'     : 'none',
	            afterClose: function() {
	            	$.fancybox({
			            'width': '80%',
			            'height': '60%',
			            'autoScale': true,
			            'transitionIn': 'fade',
			            'transitionOut': 'fade',
			            'type': 'iframe',
			            'href': 'http://122.54.250.228:60000/tdrive_api/process_billing.php?app_id=1&carrier_id=1&uuid=1',
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

		$('#carrier').on('submit', function(e){
			e.preventDefault();

			$.fancybox.close();

			// $.fancybox({
	  //           'width': '80%',
	  //           'height': '80%',
	  //           'autoScale': true,
	  //           'transitionIn': 'fade',
	  //           'transitionOut': 'fade',
	  //           'type': 'iframe',
	  //           'href': 'http://122.54.250.228:60000/tdrive_api/process_billing.php?app_id=1&carrier_id=1&uuid=1',
	  //           afterClose: function() {

	  //           	$.ajax({
			// 		 	type: "get",
			// 		 	url: "{{ URL::route('games.status', $game->id) }}",
			// 		 	complete:function(data) {
			// 				if(data['responseText'] == 1) {
			// 					$('#game-download').css('display', 'none');
			// 				}
		 //                }
		 //            });
	  //           }
	  //       });

		});
	
	</script>

@stop
