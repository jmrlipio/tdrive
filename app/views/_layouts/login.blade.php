<!DOCTYPE>
<html>
	@include('_partials.login_head')
</head>

<body>
	<header class="header-main">
		@include('_partials.login_header')
	</header>

	<main>
		@yield('content')
	</main>

</body>
</html>