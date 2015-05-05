@extends('_layouts/single')

@section('stylesheets')
	{{ HTML::style("css/jquery.fancybox.css"); }}
@stop

@section('content')

	<div id="featured" class="container">
		{{ HTML::image('assets/news/' . $news->featured_image, $news->main_title) }}
	</div>

	<div id="token">{{ Form::token() }}</div>

	<div class="container">
		<div class="details">
			<div class="date">
				<div class="vhparent">
					<p class="vhcenter">{{ Carbon::parse($news->created_at)->format('M j') }}</p>
				</div>
			</div>

			<div class="title">
				<div class="vparent">
					<h2 class="vcenter">
						
						@foreach($news->languages as $content)
							<?php $iso_code = ''; ?>
							@foreach($languages as $language)
								@if($language->id == $content->pivot->language_id)
									<?php $iso_code = strtolower($language->iso_code); ?>
								@endif
							@endforeach
							@if($iso_code == Session::get('locale'))
								{{ htmlspecialchars_decode($content->pivot->title) }}
							@endif
						@endforeach
					</h2>

				</div>
			</div>
		</div>

		<div class="description">

			@foreach($news->languages as $content)
				<?php $iso_code = ''; ?>
					@foreach($languages as $language)
						@if($language->id == $content->pivot->language_id)
							<?php $iso_code = strtolower($language->iso_code); ?>
						@endif
					@endforeach

					@if($iso_code == Session::get('locale'))
						{{ htmlspecialchars_decode($content->pivot->content) }}
					@endif	
			@endforeach

		</div>

		<div class="social clearfix">
			<div>
				<a href="#share" id="inline" class="share">{{ trans('global.Share') }}</a>
				<div href="#" class="like"> 
					<div id="news_like" class="fb-like" data-href="{{ url() }}/news/{{ $news->id }}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
				</div>
			</div>
			<div style="display:none">
				<div id="share" style="text-align:center;">
					<h4 style="margin: 10px 0;">{{ trans('global.Share the game to the following social networks') }}</h4>
					<a style="margin:0 2px;" href="#" data-social='{"type":"facebook", "url":"{{ url() }}/news/{{ $news->id }}", "text": "{{ $news->slug }}", "image": "http://www.tdrive.co/assets/news/1428396829_doraemon-gadget-series-ii.jpg"}'>
						{{ HTML::image('images/icon-social-facebook.png', 'Share', array('class' => 'auto')) }}
					</a>
					<a style="margin:0 2px;" href="https://twitter.com/share?url={{ url() }}/news/{{ $news->id }}" data-social='{"type":"twitter", "url":"{{ url() }}/news/{{ $news->id }}", "text": "{{ $news->main_title }}"}'>
						{{ HTML::image('images/icon-social-twitter.png', 'Share', array('class' => 'auto')) }}
					</a>
				</div>
			</div>
		</div>
	</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}
	{{ HTML::script("js/jquery.fancybox.js"); }}
	{{ HTML::script("js/jqSocialSharer.min.js"); }}
	<!-- facebook share function, cool right? -->
	{{ HTML::script("js/share.js"); }}

	@include('_partials/scripts')

	<script>
		$(document).ready(function() {
			
				$(document).fbshare({
					'OG_name' : '{{ $news->main_title }}',
					'OG_url' : '{{ url() }}',
					'OG_title' : '{{ $news->main_title }}',
					'OG_desc' : '{{ $news->slug }}',
					'OG_image' : '{{ URL::asset('assets/news/' . $news->featured_image) }}'

				});	
			
		});
	</script>	


	<script>
		FastClick.attach(document.body);
		var token = $('input[name="_token"]').val();
		
		$("#inline").fancybox({
            'titlePosition'     : 'inside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none'
        });

        $("#share a").jqSocialSharer();

        $('.fancybox').fancybox({ padding: 0 });
	</script>
@stop
