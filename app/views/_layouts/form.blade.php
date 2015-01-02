@include('_partials/header')

	<div id="content">
		
		@yield('content')

	</div><!-- end #content -->

</div><!-- end #container -->

{{ HTML::script("//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"); }}
<script>window.jQuery || document.write('<script src="js/jquery-1.10.2.min.js"><\/script>')</script>
{{ HTML::script("js/pushy.min.js"); }}

@section('javascripts')
@show

</body>
</html>

