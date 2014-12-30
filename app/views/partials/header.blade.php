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

	@include('partials/side_menu')

	<div id="container">

		<div id="header">

			<div class="container clearfix">
				<a href="#" id="nav-toggle" class="menu-btn"><i class="fa fa-bars"></i></a>
				<a href="{{ URL::previous(); }}" id="back"><i class="fa fa-angle-left"></i></a>
				<a href="{{ route('home') }}" id="tdrive">{{ HTML::image('images/tdrive.png', 'TDrive', array('class' => 'auto')) }}</a>

				<div class="tablet fl clearfix">
					<ul class="menu fl">
						<li><a href="{{ route('home') }}/#latest-games" class="menu-games">Games</a></li>
						<li><a href="{{ route('home') }}/#news" class="menu-news">News</a></li>
						<li><a href="{{ route('home') }}/#faqs" class="menu-faqs">FAQs</a></li>
						<li><a href="{{ route('home') }}/#contact" class="menu-contact">Contact</a></li>
					</ul>

					<div class="fl">
						<div class="top">
							<ul>
								<li><a href="{{ route('users.login') }}" class="login">Sign in</a></li>
								<li><a href="{{ route('users.signup') }}" class="register">Join now <i class="fa fa-user"></i></a></li>
							</ul>
						</div>

						{{ Form::open(array('url' => '/', 'class' => 'language')); }}

							<select name="languages">
								<option value="" selected>select language</option>

								@foreach($languages as $language)
									<option value="{{ $language->id }}">{{ $language->language }}</option>
								@endforeach

							</select>

						{{ Form::close(); }}

					</div>
				</div>

				<a href="http://tose.com.ph" id="tose" target="_blank">{{ HTML::image('images/tose.png', 'TOSE') }}</a>
			</div>

		</div><!-- end #header -->
