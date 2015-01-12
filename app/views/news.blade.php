@extends('_layouts/single')

@section('content')

	<div id="featured" class="container">
		{{ HTML::image('images/news/' . $news->slug . '.jpg', $news->main_title) }}
	</div>

	<div id="token">{{ Form::token() }}</div>

	<div class="container">
		<div class="details">
			<div class="date">
				<div class="vhparent">
					<p class="vhcenter">03 jul</p>
				</div>
			</div>

			<div class="title">
				<div class="vparent">
					<h2 class="vcenter">{{{ $news->main_title }}}</h2>
				</div>
			</div>
		</div>

		<div class="description">

			@foreach($news->contents as $item)
				{{ $item->pivot->content }}
			@endforeach

		</div>

		<div class="social clearfix">
			<div>
				<a href="#" class="share">Share</a>
				<a href="#" class="like">Like </a>
			</div>
		</div>
	</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}

	<script>
		FastClick.attach(document.body);

		var _token = $('#token input').val();

		$('#polyglotLanguageSwitcher1').polyglotLanguageSwitcher1({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',

			onChange: function(evt){

				$.ajax({
					url: "language",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: _token
					},
					success: function(data) {
					}
				});

				return true;
			}
		});

		$('#polyglotLanguageSwitcher2').polyglotLanguageSwitcher2({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',

			onChange: function(evt){

				$.ajax({
					url: "language",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: _token
					},
					success: function(data) {
					}
				});

				return true;
			}
		});
	</script>
@stop
