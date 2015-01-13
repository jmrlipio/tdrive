@extends('_layouts/listing')

@section('stylesheets')
@stop

@section('content')

	<div class="container">

		<h1 class="title">{{{ $title }}}</h1>

		<div id="scroll" class="clearfix">

			<div id="token">{{ Form::token() }}</div>

			@foreach ($news as $item)
				@foreach ($item->contents as $content)

					<div class="item">
						<div class="date">
							<div class="vhparent">
								<p class="vhcenter">{{ Carbon::parse($item->created_at)->format('M j') }}</p>
							</div>	
						</div>	

						<div class="details">
							<div class="vparent">
								<div class="vcenter">
									<h3>{{{ $item->main_title }}}</h3>
									<p>{{{ $content->pivot->excerpt }}}</p>
								</div>	
							</div>
						</div>	

						<div class="readmore">
							<a href="{{ '/news/'. $item->id }}">
								<div class="vhcenter"><i class="fa fa-angle-right"></i></div>
							</a>
						</div>
					</div>

				@endforeach
			@endforeach

		</div>

		<div class="ajax-loader center"><i class="fa fa-cog fa-spin"></i> loading&hellip;</div>
	</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}

	<script>
		FastClick.attach(document.body);

		var load = 0;
		var _token = $('#token input').val();
		var num = {{ $count }};
		var year = "{{ $title }}";

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

		$(window).scroll(function() {
			$('.ajax-loader').show();

			load++;

			if (load * 3 > num) {
				$('.ajax-loader').hide();
			} else {

				$.ajax({
					url: "{{ url() }}/year/more",
					type: "POST",
					data: {
						load: load,
						year: year,
						_token: _token
					},
					success: function(data) {
						$('#scroll').append(data);
						$('.ajax-loader').hide();
					}
				});

			}
		});
	</script>
@stop
