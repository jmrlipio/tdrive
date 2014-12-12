<div class="mobile">
    <div class="sb-slidebar sb-left">

        <nav class="nav-main">
            <ul class="first">
                <div class="clearfix">
                    <li><a href="{{ route('users.login') }}" class="sign-in">Sign In</a></li>
                    <li><a href="{{ route('users.signup') }}" class="join-now">Join Now</a></li>
                </div>
            </ul>
            
            <form action="#" method="post" class="search clearfix">
                <input type="text" name="search" placeholder="search game...">
                <input type="submit" value="Go">
            </form>

            <form action="#" method="post" class="language">
                <select name="language">
                    <option value="">select language...</option>
                    <option value="singtel (english)">singtel (english)</option>
                </select>
            </form>
            
            <ul class="second">
                <li><a href="#" class="games">Games</a></li>
                <li><a href="#" class="news">News</a></li>
                <li><a href="#" class="faqs">FAQs</a></li>
                <li><a href="#" class="contact">Contact</a></li>
            </ul>

            <ul class="social">
                <li><a href="#" class="facebook">Facebook</a></li>
                <li><a href="#" class="twitter">Twitter</a></li>
                <li><a href="#" class="support">support@tdrive.co</a></li>
            </ul>

            <div class="copyright">
                <p>Japan &#124; Philippines</p>
                <p>Copyright &copy; 2014 TDrive.</p>
                <p>All rights reserved.</p>
            </div>
        </nav>

    </div>
</div>

<div class="tablet-portrait">
	<div class="nav-sub">
		<ul>
			<div class="clearfix">
				<li><a href="{{ route('users.login') }}" class="sign-in">Sign In</a></li>
				<li><a href="{{ route('users.signup') }}" class="join-now">Join Now</a></li>
			</div>
		</ul>

		<form action="#" method="post">
			<select name="language">
				<option value="">select language...</option>
				<option value="singtel (english)">singtel (english)</option>
			</select>
		</form>
	</div>
</div>

<div class="clearfix">

	<a href="#" class="sb-toggle-left nav-toggle">Menu</a>
	<a href="/" class="logo-main">TDrive</a>

	<div class="tablet">
		<ul class="nav-main">
			<li><a href="{{ route('games') }}" class="games">Games</a></li>
			<li><a href="{{ route('news') }}" class="news">News</a></li>
			<li><a href="#" class="faqs">FAQs</a></li>
			<li><a href="#" class="contact">Contact</a></li>			
		</ul>

		<div class="tablet-landscape">
			<div class="nav-sub">
				<ul>
					<div class="clearfix">
						<li><a href="{{ route('users.login') }}" class="sign-in">Sign In</a></li>
						<li><a href="{{ route('users.signup') }}" class="join-now">Join Now</a></li>
					</div>
				</ul>

				<form action="#" method="post">
					<select name="language">
						<option value="">select language...</option>
						<option value="singtel (english)">singtel (english)</option>
					</select>
				</form>
			</div>
		</div>
	</div>

	<a href="http://tose.com.ph" class="logo-tose" target="_blank">TOSE</a>

</div>