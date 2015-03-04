<?php

$user_location = GeoIP::getLocation();   
$site_variables = SiteVariable::all();
$general_settings = GeneralSetting::all();
$game_settings = GameSetting::all();

?>

<div id="side-menu" class="pushy pushy-left">

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

	<div class="search">

		{{ Form::open(array('action' => 'ListingController@searchGames', 'id' => 'search_form')) }}
			{{ Form::input('text', 'search', null, array('placeholder' => 'search game')); }}
			{{ Form::token() }}

			<a href="javascript:{}" onclick="document.getElementById('search_form').submit(); return false;"><i class="fa fa-search"></i></a>
		{{ Form::close() }}

	</div>
	<?php $lang = (isset($_GET['locale'])) ? $_GET['locale'] : 'us'; ?>
	<div id="polyglotLanguageSwitcher2" class="polyglotLanguageSwitcher">
		<form action="{{ URL::route('choose_language') }}" id="locale" class="language" method="post">

			{{ Form::token() }}

			<select name="locale" id="polyglot-language-options">
				<option id="en" value="en" {{ (strtolower($user_location['isoCode']) == 'us' || $lang == 'us') ? ' selected' : '' }}>English</option>
				<option id="th" value="th" {{ (strtolower($user_location['isoCode']) == 'th' || $lang == 'th') ? ' selected' : '' }}>Thai</option>
				<option id="id" value="id" {{ (strtolower($user_location['isoCode']) == 'id' || $lang == 'id') ? ' selected' : '' }}>Bahasa Indonesia</option>
				<option id="my" value="my" {{ (strtolower($user_location['isoCode']) == 'my' || $lang == 'my') ? ' selected' : '' }}>Bahasa Malaysia</option>
				<option id="cn" value="cn" {{ (strtolower($user_location['isoCode']) == 'cn' || $lang == 'cn') ? ' selected' : '' }}>Traditional Chinese</option>
				<option id="cn" value="cn" {{ (strtolower($user_location['isoCode']) == 'cn' || $lang == 'cn') ? ' selected' : '' }}>Simplified Chinese</option>
				<option id="vn" value="vn" {{ (strtolower($user_location['isoCode']) == 'vn' || $lang == 'vn') ? ' selected' : '' }}>Vietnamese</option>
				<option id="jp" value="jp" {{ (strtolower($user_location['isoCode']) == 'jp' || $lang == 'jp') ? ' selected' : '' }}>Japanese</option>
				<option id="hi" value="hi" {{ (strtolower($user_location['isoCode']) == 'hi' || $lang == 'hi') ? ' selected' : '' }}>Hindi</option>
			</select>

			<input type="submit" value="select">
		</form>
	</div>

	<ul class="menu">

		@if($lang == 'th')

			<li><a href="{{ route('home.show') }}#latest-games" class="menu-games">เกม</a></li>
			<li><a href="{{ route('home.show') }}#news" class="menu-news">ข่าว</a></li>
			<li><a href="{{ route('home.show') }}#faqs" class="menu-faqs">คำถาม</a></li>
			<li><a href="{{ route('home.show') }}#contact" class="menu-contact">ติดต่อ</a></li>

		@else

			<li><a href="{{ route('home.show') }}#latest-games" class="menu-games">Games</a></li>
			<li><a href="{{ route('home.show') }}#news" class="menu-news">News</a></li>
			<li><a href="{{ route('home.show') }}#faqs" class="menu-faqs">FAQs</a></li>
			<li><a href="{{ route('home.show') }}#contact" class="menu-contact">Contact</a></li>

		@endif
		
	</ul>

	<ul class="social">
		<li><a href="{{ $site_variables[0]->variable_value }}" class="facebook"><i class="fa fa-facebook"></i> <span>Facebook</span></a></li>
		<li><a href="{{ $site_variables[1]->variable_value }}" class="twitter"><i class="fa fa-twitter"></i> <span>Twitter</span></a></li>
		<li><a href="{{ $site_variables[6]->variable_value }}" class="support"><i class="fa fa-heart"></i> <span>support@tdrive.co</span></a></li>
	</ul>

	<div class="copyright">
		<ul>
			<li><a href="{{ $site_variables[4]->variable_value }}">Japan</a></li>
			<li><a href="{{ $site_variables[5]->variable_value }}">Philippines</a></li>
		</ul>

		<p>Copyright &copy; {{{ date('Y') }}} <a href="{{ route('home.show') }}">{{ $general_settings[0]->value }}</a>.</p>
		<p>All rights reserved.</p>
	</div>

</div><!-- end #side-menu -->

<!--<div class="site-overlay"></div>-->
