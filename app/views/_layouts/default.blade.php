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

</body>
</html>