<!DOCTYPE>
<html>
	@include('partials.login_head')
</head>

<body>
	<header class="header-main">
		@include('partials.login_header')
	</header>

	<main>
		@yield('content')
	</main>

</body>
</html>
