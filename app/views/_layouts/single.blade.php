@include('_partials/header')

	<div id="content">
		
		@yield('content')

	</div><!-- end #content -->

</div><!-- end #container -->

{{ HTML::script("//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"); }}
<script>window.jQuery || document.write('<script src="js/jquery-1.10.2.min.js"><\/script>')</script>
{{ HTML::script("js/pushy.min.js"); }}

@section('javascripts')

	<script>
		(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
		function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
		e=o.createElement(i);r=o.getElementsByTagName(i)[0];
		e.src='//www.google-analytics.com/analytics.js';
		r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
		ga('create','(UA-64600222-1','auto');ga('send','pageview');
	</script>


@show

</body>
</html>
