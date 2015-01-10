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

@section('javascripts')
@show

</body>
</html>
