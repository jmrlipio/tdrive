<!DOCTYPE>
<html>
	@include('_partials.head')
</head>

<body class="home">
	<header class="header-main clearfix">
		@include('_partials.header')
	</header>

	<main>
		@yield('content')
	</main>

    <div id="footer" class="tablet">
        @include('_partials.footer')
    </div>

</body>
</html>