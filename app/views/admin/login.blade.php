<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>TDrive</title>
    {{ HTML::style('css/style.css') }}
    {{ HTML::style('css/admin.css') }}
    {{ HTML::style('http://fonts.googleapis.com/css?family=Open+Sans') }}
    {{ HTML::style('http://fonts.googleapis.com/css?family=Indie+Flower') }}

    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
    <header>
        {{ HTML::image('images/tdrive-logo.png', 'TDrive Logo') }}
        <div id="user-menu">
            @if(Auth::check())
                <p>
                    Welcome, 
                    <a href="{{ URL::route('admin.users.show', Auth::user()->id) }}">{{ Auth::user()->first_name }}</a> | 
                    {{ link_to_route('admin.logout', 'Sign Out') }}
                </p>
            @else
                <p>     
                    {{ HTML::link('users/newaccount', 'Sign Up') }}
                </p>
            @endif
        </div>
    </header>
    <div id="login">
        {{ Form::open(array('route' => 'admin.login.post', 'class' => 'login')) }}
            <h2>Please login</h2>
            <ul>
                <li>
                    {{ Form::label('username', 'Username') }}
                    {{ Form::text('username') }}
                    {{ $errors->first('username', '<p class="error">:message</p>') }}
                </li>
                <li>
                    {{ Form::label('password', 'Password') }}
                    {{ Form::password('password') }}
                    {{ $errors->first('password', '<p class="error">:message</p>') }}
                </li>
                <li>
                    {{ Form::submit('Log in') }}
                </li>
            </ul>
        {{ Form::close() }}
    </div>
</body>
</html>