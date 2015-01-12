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
			<meta property="og:url" content="http://localhost/tdrive/public/game/{{ $game->id }}" />
			<meta property="og:title" content="{{ $game->main_title }}" />
			<meta property="og:description" content="{{ $item->pivot->excerpt }}" />
			<meta property="og:image" content="{{ url() }}/images/games/{{ $game->slug}}.jpg" />
		@endforeach
	@elseif(isset($news))
		@foreach($news->contents as $item)
			<meta property="og:url" content="http://localhost/tdrive/public/news/{{ $news->id }}" />
			<meta property="og:title" content="{{ $news->main_title }}" />
			<meta property="og:description" content="{{ $item->pivot->excerpt }}" />
			<meta property="og:image" content="{{ url() }}/images/news/{{ $news->slug}}.jpg" />
		@endforeach
	@endif

	<link rel="shortcut icon" href="favicon.ico">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">

	{{ HTML::style("css/normalize.css"); }}
	{{ HTML::style("css/font-awesome.min.css"); }}
	{{ HTML::style("css/pushy.css"); }}
	{{ HTML::style("css/polyglot-language-switcher.css"); }}

	@section('stylesheets')
	@show

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

		<div class="container clearfix">
			<a href="#" id="nav-toggle" class="menu-btn"><i class="fa fa-bars"></i></a>
			<a href="{{ URL::previous(); }}" id="back"><i class="fa fa-angle-left"></i></a>

			<?php $tdrive = $general_settings[0]->value ?>

			<a href="{{ route('home.show') }}" id="tdrive">{{ HTML::image("images/tdrive.png", "$tdrive", array('class' => 'auto')) }}</a>

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
						<form action="{{ URL::route('choose_language') }}" id="locale" class="language" method="post">

							{{ Form::token() }}

							<select name="locale" id="polyglot-language-options">
								<option id="en" value="en" {{ (strtolower($user_location['isoCode']) == 'us' || Lang::locale() == 'us') ? ' selected' : '' }}>English</option>
								<option id="th" value="th" {{ (strtolower($user_location['isoCode']) == 'th' || Lang::locale() == 'th') ? ' selected' : '' }}>Thai</option>
								<option id="id" value="id" {{ (strtolower($user_location['isoCode']) == 'id' || Lang::locale() == 'id') ? ' selected' : '' }}>Bahasa Indonesia</option>
								<option id="my" value="my" {{ (strtolower($user_location['isoCode']) == 'my' || Lang::locale() == 'my') ? ' selected' : '' }}>Bahasa Malaysia</option>
								<option id="cn" value="cn" {{ (strtolower($user_location['isoCode']) == 'cn' || Lang::locale() == 'cn') ? ' selected' : '' }}>Traditional Chinese</option>
								<option id="cn" value="cn" {{ (strtolower($user_location['isoCode']) == 'cn' || Lang::locale() == 'cn') ? ' selected' : '' }}>Simplified Chinese</option>
								<option id="vn" value="vn" {{ (strtolower($user_location['isoCode']) == 'vn' || Lang::locale() == 'vn') ? ' selected' : '' }}>Vietnamese</option>
								<option id="jp" value="jp" {{ (strtolower($user_location['isoCode']) == 'jp' || Lang::locale() == 'jp') ? ' selected' : '' }}>Japanese</option>
								<option id="hi" value="hi" {{ (strtolower($user_location['isoCode']) == 'hi' || Lang::locale() == 'hi') ? ' selected' : '' }}>Hindi</option>
							</select>

							<input type="submit" value="select">
						</form>
					</div>

				</div>
			</div>

			<a href="http://tose.com.ph" id="tose" target="_blank">{{ HTML::image('images/tose.png', 'TOSE') }}</a>
		</div>

	</div><!-- end #header -->

	<div id="container">

