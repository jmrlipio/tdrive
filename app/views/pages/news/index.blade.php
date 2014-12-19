@extends('_layouts.news')
@section('content')

<div id="sb-site">

    <div class="content-main">

        <div class="container clearfix">
            <h1 class="fl">Latest News</h1>
               <!--  Form for loading news by its year. It should display news by its year -->
                 {{ Form::open(array('route' => 'news.year', 'class' => 'date fr', 'id' => 'submit-year', 'method' => 'get')) }} 
                    {{ Form::select('year', $years, $selected, array('class' => 'select-year', 'id' => 'select-year')) }}
                {{ Form::close() }}         
        </div>

        <div id="latest" class="container clearfix">
            <?php $ctr = 0; ?>
            @foreach($news_article as $news)  
            <?php
                
                $dateTime = $news->created_at;                     
                $dt = Carbon::parse($dateTime);
                setlocale(LC_TIME, '');
            ?>
                @if($ctr <= 1)
                    <article class="latest clearfix news-container">
                        <p class="date"><?php echo $dt->formatLocalized('%d'); ?> <span><?php echo $dt->formatLocalized('%b');?></span></p> 
                        <img src="{{ $thumbnails[$ctr] }}" alt="{{ $news->title }}">
                        <h3 class="title">{{ $news->title }}</h3>    
                        <p class="description">{{ Str::words($news->excerpt, 10) }}</p>                     
                  
                      <a href="{{ URL::to('news/show').'/'.$news->id }}" class="button readmore">Read more <i class="fa fa-angle-right"></i></a>                                            

                    </article>
                @endif
               <?php $ctr++; ?>
            @endforeach
        </div>

        <div class="container">
            
            @foreach($news_article as $news)    
 
                <article class="archive clearfix">                    
                        <?php
                            $dateTime = $news->created_at;                     
                            $dt = Carbon::parse($dateTime);
                            setlocale(LC_TIME, '');
                        ?>
                    <div class="date">
                        <p class="vhcenter"><?php echo $dt->formatLocalized('%d'); ?> <span><?php echo $dt->formatLocalized('%b');?></span></p> 
                    </div>

                    <div class="meta">
                        <div class="vcenter">
                            <h3 class="title">{{ $news->title }}</h3>    
                            <p class="description">{{ Str::words($news->excerpt, 10) }} </p>  
                        </div>
                    </div>

                    <div class="readmore">
                       <!-- form for navigating to single page of news -->
                        <a href="{{ URL::to('news/show').'/'.$news->id }}" class="vhcenter"><i class="fa fa-angle-right"></i></a>
                    </div>
                </article>
            @endforeach
        </div>

    </div>
</div>
@stop

@section('news-script')
<script>
    $('#select-year').on('change', function() {
        $('#submit-year').trigger('submit');
    });
</script>
@stop