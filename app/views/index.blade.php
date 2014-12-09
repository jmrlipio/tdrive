@extends('_layouts.default')
@section('content')


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

<div id="sb-site">

    <div class="content-main">

        <ul id="slider-main" class="content-slider">

            <li class="slider-item">
                {{ HTML::image('images/slider/lode-runner.jpg', 'Lode Runner') }}

                <div class="details clearfix">
                    <p class="date">13 <span>Nov</span></p>
                    <p class="description">Lode Runner is Back!</p>
                    <p class="go"><a href="#">&raquo;</a></p>
                </div>
            </li>

           <li class="slider-item">
              {{ HTML::image('images/slider/lode-runner.jpg', 'Lode Runner') }}
           
               <div class="details clearfix">
                   <p class="date">25 <span>Dec</span></p>
                   <p class="description">Lode Runner is Back to Back!</p>
                   <p class="go"><a href="#">&raquo;</a></p>
               </div>
           </li>

        </ul>

        <div class="container">
            <h2>New and updated games</h2>
        </div>

        <div class="container">

            <div id="container-scroll">
                @include('_partials.game_thumbnails'); 
            </div>

        </div>

        <div id="ajax-loader" class="center" style="display: none;">
            {{ HTML::image('images/ajax-loader.gif') }}
        </div>

        <div class="tablet clearfix"><a href="#" id="more">More +</a></div>
        <div class="tablet">
            <footer class="footer-main clearfix">
                <ul>
                    <li class="support"><span></span><a href="#">support@tdrive.co</a></li>
                    <li><a href="#" class="facebook">Facebook</a></li>
                    <li><a href="#" class="twitter">Twitter</a></li>
                </ul>
                
                <p>Japan | Philippines</p>
                <p>Copyright &copy; 2014. TDrive | All Rights Reserved.</p>
            <footer>
        </div>

    </div>
</div>

{{ HTML::script('js/slidebars.js') }}
{{ HTML::script('js/jquery.lightSlider.min.js') }}
<script>
$(document).ready(function () {
    $("#slider-main").lightSlider({
        loop: true,
        item: 1,
        adaptiveHeight: true,
        slideMargin: 0,
        controls: true,
        pager: false
    });

    $.slidebars();

    $('.mobile').each(function() {

        if ($(this).is(':visible')) {

            $(window).scroll(function() {
                if ($(window).scrollTop() == $(document).height() - $(window).height()) {

                    $('#ajax-loader').show();

                    $.ajax({
                        url: 'thumbnails.php',

                        success: function(html) {
                            if (html) {
                                $('#container-scroll').append(html);
                                $('#ajax-loader').hide();
                            } else {
                                $('#ajax-loader').html('<p class="center">No more games to show.</p>');
                            }
                        }
                    });
                }

            });

        } else {

            $('#more').on('click', function(e) {
                e.preventDefault();
                $('#ajax-loader').show();

                $.ajax({
                    url: 'thumbnails.php',

                    success: function(html) {
                        if (html) {
                            $('#container-scroll').append(html);
                            $('#ajax-loader').hide();
                        } else {
                            $('#ajax-loader').html('<p class="center">No more games to show.</p>');
                        }
                    }
                });
            });

        }

    });
});
</script>
@stop