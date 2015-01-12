<?php

$user_location = GeoIP::getLocation();   
$site_variables = SiteVariable::all();
$general_settings = GeneralSetting::all();
$game_settings = GameSetting::all();

?>

<div id="footer">
	<div class="container">

		<ul class="social">
			<li><a href="{{ $site_variables[6]->variable_value }}" class="support"><i class="fa fa-heart"></i> <span>support@tdrive.co</span></a></li>
			<li><a href="{{ $site_variables[0]->variable_value }}" class="facebook"><i class="fa fa-facebook"></i> <span>Facebook</span></a></li>
			<li><a href="{{ $site_variables[1]->variable_value }}" class="twitter"><i class="fa fa-twitter"></i> <span>Twitter</span></a></li>
		</ul>

		<div class="copyright">
			<ul>
				<li><a href="{{ $site_variables[4]->variable_value }}">Japan</a></li>
				<li><a href="{{ $site_variables[5]->variable_value }}">Philippines</a></li>
			</ul>

			<p>Copyright &copy; {{{ date('Y') }}} <a href="{{ route('home.show') }}">{{ $general_settings[0]->value }}</a>.</p>
			<p>All rights reserved.</p>
		</div>

	</div>
</div>

</div><!-- end #container -->

{{ HTML::script("//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"); }}
<script>window.jQuery || document.write('<script src="js/jquery-1.10.2.min.js"><\/script>')</script>
{{ HTML::script("js/pushy.min.js"); }}
{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}

<script>

	var _token = $('#token input').val();

	$('#polyglotLanguageSwitcher1').polyglotLanguageSwitcher1({ 
		effect: 'fade',
		paramName: 'locale', 
		websiteType: 'dynamic',

		onChange: function(evt){

			$.ajax({
				url: "language",
				type: "POST",
				data: {
					locale: evt.selectedItem,
					_token: _token
				},
				success: function(data) {
					alert(evt.selectedItem);
				}
			});

            return true;
        }
	});

	$('#polyglotLanguageSwitcher2').polyglotLanguageSwitcher2({ 
		effect: 'fade',
		paramName: 'locale', 
		websiteType: 'dynamic',

		onChange: function(evt){

			$.ajax({
				url: "language",
				type: "POST",
				data: {
					locale: evt.selectedItem,
					_token: _token
				},
				success: function(data) {
					alert(evt.selectedItem);
				}
			});

            return true;
        }
	});

	(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
	function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
	e=o.createElement(i);r=o.getElementsByTagName(i)[0];
	e.src='//www.google-analytics.com/analytics.js';
	r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
	ga('create','(UA-58420474-1','auto');ga('send','pageview');

</script>

@section('javascripts')

@show

</body>
</html>
