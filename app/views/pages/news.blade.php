@extends('_layouts.default')
@section('content')

<div id="sb-site">

    <div class="content-main">

        <div class="container">
            <h2>News page</h2>
        </div>

        <div class="container">
            <div id="container-scroll"> 
	            <div class="column-three mobile">
                    <div class="row clearfix">
                        <?php $ctr = 0; ?>
                            @foreach($news_article as $news)                             
                                
                                <div>
                                    <a href="#"><img src="{{ $thumbnails[$ctr] }}" class="border-radius" alt="{{ $news->title }}"></a>
                                    <p class="description">{{ $news->title }}</p>
                                </div> 
                                <?php $ctr++; ?>                             
                            @endforeach
                    </div>	                        
	            </div>              
                
                <div class="column-four tablet">                
                    <div class="row clearfix">
                        <?php $ctr = 0; ?>
                            @foreach($news_article as $news)                             
                                
                                <div>
                                    <a href="#"><img src="{{ $thumbnails[$ctr] }}" class="border-radius" alt="{{ $news->title }}"></a>
                                    <p class="description">{{ $news->title }}</p>
                                </div> 
                                <?php $ctr++; ?> 
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