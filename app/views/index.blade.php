@extends('_layouts.default')
@section('content')

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
                <div class="column-three mobile">
                    <div class="row clearfix" >
                        <?php $ctr = 0; ?>
                            @foreach($games as $game)                             
                                
                                <div>
                                    <a href="#"><img src="{{ $thumbnails[$ctr] }}" class="border-radius" alt="{{ $game->title }}"></a>
                                    <p class="description">{{ $game->title }} <span class="price"> (P {{ $game->default_price }}) </span></p>
                                </div> 
                                <?php $ctr++; ?> 
                            @endforeach
                    </div>
                        
                </div>
                
                <div class="column-four tablet">                
                    <div class="row clearfix" id="games">
                        <?php $ctr = 0; ?>
                            @foreach($games as $game)                             
                                <?php if($ctr <= 7) { ?>
                                <div>
                                    <a href="#"><img src="{{ $thumbnails[$ctr] }}" class="border-radius" alt="{{ $game->title }}"></a>
                                    <p class="description">{{ $game->title }} <span class="price"> (P {{ $game->default_price }}) </span></p>
                                </div> 
                                <?php $ctr++; ?> 
                                <?php } ?>
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

{{ HTML::script('js/slidebars.js') }}
{{ HTML::script('js/jquery.lightSlider.min.js') }}
<script>
var ctr = <?php echo $ctr; ?>;
var root = '<?php echo $root; ?>';

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

        /*if ($(this).is(':visible')) {

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

        } else {*/

            // $('#more').on('click', function(e) {
            //     e.preventDefault();
            //     $('#ajax-loader').show();

            //     $.get({
            //         url: 'thumbnails.php',

            //         success: function(html) {
            //             if (html) {
            //                 $('#container-scroll').append(html);
            //                 $('#ajax-loader').hide();
            //             } else {
            //                 $('#ajax-loader').html('<p class="center">No more games to show.</p>');
            //             }
            //         }
            //     });
            // });


           

        //}

    });

    var gamediv = $('#games');
    var num=0;  
    
    $('#more').on('click', function(e) {
        e.preventDefault();
        $.get("{{ URL::route('games.load') }}", function(data) {  
            var myArray = jQuery.parseJSON(data);  
            var cctr = 0;
            for(var id in myArray) {
                var img_url;  

                if(cctr >= ctr) {
                   
                        if (myArray.hasOwnProperty(id)) {
                            num++;
                        } //console.log(num);
                        //var val = num%4;
                        //console.log(num);
                        if (num == 5){
                            //console.log(myArray[id]);
                            break;
                        } 

                    for(var i = 0; i < myArray[id].media.length; i++) {                      
                        if(myArray[id].media[i]['pivot']['type'] == 'featured') {
                            img_url = myArray[id].media[i]['url'];
                        }                      
                    }
                    
                    var game = $('<div> \
                                    <a href="#"><img src="' + root + img_url +'" class="border-radius" alt="' + myArray[id]['title'] +'"></a> \
                                    <p class="description">' + myArray[id]['title'] +'<span class="price"> (P '+myArray[id]['default_price'] +')</span></p> \
                                </div>').hide();

                    gamediv.append(game);
                    game.show('slow');
                   /* gamediv.fadeIn('slow');*/

                }               
                cctr++;            
            }
            ctr = cctr;
        });
    });

                    
});
</script>
@stop