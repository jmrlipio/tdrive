@extends('_layouts.default')
@section('content')

<div id="sb-site">
    <div class="content-main">
        <div class="container">
            <h2>Game page</h2>
        </div>

        <div class="mobile">
            <div class="sb-slidebar sb-left">

                <nav class="nav-main">
                    <ul class="first">
                        <div class="clearfix">
                            <li><a href="{{ route('users.login') }}" class="sign-in">Sign In</a></li>
                            <li><a href="{{ route('users.signup') }}" class="join-now">Join Now</a></li>
                        </div>
                    </ul>
                    
                    <form action="#" method="post" class="search clearfix">
                        <input type="text" name="search" placeholder="search game...">
                        <input type="submit" value="Go">
                    </form>

                    <form action="#" method="post" class="language">
                        <select name="language">
                            <option value="">select language...</option>
                            <option value="singtel (english)">singtel (english)</option>
                        </select>
                    </form>
                    
                    <ul class="second">
                        <li><a href="#" class="games">Games</a></li>
                        <li><a href="#" class="news">News</a></li>
                        <li><a href="#" class="faqs">FAQs</a></li>
                        <li><a href="#" class="contact">Contact</a></li>
                    </ul>

                    <ul class="social">
                        <li><a href="#" class="facebook">Facebook</a></li>
                        <li><a href="#" class="twitter">Twitter</a></li>
                        <li><a href="#" class="support">support@tdrive.co</a></li>
                    </ul>

                    <div class="copyright">
                        <p>Japan &#124; Philippines</p>
                        <p>Copyright &copy; 2014 TDrive.</p>
                        <p>All rights reserved.</p>
                    </div>
                </nav>

            </div>
        </div>


        <div class="container">
            <div id="container-scroll">
                <div class="column-three mobile">
                    <div class="row clearfix">
                        <?php $count = 0; ?>
                            @foreach($games as $game)                             
                                
                                <div>
                                    <a href="#"><img src="{{ $thumbnails[$count] }}" class="border-radius" alt="{{ $game->title }}"></a>
                                    <p class="description">{{ $game->title }} <span class="price"> (P {{ $game->default_price }}) </span></p>
                                </div> 
                                <?php $count++; ?> 
                            @endforeach
                    </div>
                        
                </div>
                
                <div class="column-four tablet">                
                    <div class="row clearfix">
                        <?php $count = 0; ?>
                            @foreach($games as $game)                             
                                
                                <div>
                                    <a href="#"><img src="{{ $thumbnails[$count] }}" class="border-radius" alt="{{ $game->title }}"></a>
                                    <p class="description">{{ $game->title }} <span class="price"> (P {{ $game->default_price }}) </span></p>
                                </div> 
                                <?php $count++; ?> 
                            @endforeach
                    </div>
                </div> 
            </div>
        </div>

        <div id="ajax-loader" class="center" style="display: none;">
            {{ HTML::image('images/ajax-loader.gif') }}
        </div>

        <div class="tablet clearfix"><a href="#" id="more">More +</a></div>
       

    </div>
</div>

@stop