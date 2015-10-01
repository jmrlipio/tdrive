<?php

$user_location = GeoIP::getLocation();   
$site_variables = SiteVariable::all();
$general_settings = GeneralSetting::all();
$game_settings = GameSetting::all();

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>{{{ $page_title }}} | TDrive</title>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta property="og:site_name" content="TDRIVE" />

@if (isset($general_settings[2]) || !empty($general_settings[2]))

	@if(isset($game_id))
	
		@foreach($games as $game)
			@if($game->id == $game_id)
				@foreach($game->apps as $app)
					@foreach($languages as $language)
						@if($language->id == $app->pivot->language_id)
							<?php $iso_code = strtolower($language->iso_code); ?>
						@endif
					@endforeach
					@if($iso_code == Session::get('locale') && $app->pivot->carrier_id == Session::get('carrier'))
						<meta property="og:url" content="{{ url() }}/game/{{ $game->id }}/{{ $app->pivot->app_id }}" />
						<meta property="og:title" content="{{ $app->pivot->title }}" />
						<meta property="og:description" content="{{ $app->pivot->excerpt }}" />
					@endif
				@endforeach

				@foreach($game->media as $media)
					@if($media->type == 'icons')
						<meta property="og:image" content="{{ url() }}/assets/games/icons/{{ $media->url}}" />
					@endif
				@endforeach
			@endif
		@endforeach
	@endif

@endif

@if(isset($news->id))
 <?php $thumbnail = $news->featured_image; ?>
 <?php if( isset($_GET['lang']) ) : ?>
  <?php $content = News::getNewsByLang($news->id, $_GET['lang']); ?>
   <?php if($content) : ?>
    <meta property="og:locale" content="en_US" />
    <meta property="og:url" content="{{ url() }}/news/{{ $content->pivot->news_id }}?lang={{ $_GET['lang'] }}" />
    <meta property="og:title" content="{{ $content->pivot->title }}" />
    <meta property="og:description" content="{{ $content->pivot->excerpt }}" />
    <meta property="og:image" content="{{ url() }}/assets/news/{{ $thumbnail }}" /> 
   <?php endif; ?> 
 <?php endif; ?>
@endif

<link rel="apple-touch-icon" href="apple-touch-icon.png">

{{ HTML::style("css/normalize.css"); }}
{{ HTML::style("css/font-awesome.min.css"); }}
{{ HTML::style("css/pushy.css"); }}
{{ HTML::style("css/polyglot-language-switcher.css"); }}

@section('stylesheets')
@show

<style>
	#logo-container {
		margin-top: 10px;
	}
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

<!-- Google Analytics Tracking Code -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-64600222-1', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body id="{{ $page_id }}" class="{{ $page_class or '' }}">
<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=199491936915697";
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
		<!-- <a href="{{ URL::previous(); }}" id="back"><i class="fa fa-angle-left"></i></a> -->
		<a href="#" onClick="history.go(-1); return false;" id="back"><i class="fa fa-angle-left"></i></a>

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
					$languages = Language::getLanguage(Session::get('carrier'));
				?>
				<form action="{{ URL::route('choose_language') }}" id="locale" class="language" method="post">
					<select name="locale" id="polyglot-language-options">
						@foreach($languages as $lang)												
							<?php $selected = (strtolower($lang->iso_code) == Session::get('locale')) ? ' selected' : ''; ?>
								<option id="{{strtolower($lang->iso_code)}}" value="{{strtolower($lang->iso_code)}}" {{ $selected }}>{{$lang->language}}</option>		
															
						@endforeach	
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

