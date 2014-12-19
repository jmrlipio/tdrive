<div class="mobile">
	<div class="sb-slidebar sb-left">

		<nav class="nav-main">
			<ul class="first">
				<div class="clearfix">
					<li><a href="{{ route('users.login') }}" class="sign-in">Sign In</a></li>
					<li><a href="{{ route('users.signup') }}" class="join-now">Join Now <i class="fa fa-user"></i></a></li>
				</div>
			</ul>

			<form action="#" method="post" class="search clearfix">
				<input type="text" name="search" placeholder="search game...">
				<div class="submit"><i class="fa fa-search"></i></div>
			</form>

			<form action="#" method="post" class="language">
				<select name="language">
					<option value="">select language...</option>
					<option value="singtel (english)">singtel (english)</option>
				</select>
			</form>

			<ul class="second">
				<li><a href="{{ route('games') }}" class="games">Games</a></li>
				<li><a href="{{ route('news') }}" class="news">News</a></li>
				<li><a href="faqs.php" class="faqs">FAQs</a></li>
				<li><a href="contact.php" class="contact">Contact</a></li>
			</ul>

			<ul class="social">
				<li><a href="#" class="facebook">Facebook</a></li>
				<li><a href="#" class="twitter">Twitter</a></li>
				<li><a href="#" class="support">support@tdrive.co</a></li>
			</ul>

			<div class="copyright">
				<p><a href="#">Japan</a> | <a href="#">Philippines</a></p>
				<p>Copyright &copy; 2014 TDrive.</p>
				<p>All rights reserved.</p>
			</div>
		</nav>

	</div>
</div>
