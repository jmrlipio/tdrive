<!DOCTYPE>
<html>
	@include('_partials.head')
</head>

<body>
	<header class="header-main clearfix">
		@include('_partials.header')
	</header>
	@include('_partials.nav_mobile_header')
	<main>
		@yield('content')
	</main>

   
    <div class="tablet">
        @include('_partials.footer')
    </div>

{{ HTML::script('js/jquery-1.11.1.js') }}
<!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
@yield('page-script')

</body>
</html>