@extends('_layouts/single')
@section('stylesheets')

	<style>
		.name h1 {padding: 0 0 10px 0 !important;}
		#profile .details > div {
		 	margin-bottom: 3px !important;
		}
		input[type="submit"] {
		  background: #e9548e;
		  color: #fff;
		  padding: 4px 6px;
		  text-transform: lowercase;
		}

	</style>
@stop
@section('content')

	<div class="container">
		<div class="relative">
			<div class="thumb">
				@if(Auth::user()->prof_pic != '')
					<img src="{{ Request::root() }}/images/avatars/{{ Auth::user()->prof_pic }}" id="profile_img">
				@else
					<img src="{{ Request::root() }}/images/avatars/placeholder.jpg" id="profile_img">
				@endif
			</div>

			<div class="details">
				<div class="name"><h1 class="title">{{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}}</h1></div>
				<div class="email">{{{ Auth::user()->email }}}</div>
				<div class="change_password"><a href="{{ route('password.change') }}">{{ trans('global.Change Password') }}</a>
				{{ Form::open(array('route' => array('user.profile.change', Auth::user()->id), 'method' => 'post', 'files' => true, 'id' => 'update-media')) }}
				
					 {{ Form::file('image', array('onchange' => 'readURL(this);', 'required')) }}
				
					{{ Form::submit("Save", array("id" => "save-image")) }}
				{{ Form::close()}}
				</div>
			</div>
		</div>
	</div>

	<div id="downloads">
		<div class="container">
			<h1 class="title">{{ trans('global.Downloaded games') }}</h1>

			<div id="token">{{ Form::token() }}</div>

			<p>You haven't bought any games yet.</p>

			<!-- <div class="grid">
				<div class="row">
					<div id="scrl" class="clearfix">
			
						@foreach ($games as $game)												
							@foreach($game->apps as $app)
								<?php $iso_code = ''; ?>
								@foreach($languages as $language)
									@if($language->id == $app->pivot->language_id)
										<?php $iso_code = strtolower($language->iso_code); ?>
									@endif
								@endforeach
								
								@if($app->pivot->status != Constant::PUBLISH)
									<?php continue; ?>
								@endif
								
								@if($iso_code == Session::get('locale') && $app->pivot->carrier_id == Session::get('carrier'))							
									@foreach ($game->media as $media)
										@if ($media->type == 'icons')
											<div class="item">
												<div class="image">
													<a href="{{ URL::route('game.show', array('id' => $game->id, $app->pivot->app_id)) }}">
														<img src="{{ URL::to('/') }}/assets/games/icons/{{ $media->url }}" alt="{{{ $app->pivot->title }}}">
													</a>
												</div>																		
												<div class="meta">
													<p>{{{ $app->pivot->title }}}</p>									
												</div>									
											</div>
										@endif
									@endforeach
								@endif
							@endforeach
						@endforeach
					</div>
				</div>
			</div> -->
	
		<!-- <div id="loadmore" class="button center"><a href="#">{{ trans('global.More') }} +</a></div> -->
		<div class="ajax-loader center"><i class="fa fa-cog fa-spin"></i> loading&hellip;</div>
	</div>
</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}
	
	@include('_partials/scripts')

	<script>
		FastClick.attach(document.body);
		var token = $('input[name="_token"]').val();
		
		function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        reader.onload = function (e) {
		            $('#profile_img').attr('src', e.target.result);
		        };
		        reader.readAsDataURL(input.files[0]);
		   	}
		}

		var load = 0;
		var num = {{ $count }};
		var page = {{ $page }};
		var token = $('input[name="_token"]').val();

		$(window).scroll(function() {
			var bottom = 50;
				if ($(window).scrollTop() + $(window).height() > $(document).height() - bottom) 
				{
					$.ajax({
						url: "{{ URL::current() }}/downloaded/games",
						type: "POST",
						data: {
							page: page,
							_token: token
						},

						success: function(data) {
							console.log(data);
							page++;
							$('#scrl').append(data);
							$('.ajax-loader').hide();
						}
					});
				}
			});

	</script>

@stop
