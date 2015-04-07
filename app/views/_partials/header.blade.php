<?php

$user_location = GeoIP::getLocation();   
$site_variables = SiteVariable::all();
$general_settings = GeneralSetting::all();
$game_settings = GameSetting::all();

?>

<!DOCTYPE>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{{ $page_title }}} | TDrive</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="og:site_name" content="TDrive" />

	@if (isset($general_settings[2]) || !empty($general_settings[2]))
		{{ $general_settings[2]->value }}
	@endif

	@if(isset($game))
		@foreach($game->contents as $item)
			<meta property="og:url" content="{{ url() }}/game/{{ $game->id }}/{{ $game->slug }}--{{ Session::get('locale') }}" />
			<meta property="og:title" content="{{ $item->pivot->title }}" />
			<meta property="og:description" content="{{ $item->pivot->excerpt }}" />
			<?php break; ?>
		@endforeach

		@foreach($game->media as $media)
			@if($media->type == 'homepage')
				<meta property="og:image" content="{{ url() }}/assets/games/homepage/{{ $media->url}}" />
			@endif
		@endforeach
	@endif

	@if(isset($news))
		@if(!Request::segment(1))
			@foreach($news->contents as $item)
				<meta property="og:url" content="{{ url() }}news/{{ $item->id }}" />
				<meta property="og:title" content="{{ $item->main_title }}" />
				<meta property="og:description" content="{{ $item->pivot->excerpt }}" />
				<meta property="og:image" content="{{ url() }}/images/news/{{ $item->slug}}.jpg" />
			@endforeach
		@endif
	@endif

	@if(isset($live_news))
		@if(!Request::segment(1))
			@foreach($live_news as $single_news)
				@foreach($single_news->contents as $item)
					<meta property="og:url" content="{{ url() }}news/{{ $item->id }}" />
					<meta property="og:title" content="{{ $item->main_title }}" />
					<meta property="og:description" content="{{ $item->pivot->excerpt }}" />
					<meta property="og:image" content="{{ url() }}/images/news/{{ $item->slug}}.jpg" />
				@endforeach
			@endforeach
		@endif
	@endif

	<link rel="shortcut icon" href="favicon.ico">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">

	{{ HTML::style("css/normalize.css"); }}
	{{ HTML::style("css/font-awesome.min.css"); }}
	{{ HTML::style("css/pushy.css"); }}
	{{ HTML::style("css/polyglot-language-switcher.css"); }}

	@section('stylesheets')
	@show
	
	<style>
		#news-detail .social div.like {
			display: block;
		  	float: left;
		  	text-align: center;
		  	padding: 6px 32px 6px 8px;
		  	margin-right: 10px;
		  	-webkit-border-radius: 2px;
		  	border-radius: 2px;
		  	background-clip: padding-box;
		}
		#news-detail .social div.like {
		  background: #0086dd;
		  color: #fff;
		  padding: 6px 10px 6px 10px;
		}
		#game-detail #statistics .top .social div.likes {
		  -webkit-border-radius: 4px;
		  border-radius: 4px;
		  background-clip: padding-box;
		  display: block;
		  width: 66px;
		  float: left;
		  text-align: center;
		  margin-right: 5px;
		  padding: 2px 0 4px;
		  margin-top: 10px;
		}
		#game-detail #statistics .top .social div.likes span {
		  display: block;
		}
		#game-detail #statistics .top .social div.likes {
		  background: #fff;
		  margin-right: 0;
		}
		#game-detail #statistics .top .social div.likes span {
		  padding-top: 5px;
		  font-size: 12px;
		  color: #0086dd;
		}
		html#facebook div._56zz, div._56zz {
			display: none !important;
		}
		#news-detail .social {
			margin-top: -10px;
		}
		#news-detail .container {
			padding: 0;
		}
		#news-detail #header .container {
			padding: 0 10px;
		}
		div#game_like {
			overflow: hidden;
			height: 65px;
		}
		div#news_like {
			overflow: hidden;
			height: auto;
		}
	</style>

	{{ HTML::style("css/base.css"); }}
	{{ HTML::style("css/style.css"); }}
</head>

