<!DOCTYPE>
<html>
	@include('_partials.news_head')
</head>

@if ($className == 'news-detail')
<body class="news-detail">
@else
<body class="news">
@endif
	<header class="header-main clearfix">
		@include('_partials.header')
	</header>
	@include('_partials.nav_mobile_header')
	
	<main>
		@yield('content')
	</main>

{{ HTML::script('js/jquery-1.11.1.js') }}
<!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
@yield('news-script')
</body>
</html>