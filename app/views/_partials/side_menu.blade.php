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

	<form action="{{ URL::route('choose_language') }}" id="locale" class="language" method="post">

		{{ Form::token() }}

		<select name="locale" onselect="this.form.submit()">
			<option value="" selected>select Telco</option>
			<option value="en">English</option>
			<option value="de" {{ Lang::locale() == 'de' ? ' selected' : '' }}>German</option>
		</select>

		<input type="submit" value="select">
	</form>

	<ul class="menu">
		<li><a href="{{ route('home.show') }}#latest-games" class="menu-games">{{ trans('global.games') }}</a></li>
		<li><a href="{{ route('home.show') }}#news" class="menu-news">{{ trans('global.news') }}</a></li>
		<li><a href="{{ route('home.show') }}#faqs" class="menu-faqs">{{ trans('global.faqs') }}</a></li>
		<li><a href="{{ route('home.show') }}#contact" class="menu-contact">{{ trans('global.contact') }}</a></li>
	</ul>

	<ul class="social">
		<li><a href="#" class="facebook"><i class="fa fa-facebook"></i> <span>Facebook</span></a></li>
		<li><a href="#" class="twitter"><i class="fa fa-twitter"></i> <span>Twitter</span></a></li>
		<li><a href="#" class="support"><i class="fa fa-heart"></i> <span>support@tdrive.co</span></a></li>
	</ul>

	<div class="copyright">
		<ul>
			<li><a href="#">Japan</a></li>
			<li><a href="#">Philippines</a></li>
		</ul>

		<p>Copyright &copy; {{{ date('Y') }}} <a href="#">TDrive</a>.</p>
		<p>All rights reserved.</p>
	</div>

</div><!-- end #side-menu -->

<!--<div class="site-overlay"></div>-->