<body id="{{ $page_id }}" class="{{ $page_class or '' }}">

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=199491936915697&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

	@include('_partials/side_menu')

	<div id="header">

		<?php
			$lang = (isset($_GET['locale'])) ? $_GET['locale'] : 'us'; 
			// Session::set('locale', $lang);
		?>

		<div class="container clearfix">
			<a href="#" id="nav-toggle" class="menu-btn"><i class="fa fa-bars"></i></a>
			<a href="{{ URL::previous(); }}" id="back"><i class="fa fa-angle-left"></i></a>

			<?php $tdrive = $general_settings[0]->value ?>

			<div id="tdrive"><a href="{{ route('home.show') }}">{{ HTML::image("images/tdrive.png", "$tdrive") }}</a></div>

			<div class="tablet fl clearfix">
				<ul class="menu fl">
					<li><a href="{{ route('home.show') }}#latest-games" class="menu-games">{{ trans('global.games') }}</a></li>
					<li><a href="{{ route('home.show') }}#news" class="menu-news">{{ trans('global.news') }}</a></li>
					<li><a href="{{ route('home.show') }}#faqs" class="menu-faqs">{{ trans('global.faqs') }}</a></li>
					<li><a href="{{ route('home.show') }}#contact" class="menu-contact">{{ trans('global.contact') }}</a></li>
				</ul>

				<div class="fl">
					<div class="top">

						@if (Auth::check())
							
							<p><a href="{{ route('user.profile', Auth::user()->id) }}"><i class="fa fa-user"></i> {{ Auth::user()->username }}</a> | {{ link_to_route('users.logout', trans('global.logout')) }}</p>

						@else

							<ul>
								<li><a href="{{ route('users.login') }}" class="login">{{ trans('global.login') }}</a></li>
								<li><a href="{{ route('users.register') }}" class="register">{{ trans('global.register') }} <i class="fa fa-user"></i></a></li>
							</ul>

						@endif

					</div>
					
					<div id="polyglotLanguageSwitcher1" class="polyglotLanguageSwitcher">

						<?php 
							/*$games = Game::whereCarrierId(Session::get('carrier'))->get();	
							$arr_id = [];

							foreach($games as $game){								
								foreach($game->contents as $content) {
									$arr_id[] = $content->pivot->language_id;						
								}
							}

							$lang_id = array_unique($arr_id);
							$languages = Language::whereIn('id', $lang_id)->get();*/


						?>

						<form action="{{ URL::route('choose_language') }}" id="locale" class="language" method="post">

							<select name="locale" id="polyglot-language-options">
								
								


								<option id="us" value="us" {{ (strtolower($user_location['isoCode']) == 'us' || Session::get('locale') == 'us' ) ? ' selected' : '' }}>English</option>
								<option id="th" value="th" {{ (strtolower($user_location['isoCode']) == 'th' || Session::get('locale') == 'th' ) ? ' selected' : '' }}>Thai</option>
								<option id="id" value="id" {{ (strtolower($user_location['isoCode']) == 'id' || Session::get('locale') == 'id' ) ? ' selected' : '' }}>Bahasa Indonesia</option>
								<option id="my" value="my" {{ (strtolower($user_location['isoCode']) == 'my' || Session::get('locale') == 'my' ) ? ' selected' : '' }}>Bahasa Malaysia</option>
								<option id="cn" value="cn" {{ (strtolower($user_location['isoCode']) == 'cn' || Session::get('locale') == 'cn' ) ? ' selected' : '' }}>Traditional Chinese</option>
								<option id="cn" value="cn" {{ (strtolower($user_location['isoCode']) == 'cn' || Session::get('locale') == 'cn' ) ? ' selected' : '' }}>Simplified Chinese</option>
								<option id="vn" value="vn" {{ (strtolower($user_location['isoCode']) == 'vn' || Session::get('locale') == 'vn' ) ? ' selected' : '' }}>Vietnamese</option>
								<option id="jp" value="jp" {{ (strtolower($user_location['isoCode']) == 'jp' || Session::get('locale') == 'jp' ) ? ' selected' : '' }}>Japanese</option>
								<option id="hi" value="hi" {{ (strtolower($user_location['isoCode']) == 'hi' || Session::get('locale') == 'hi' ) ? ' selected' : '' }}>Hindi</option>
							</select>

							

							<input type="submit" value="select">
						</form>
						
					</div>

				</div>
			</div>

			<div id="tose"><a href="http://tose.com.ph" target="_blank">{{ HTML::image('images/tose.png', 'TOSE') }}</a></div>
		</div>

	</div><!-- end #header -->

	<div class="site-overlay"></div>

	<div id="container">{{--Session::get('locale') --}}

