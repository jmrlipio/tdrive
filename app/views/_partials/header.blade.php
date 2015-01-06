<!DOCTYPE>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{{ $page_title }}} | TDrive</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="favicon.ico">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">

	{{ HTML::style("css/normalize.css"); }}
	{{ HTML::style("css/font-awesome.min.css"); }}
	{{ HTML::style("css/pushy.css"); }}

	@section('stylesheets')
	@show

	{{ HTML::style("css/base.css"); }}
	{{ HTML::style("css/style.css"); }}
</head>

<body id="{{ $page_id }}">

	@include('_partials/side_menu')

	<div id="container">

		<div id="header">

			<div class="container clearfix">
				<a href="#" id="nav-toggle" class="menu-btn"><i class="fa fa-bars"></i></a>
				<a href="{{ URL::previous(); }}" id="back"><i class="fa fa-angle-left"></i></a>
				<a href="{{ route('home.show') }}" id="tdrive">{{ HTML::image('images/tdrive.png', 'TDrive', array('class' => 'auto')) }}</a>

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

						<form action="{{ URL::route('choose_language') }}" id="locale" class="language" method="post">

							{{ Form::token() }}

							<select name="locale" onselect="this.form.submit()">
								<option value="" selected>select language</option>
								<option value="en">English</option>
								<option value="de" {{ Lang::locale() == 'de' ? ' selected' : '' }}>German</option>
							</select>

							<input type="submit" value="select">
						</form>

					</div>
				</div>

				<a href="http://tose.com.ph" id="tose" target="_blank">{{ HTML::image('images/tose.png', 'TOSE') }}</a>
			</div>

		</div><!-- end #header -->
