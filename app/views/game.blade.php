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
		#update-form-wrapper {display: none;}

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

	{{-- HTML::image("images/games/{$game->slug}.jpg", $game->main_title, array('id' => 'featured')) --}}
	
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
					<li><a href="{{ route('category.show', $item->id) }}">{{ trans('global.'.$item->category) }}</a></li>
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

		<a href="#" class="download" id="game-download">
			<div>
				<p class="clearfix">{{ HTML::image('images/download.png', 'Download', array('class' => 'auto')) }}<span>{{ trans('global.Download') }}</span></p>
			</div>
		</a>

		@if(Auth::check())
			<a href="#carrier-select-container" class="buy" id="buy">
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
			<a href="{{ URL::route('users.login')}}?redirect_url={{ Request::url() }}" class="buy" id="buy">
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
  		@foreach($game->apps as $app)

			@if($app->pivot->app_id == $app_id)
			<div class="content hey">{{ htmlspecialchars_decode($app->pivot->excerpt) }} <a href="" class="readmore">Read more</a></div>
			<?php $game_excerpt = htmlspecialchars_decode($app->pivot->excerpt); ?>
			@endif

  		@endforeach

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

				<p class="count">{{ $ratings['average'] ? $ratings['average'] : 0 }}</p>
				<?php $ctr = $ratings['average'] ? $ratings['average'] : 0; ?>
				<div class="stars-container">
				<div class="stars">
					@for ($i=1; $i <= 5; $i++)						
						@if($i <= $ctr)
							<i class="fa fa-star active"></i>
						@else
							<i class="fa fa-star"></i>
						@endif
					@endfor  
				</div>

					<p class="total">{{ $ratings['count'] ? $ratings['count'] : 0 }} {{ trans('global.total') }}</p>
				</div>



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
						<a style="margin:0 2px;" href="https://twitter.com/share?url={{URL::current()}}" data-social='{"type":"twitter", "url":"{{URL::current()}}", "text": "{{{$excerpt}}}"}' title="\n{{ $game->main_title }}">

							{{ HTML::image('images/icon-social-twitter.png', 'Share', array('class' => 'auto')) }}
						</a>

						<!-- FACEBOOK SHARE -->
						<a style="margin:0 2px;" href="http://www.facebook.com/sharer/sharer.php?s=100&amp;p[url]={{URL::current()}}&amp;p[images][0]={{ url() }}/images/games/{{$game->slug}}.jpg" data-social='{"type":"facebook", "url":"{{URL::current()}}", "text": "{{ $game->main_title }}"}' title="{{ $game->main_title }}">
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

					<div class="five clearfix">

						<div class="stars">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						</div>

						<div class="meter clearfix">
							<span style="width: {{ ($ratings['five'] != 0) ? ($ratings['five'] / $ratings['count']) * 100 : 5 }}%"></span>

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
							<span style="width: {{ ($ratings['four'] != 0) ? ($ratings['four'] / $ratings['count']) * 100 : 5 }}%"></span>

							<p class="total">{{  $ratings['four']  }}</p>
						</div>
					</div>

					<div class="three clearfix">
						<div class="stars">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						</div>

						<div class="meter clearfix">
							<span style="width: {{ ($ratings['three'] != 0) ? ($ratings['three'] / $ratings['count']) * 100 : 5 }}%"></span>

							<p class="total">{{  $ratings['three']  }}</p>
						</div>
					</div>

					<div class="two clearfix">
						<div class="stars">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						</div>

						<div class="meter clearfix">
							<span style="width: {{ ($ratings['two'] != 0) ? ($ratings['two'] / $ratings['count']) * 100 : 5}}%"></span>

							<p class="total">{{ $ratings['two'] }}</p>
						</div>
					</div>

					<div class="one clearfix">
						<div class="stars">
							<i class="fa fa-star"></i>
						</div>

						<div class="meter clearfix">
							<span style="width: {{ ($ratings['one'] != 0) ? ($ratings['one'] / $ratings['count']) * 100 : 5 }}%"></span>

							<p class="total">{{ $ratings['one']  }}</p>
						</div>
					</div>

			</div>

		</div>
	</div><!-- end #statistics -->

	<div id="review" class="container">

		@if (Auth::check())

			@if($user_commented == false)

				{{ Form::open(array('route' => array('review.post', $current_game->id, $app_id), 'method' => 'post')) }}

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
					 {{ Form::submit('Submit') }}
				</div>
			 {{ Form::close() }}

				
			@endif

			@if(Session::has('message'))
				<p class="form-success">{{ Session::get('message') }}</p>
			@endif

			@if(Session::has('error'))
				<p class="form-success">{{ Session::get('error') }}</p>
			@endif

		@else

			<div class="button">
				<a href="{{ route('users.login')}}?redirect_url={{ Request::url() }}">{{ trans('global.Login to write a review') }} <i class="fa fa-pencil"></i></a>
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

 					@if (Auth::check())
 						@if($data->prof_pic != '')
							<img src="{{ Request::root() }}/images/avatars/{{ $data->prof_pic }}" id="profile_img">
						@else
							<img src="{{ Request::root() }}/images/avatars/placeholder.jpg" id="profile_img">
						@endif
								
						<div class="user-review" id="{{ $data->pivot->user_id }}" >		
											
								<p class="name">{{ $data->first_name }}</p>

								<div class="stars">
									@for ($i=1; $i <= 5 ; $i++)
					                    <i class="fa fa-star{{ ($i <= $data->pivot->rating) ? '' : '-empty'}}"></i>
					                 @endfor    
								</div>
								
								<p class="date">{{ Carbon::parse($data->pivot->created_at)->format('M j') }}</p>

								<p class="message">{{{ $data->pivot->review }}}</p>
							
								<!-- Deletes user review -->
								@if(Auth::user()->id == $data->pivot->user_id )							
									{{ Form::open(array('route' => array('remove.review', $current_game->id, $app_id) )) }}			
										{{ Form::hidden('id', $data->pivot->id) }}					
									{{ Form::submit('Remove', array('id'=>'remove-review')) }}	

									{{ Form::close() }}
								<!-- END -->

									<button id="update-review">Update</button>	

									<div id="update-form-wrapper" class="container">
									<!-- Updates the review -->
										{{Form::open(array('route' =>array('update.review', $current_game->id, $app_id),'id'=>'update-review-form'))}}
											{{ Form::hidden('game_id', $current_game->id) }}
											{{ Form::hidden('user_id', Auth::id()) }}
											{{ Form::hidden('id', $data->pivot->id) }}

											<div class="rating-control clearfix control">
												<label class="rating" for="rating">Rating</label>

												{{ Form::selectRange('rating', 1, 5, $data->pivot->rating ) }}										
												{{ $errors->first('rating', '<p class="form-error">:message</p>') }}
											</div>
					 
												
											<div class="control">
												<textarea name="review" placeholder="write a review" required>{{{ $data->pivot->review }}}</textarea>

												{{ $errors->first('review', '<p class="form-error">:message</p>') }}
											</div>

											<div class="captcha control clearfix">
												{{ HTML::image(Captcha::img(), 'Captcha image') }}
												{{ Form::text('captcha', null, array('placeholder' => 'Type what you see...', 'required' => 'required')) }}

												{{ $errors->first('captcha', '<p class="form-error">:message</p>') }}
											</div>

											
											{{ Form::submit('Save', array('id' => 'update')) }}

										{{ Form::close() }}
									<!-- END -->
									</div>	

								@endif
							@endif							
									
 						</div>
 					</div>
 				@endif
			@endif
		@empty
			<!-- <p>be the first one to add a review!</p> -->
		@endforelse
		
	@if($ctr > 4)	
		
		<div class="link center"><a href="{{ route('reviews', $game->id) }}">{{ trans('global.See all reviews') }} &raquo;</a></div>

	@else

		<br>
		
	@endif
	
	</div><!-- end #reviews -->
	
	<div id="related-games" class="container">
		<h1 class="title">{{ trans('global.Related games') }} for {{ $game->main_title; }}</h1>
		
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
								<div class="swiper-slide item">
									@include('_partials/game-thumb')
								</div>	
							@endif						
						@endforeach
					@endforeach

				</div>
			</div>

		@else

			<p>{{ trans('global.No related games') }}.</p>

		@endif

		<div class="more"><a href="{{ route('games.related', $game_id) }}">{{ trans('global.More') }} </a></div>
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
	
	@include('_partials/scripts')

	<script>
		FastClick.attach(document.body);

		var token = $('input[name="_token"]').val();
		var app_id = '{{ $app_id }}';
		var user_id = '{{ $user_id }}';
		var carrier_form = '';


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

        $("#share a").jqSocialSharer();

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
			// $.fancybox({
	  //           'width': '80%',
	  //           'height': '60%',
	  //           'autoScale': true,
	  //           'transitionIn': 'fade',
	  //           'transitionOut': 'fade',
	  //           'type': 'iframe',
	  //           'href': 'http://106.186.24.12/tdrive_api/process_billing.php?app_id=' + app_id + '&uuid=' + user_id,
	  //           afterClose: function() {
	  //           	$.ajax({
			// 		 	type: "get",
			// 		 	url: "{{ URL::route('games.status', $game->id) }}",
			// 		 	complete:function(data) {

			// 		 		var response = JSON.parse(data['responseText']);
	
			// 				if(response.status == 1) {
			// 					$('#game-download').css('display', 'block');
			// 					$('#buy').css('display', 'none');

			// 					var url = 'http://122.54.250.228:60000/tdrive_api/download.php?transaction_id=' + response.transaction_id + '&receipt=' + response.receipt + '&uuid=1';
			// 					$('#game-download').attr('href', url);
			// 				}
		 //                }
		 //            });
	  //           }
	  //       });
        });

		$('#description .readmore').click(function(e) {
			e.preventDefault();

			$.ajax({
				type: 'POST',
				url: "<?php echo URL::route('games.content.load'); ?>",
				data: { 
					id: <?php echo Request::segment(2); ?>,
					app_id: '<?php echo Request::segment(3); ?>',
					_token: token
				},

				success: function(data) {
					$('#description .content').html(data);
				}
			});
		});

		$('#carrier').on('submit', function(e){
			e.preventDefault();

			$.fancybox.close();
			$.fancybox({
	             'width': '80%',
	             'height': '80%',
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
			 				if(data['responseText'] == 1) {
			 					$('#game-download').css('display', 'none');
			 				}
		                 }
		             });
	             }
	        });
		});
	
	</script>
	<script>
		$(document).ready(function(){				
			
			$('#update-review').click(function(e){

				e.preventDefault();
				$('#update-form-wrapper').css('display','block');
				
			});
		});

	</script>
@stop
