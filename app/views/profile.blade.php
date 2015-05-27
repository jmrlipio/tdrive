@extends('_layouts/single')
@section('stylesheets')

	<!-- REALLY?! remove and add in external -->
	<style>
		.name h1 {padding: 0 0 10px 0 !important; font-size: 24px;}
		#profile .details > div {
		 	margin-bottom: 3px !important;
		}
		input[type="submit"] {
			background: #e9548e;
			color: #fff;
			padding: 4px 6px;
			text-transform: lowercase;
		}
		.update_account a { color: #e9548e;}
		.thumb img {height: 108px !important;}
		.btn {
			display: inline-block;
			margin-bottom: 0;
			font-weight: normal;
			text-align: center;
			vertical-align: middle;
			-ms-touch-action: manipulation;
			touch-action: manipulation;
			cursor: pointer;
			background-image: none;
			border: 1px solid transparent;
			white-space: nowrap;
			padding: 0 6px;
			font-size: 14px;
			line-height: 1.42857143;
			border-radius: 4px;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}
		.btn-primary {
			color: #fff;
			background-color: #337ab7;
			border-color: #2e6da4;
		}

	</style>
@stop
@section('content')

	<div class="container">
		<div class="relative">
			<div class="thumb media-box">
			<!-- 	@if(Auth::user()->prof_pic != '')
				<img src="{{ Request::root() }}/images/avatars/{{ Auth::user()->prof_pic }}" id="profile_img">
			@else
				<img src="{{ Request::root() }}/images/avatars/placeholder.jpg" id="profile_img">
			@endif -->

					{{ Form::open(array('files' => true, 'id' => 'update-media', 'class' => 'post-media-form')) }}
							@if(Auth::user()->prof_pic != '')
								<img src="{{ Request::root() }}/images/avatars/{{ Auth::user()->prof_pic }}" id="profile_img" class="image-preview" alt="image_preview">
							@else
								<img src="{{ Request::root() }}/images/avatars/placeholder.jpg" id="profile_img" class="image-preview" alt="image_preview">
							@endif
		            	 <div style="position:relative; width: 100px; top: -22px">
		              		<a class='btn btn-primary upload-trigger' href='javascript:;'>
		                    <span class="screenshot-loader" >change</span>
		                    <input type="file" name="profile_image" id="profile_image" class="media-file" style='width:61%;position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' size="60"  onchange='$("#upload-file-info").html($(this).val());'>
		             		</a>
		             	</div>
		             {{Form::close()}}

			</div>

			<div class="details">
				<div class="name"><h1 class="title">{{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}}</h1></div>
				<div class="email">{{{ Auth::user()->email }}}</div>
				
				<div class="update_account"><a href="{{ route('users.update.account') }}">{{ trans('global.Update Profile') }}</a></div>
				
				<div class="change_password"><a href="{{ route('password.change') }}">{{ trans('global.Change Password') }}</a>
				
			<!-- 	{{ Form::open(array('route' => array('user.profile.change', Auth::user()->id), 'method' => 'post', 'files' => true, 'id' => 'update-media')) }}
			
				 {{ Form::file('image', array('onchange' => 'readURL(this);', 'required')) }}
			
				{{ Form::submit("Save", array("id" => "save-image")) }}
			{{ Form::close()}} -->
				</div>

				<div class="transactions"><a href="{{ route('profile.transactions', Auth::user()->id) }}">{{ trans('global.Transactions') }}</a></div>

			</div>
		</div>
	</div>

	<div id="downloads">
		<div class="container">
			<h1 class="title">{{ trans('global.Downloaded games') }}</h1>
			<div id="token">{{ Form::token() }}</div>
			@if(!empty($downloaded_games))
				<div class="grid">
					<div class="row">
						<div id="scrl" class="clearfix">
							@foreach($downloaded_games as $app)
								<div class="item">
									<div class="image">
										<a href="{{ URL::route('game.show', array('id' => $app->game_id, $app->app_id)) }}" class="thumb-image"><img src="{{ URL::to('/') }}/assets/games/icons/{{ Media::getGameIcon( $app->game_id) }}" ></a>
									</div>																		
									<div class="meta">
										<p>{{{ $app->title }}}</p>									
									</div>									
								</div>
							@endforeach
						</div>
					</div>
				</div>
			@else
				<p>You haven't bought any games yet.</p>
			@endif


		<!-- <div id="loadmore" class="button center"><a href="#">{{ trans('global.More') }} +</a></div> -->
		<div class="ajax-loader center"><i class="fa fa-cog fa-spin"></i> loading&hellip;</div>
	</div>
</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}
	{{ HTML::script('js/image-uploader.js') }}
	
	@include('_partials/scripts')

	<script>
		FastClick.attach(document.body);
		var token = $('input[name="_token"]').val();
		
		/*function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        reader.onload = function (e) {
		            $('#profile_img').attr('src', e.target.result);
		        };
		        reader.readAsDataURL(input.files[0]);
		   	}
		}*/

	/*	var load = 0;
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
			});*/

	</script>

	<script>
	$( document ).ready(function() {
		$('form').submit(function(){

	    var required = $('[required]'); // change to [required] if not using true option as part of the attribute as it is not really needed.
	    var error = false;

	    for(var i = 0; i <= (required.length - 1);i++)
	    {
	        if(required[i].value == '') // tests that each required value does not equal blank, you could put in more stringent checks here if you wish.
	        {
	            required[i].style.backgroundColor = 'rgb(255,155,155)';
	            error = true; // if any inputs fail validation then the error variable will be set to true;     
	        }
	    }

		    if(error) // if error is true;
		    {
		        return false; // stop the form from being submitted.
		    }
		});


		$("#profile_image").uploadBOOM({
			'url': '{{ URL::route("user.profile.change", Auth::user()->id) }}',
			'before_loading': '<span class="loader-icon"></span>Saving..',
			'after_loading' : 'Change'
		});

	});
	</script>

@stop
