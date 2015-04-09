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
					<h4 style="margin: 10px 0;">{{ trans('global.Share the game to the following social networks.') }}</h4>
					<a style="margin:0 2px;" href="http://www.facebook.com/sharer/sharer.php?s=100&amp;p[url]={{ url() }}/news/{{ $news->id }}" data-social='{"type":"facebook", "url":"{{ url() }}/news/{{ $news->id }}", "text": "{{ $news->slug }}"}'>
						{{ HTML::image('images/icon-social-facebook.png', 'Share', array('class' => 'auto')) }}
					</a>
					<a style="margin:0 2px;" href="https://twitter.com/share?url={{ url() }}/news/{{ $news->id }}" data-social='{"type":"twitter", "url":"{{ url() }}/news/{{ $news->id }}", "text": "{{ $news->slug }}"}'>
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

	<script>
		FastClick.attach(document.body);

		var token = $('input[name="_token"]').val();

		$('#polyglotLanguageSwitcher1').polyglotLanguageSwitcher1({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',
			testMode: true,
			onChange: function(evt){
				$.ajax({
					url: "{{ URL::route('choose_language') }}",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: token
					},
					success: function(data) {
						location.reload();
					}
				});
			}
		});

		$('#polyglotLanguageSwitcher2').polyglotLanguageSwitcher2({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',
			testMode: true,
			onChange: function(evt){
				$.ajax({
					url: "{{ URL::route('choose_language') }}",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: token
					},
					success: function(data) {
					    location.reload();
					}
				});
			}
		});

		$("#inline").fancybox({
            'titlePosition'     : 'inside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none'
        });

        $("#share a").jqSocialSharer();

        $('.fancybox').fancybox({ padding: 0 });
	</script>
@stop
