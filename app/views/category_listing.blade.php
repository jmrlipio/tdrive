@extends('_layouts/default')

@section('stylesheets')
	{{ HTML::style("css/bootstrap.min.css"); }}
	{{ HTML::style("css/lightSlider.css"); }}
	{{ HTML::style("css/jquery.fancybox.css"); }}
	{{ HTML::style("css/jquery-ui.css"); }}
	{{ HTML::style("css/idangerous.swiper.css"); }}
	{{ HTML::style("css/owl.carousel.css"); }}
	{{ HTML::style("css/owl.theme.min.css"); }}
	{{ HTML::style("css/jquery.fancybox.css"); }}
	<style>
		#category-listing {
		  background: #465a65 !important;
		  color: #fff;
		 }
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

		.owl-theme .owl-dots .owl-dot span {
			background: #e9548e;
		}
		.owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span {
			background: #E08BAC;
		}
		/*.owl-carousel.owl-loaded {
			margin-top: -10px;
		}*/
		a.news_link{color: #fff !important;}

		.modal div.fancybox-close-btn {
		  text-align: center;
		  display: block;
		}
		.modal div.fancybox-close-btn a{
		  background: #e9548e;
		  padding: 0 5px 5px;
		  color: white;
		}
		#select-category {
			background: url(../images/dropdown.png) #fff no-repeat right;
			background-size: 20.5% 100%;
			-webkit-appearance: none;
			-moz-appearance: none;
			margin: 18px 0 0;
			float: right;
			font-size: 14px;
			width: 150px;
			padding: 5px 0;
		}

	</style>
@stop

@section('content')
<?php $ctr = 0; ?>
@foreach($categories as $cat)

	<?php $apps = Game::getAppsPerCategory($cat->id); ?>
	@if(!$apps)
		<?php continue; ?>
	@endif

	<div class="game-category container">
		<?php $ctr++; ?>
		@if($ctr == 1)
			<h1 class="title">{{ trans('global.games') }}</h1>			

			{{Form::open(array('id'=>'category'))}}		
				<span id="custom-dd">	
					{{ Form::select('select-category', array('default' => trans('global.Please select')) + $cat_list, 'default', array('class' => 'select-category', 'id' => 'select-category')) }}
				</span>
			{{Form::close()}}

		@endif
	
		<div class="clearfix">
			<h2 class="title fl">{{ trans('global.'.$cat->category) }}</h2>
		</div>

		<div class="swiper-container thumbs-container">
			<div class="swiper-wrapper">
				<?php $count = 0; ?>
				@foreach($apps as $app) 
					<?php $count++; ?>
					<div class="swiper-slide item">
						<div class="thumb relative">
							<a href="{{ URL::route('game.show', array('id' => $app->pivot->game_id, $app->pivot->app_id)) }}" class="thumb-image"><img src="assets/games/icons/{{ Media::getGameIcon($app->pivot->game_id) }}"></a>
							<?php $discounted_price = Discount::checkDiscountedGame($app->pivot->game_id); ?>
							@if($discounted_price && $app->pivot->price != 0)
								<a href="{{ URL::route('game.show', array('id' => $app->pivot->game_id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-discounted-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
								<a href="{{ URL::route('game.show', array('id' => $app->pivot->game_id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
							@elseif( $app->pivot->price == 0 )
								<a href="{{ URL::route('game.show', array('id' => $app->pivot->game_id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-back.png', 'Free', array('class' => 'free-back auto')) }}</a>
								<a href="{{ URL::route('game.show', array('id' => $app->pivot->game_id, $app->pivot->app_id)) }}">{{ HTML::image('images/ribbon-front.png', 'Free', array('class' => 'free-front auto')) }}</a>
							@endif
						</div>

						<div class="meta">
							<p class="name">{{{  $app->pivot->title }}}</p>
							
							@if($discounted_price && $app->pivot->price != 0)
								<?php $sale_price = ($app->pivot->price) - (($discounted_price / 100) * $app->pivot->price)  ?>
								<p class="price-original">{{ $app->pivot->currency_code . ' ' . number_format($app->pivot->price, 2) }}</p>
								<p class="price price">{{ $app->pivot->currency_code . ' ' . number_format($sale_price, 2) }}</p>	
							@else
								<p class="price">{{ $app->pivot->currency_code . ' ' . number_format($app->pivot->price, 2) }}</p>
							@endif
						</div>
						<div class="game-button">
							@if ($app->pivot->price == 0)
								<a href="#" data-id="{{$app->pivot->game_id }}" class="game-free">Free</a>
							@else

								<a href="#" id="buy" data-id="{{  $app->pivot->game_id }}" class="game-buy buy">{{ trans('global.Buy') }}</a>	

							@endif
						</div>
					</div>
				@endforeach  
			</div>
			<div class="more fr"><a href="{{ route('category.show', $cat->id) }}">{{ trans('global.More') }}+</a></div>
		</div>
	</div>
@endforeach


@stop

@section('javascripts')

	{{ HTML::script("js/fastclick.js") }}
	{{ HTML::script("js/bootstrap.min.js") }}
	{{ HTML::script("js/jquery.lightSlider.min.js") }}
	{{ HTML::script("js/jquery.fancybox.js") }}
	{{ HTML::script("js/idangerous.swiper.min.js") }}
	{{ HTML::script("js/owl.carousel.min.js") }}
	{{ HTML::script("js/jquery-ui.min.js") }}
	{{ HTML::script("js/jquery.ddslick.min.js") }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js") }}
	
	@include('_partials/scripts')

	<script>

		FastClick.attach(document.body);
		
		var token = $('input[name="_token"]').val();
		var ctr = $('#ctr').val();
		var ctr2 = $('#ctr2').val();

		$(window).load(function() {

			$('#category').change(function() {
				var id = $(this).find('select').val();
				if(id != 'default'){
					window.location.href = "category/"+id;
				}				
			});

			$(".owl-carousel").owlCarousel({
				center: true,
				loop:true,
				items:2,
				autoplay: true,
				dots: true,
				dotEach: true,
			    responsive:{
			        600:{
			            items:2
			        }
			    }
			});
			// }

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

			$('.thumbs-container').each(function() {
				$(this).swiper({
					slidesPerView: 'auto',
					offsetPxBefore: 0,
					offsetPxAfter: 10,
					calculateHeight: true
				});
			});
		
			var mySwiper;

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

		$(".game-buy").on('click',function() {
			var id = $(this).attr('data-id');
			$('#carrier-select').remove();
			 $.ajax({
			 	type: "POST",
			 	url: "{{ url() }}/games/post/carrier",
			 	data: {id: id},
			 	success:function(data) {
			 		console.log(data);
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

			$('.game-buy').fancybox({
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
							 	type: "POST",
							 	url: "{{ url() }}/games/post/carrier",
							 	data: {id: id},
							 	success:function(data) {

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
	
@stop
