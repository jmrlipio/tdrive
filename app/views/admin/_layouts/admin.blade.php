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
    {{ HTML::style('css/admin.css') }}
    {{ HTML::style('css/chosen.css')}}
    {{ HTML::script('js/jquery-1.11.1.js') }}
    {{ HTML::script('js/jquery-ui.js') }}
    {{ HTML::script('js/ckeditor/ckeditor.js') }}
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
                    {{ Auth::user()->role }}
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
                @if(Auth::user()->role == 'admin')
                               
                    <li><a href="{{ URL::route('admin.games.index') }}">Games</a></li>            
                    <li><a href="{{ URL::route('admin.reports.index') }}">Reports</a></li>

                @elseif(Auth::user()->role == 'editor') 
                    <li><a href="{{ URL::route('admin.news.index') }}">News</a></li>

                @else
                    <li><a href="{{ URL::route('admin.users.index') }}">Users</a></li>                
                    <li><a href="{{ URL::route('admin.games.index') }}">Games</a></li>               
                    <li><a href="{{ URL::route('admin.news.index') }}">News</a></li>               
                    <li><a href="{{ URL::route('admin.reports.index') }}">Reports</a></li>               
                    <li id="options-link">
                        <a href="{{ URL::route('admin.siteoptions.index') }}">Site Options</a>
                        <ul id="site-options">
                            <li><a href="#">General Settings</a></li>
                            <li><a href="#">Success/Error Messages</a></li>
                            <li><a href="#">Emails</a></li>
                            <li><a href="#">Homepage</a></li>
                            <li><a href="#">Game Page</a></li>
                            <li><a href="#">News Page</a></li>
                            <li><a href="#">Site Variables</a></li>
                            <li><a href="#">Maintenance</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ URL::route('admin.faqs.index') }}">FAQ</a></li>
                @endif

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