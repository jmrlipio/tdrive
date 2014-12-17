@extends('_layouts.news')
@section('content')

<div id="sb-site">

    <div class="content-main">

       <div class="container nopadding">          
                    
            <?php
                $dateTime = $news_article->created_at;                     
                $dt = Carbon::parse($dateTime);
                setlocale(LC_TIME, '');
            ?>

             <img class="featured-image" src="{{ $thumbnails[0] }}" alt="{{ $news_article->title }}"> 
                <div class="meta clearfix">
                   <div class="date">
                        <p class="vhcenter"><?php echo $dt->formatLocalized('%d'); ?> <span><?php echo $dt->formatLocalized('%b');?></span></p> 
                    </div>

                    <div class="title">
                        <h3 class="vcenter">{{ $news_article->title }}</h3>
                    </div>
                </div>

                <div class="description">
                    <div class="content">
                        <p> 
                            {{ $news_article->content }}
                        </p>
                    </div>

                    <ul class="social clearfix">
                        <li><a href="#">Share</a></li>
                        <li><a href="#">Like</a></li>
                    </ul>
                </div>
        </div>

        <div class="container">
            <div class="tablet">
                <a href="#" class="button button-pink"><i class="fa fa-chevron-left"></i> Back</a>
            </div>
        </div>
        
    </div>
</div>
@stop
