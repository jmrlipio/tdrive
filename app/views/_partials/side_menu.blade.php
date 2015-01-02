<div id="side-menu" class="pushy pushy-left">

	<div class="top">

		@if (Auth::check())
			
			<p><a href="#"><i class="fa fa-user"></i> {{ Auth::user()->username }}</a> | {{ link_to_route('users.logout', 'Logout') }}</p>

		@else

			<ul>
				<li><a href="{{ route('users.login') }}" class="login">Sign in</a></li>
				<li><a href="{{ route('users.register') }}" class="register">Join now <i class="fa fa-user"></i></a></li>
			</ul>

		@endif

	</div>

	<div class="search">
		{{ Form::input('text', 'search', null, array('placeholder' => 'search game')); }}
		<a href="#"><i class="fa fa-search"></i></a>
	</div>

	{{ Form::open(array('url' => '/', 'class' => 'language')); }}

		<select name="languages">
			<option value="" selected>select language</option>

			@foreach($languages as $language)
				<option value="{{ $language->id }}">{{ $language->language }}</option>
			@endforeach

		</select>

	{{ Form::close(); }}

	<ul class="menu">
		<li><a href="{{ route('home') }}/#latest-games" class="menu-games">Games</a></li>
		<li><a href="{{ route('home') }}/#news" class="menu-news">News</a></li>
		<li><a href="{{ route('home') }}/#faqs" class="menu-faqs">FAQs</a></li>
		<li><a href="{{ route('home') }}/#contact" class="menu-contact">Contact</a></li>
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

<div class="site-overlay"></div>
