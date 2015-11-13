<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>TDrive</title>

    {{ HTML::style('css/bootstrap.min.css'); }}
    {{ HTML::style('css/dataTables.bootstrap.css') }}
    {{ HTML::style('css/jquery-ui.css') }}
    {{ HTML::style('css/jquery-ui.structure.css') }}
    {{ HTML::style('css/jquery.fancybox.css') }}
    {{ HTML::style('css/jquery-ui.theme.css') }}
    {{ HTML::style("css/font-awesome.min.css"); }}
    {{ HTML::style('css/dropzone.css') }}
    {{ HTML::style('css/admin.css') }}
    {{ HTML::style('css/chosen.css')}}
    {{ HTML::style('css/toastr.css') }}
    {{ HTML::script('js/jquery-1.11.1.js') }}
    {{ HTML::script('js/jquery-ui.js') }}
    {{ HTML::script('js/ckeditor/ckeditor.js') }}
    {{ HTML::script('js/jquery.fancybox.js') }}

    @section('stylesheets')
    @show

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
                <p> 
                    @if( Review::whereViewed(0)->count() >= 1 )
                        <a href="{{ URL::route('admin.reviews.index')}}">{{ 'You have '. Review::whereViewed(0)->count() .' new notification(s)'}}</a>
                    @else

                        <a style="display:none" href="{{ URL::route('admin.reviews.index')}}"></a>

                    @endif                   
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
                               
                    <li><a href="{{ URL::route('admin.games.index') }}"><i class="fa fa-gamepad"></i> Games</a></li>            
                    <li><a href="{{ URL::route('admin.reports.index') }}"><i class="fa fa-file-text-o"></i> Reports</a></li>

                @elseif(Auth::user()->role == 'editor') 
                   
                    <li><a href="{{ URL::route('admin.news.index') }}"><i class="fa fa-newspaper-o"></i> News</a></li>

                @else
                    <li><a href="{{ URL::route('admin.users.index') }}"><i class="fa fa-user"></i> Users</a></li>                
                    <li><a href="{{ URL::route('admin.games.index') }}"><i class="fa fa-gamepad"></i> Games</a></li>      
                    <li><a href="{{ URL::route('admin.reports.index') }}"><i class="fa fa-file-text-o"></i> Reports</a></li>   
                    <li><a href="{{ URL::route('admin.reports.inquiries') }}"><i class="fa fa-envelope"></i> Inquiries</a></li>         
                    <li><a href="{{ URL::route('admin.news.index') }}"><i class="fa fa-newspaper-o"></i> News</a></li>         
                    <li><a href="{{ URL::route('admin.faqs.index') }}"><i class="fa fa-question-circle"></i> FAQ</a></li>            
                    <li><a href="{{ URL::route('admin.featured') }}"><i class="fa fa-cogs"></i> Settings</a></li>
                @endif

            </ul>
        </nav>
    @endif

    <main>
        @yield('content')
    </main>

    <div class="clear"></div>

   <!--  <footer>
        
    </footer> -->

@yield('scripts')
    <script>
        $( "#options-link" ).click(function(e) {
            e.preventDefault();
            $( "#site-options" ).toggle( "fast", function() {

            });
        });
    </script>
</body>
</html>
