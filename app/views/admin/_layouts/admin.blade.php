<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>TDrive</title>
    {{ HTML::style('http://fonts.googleapis.com/css?family=Open+Sans') }}
    {{ HTML::style('http://fonts.googleapis.com/css?family=Indie+Flower') }}
    {{ HTML::style('css/jquery-ui.css') }}
    {{ HTML::style('css/jquery-ui.structure.css') }}
    {{ HTML::style('css/jquery-ui.theme.css') }}
    {{ HTML::style('css/dropzone.css') }}
    {{ HTML::style('css/style.css') }}
    {{ HTML::style('css/admin.css') }}
    {{ HTML::style('css/chosen.css')}}
    {{ HTML::script('js/jquery-1.11.1.js') }}
    {{ HTML::script('js/jquery-ui.js') }}
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
    <header>
        {{ HTML::image('images/tdrive-logo.png', 'TDrive Logo') }}
        <h1>Welcome to the TDrive Dashboard</h1>
        <div id="user-menu">
            @if(Auth::check())
                <p>
                    Welcome, 
                    <a href="{{ URL::route('admin.users.show', Auth::user()->id) }}">{{ Auth::user()->first_name }}</a> | 
                    {{ link_to_route('admin.logout', 'Sign Out') }}
                </p>
            @else
                <p>     
                    {{ HTML::link('users/signin', 'Sign In') }}
                    {{ HTML::link('users/newaccount', 'Sign Up') }}
                </p>
            @endif
        </div>
    </header>
    @if(Auth::check())
    <nav id="admin-panel">
        <ul>
            <li><a href="{{ URL::route('admin.users.index') }}">Users</a></li>
            <li><a href="{{ URL::route('admin.games.index') }}">Games</a></li>
            <li><a href="{{ URL::route('admin.news.index') }}">News</a></li>
            <li><a href="{{ URL::route('admin.media.create') }}">Gallery</a></li>
            <li><a href="#">Reports</a></li>
            <li><a href="#">Pages</a></li>
            <li><a href="#">FAQ</a></li>
        </ul>
    </nav>
    @endif
    <main>
        @yield('content')
    </main>
    <div class="clear"></div>
    <footer>
        
    </footer>
</body>
</html>