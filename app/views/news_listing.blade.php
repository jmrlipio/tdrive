@extends('_layouts/listing')

@section('stylesheets')
@stop

@section('content')

	<div class="container">
		<h1 class="title">{{ trans('global.Latest news') }}</h1>

		<div id="token">{{ Form::token() }}</div>

		<div id="scroll">

			@foreach ($live_news as $item)
				@foreach ($item->contents as $content)

					<div class="item">
						<a class="news_link" href="{{ '/news/'. $item->id }}">
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
						</a>

						<div class="readmore">
							<a href="{{ '/news/'. $item->id }}">
								<div class="vhcenter"><i class="fa fa-angle-right"></i></div>
							</a>
						</div>
					</div>

				@endforeach
			@endforeach

		</div>

		<div class="ajax-loader center"><i class="fa fa-cog fa-spin"></i> {{ trans('global.loading') }}&hellip;</div>
	</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}
	
	@include('_partials/scripts')

	<script>
		FastClick.attach(document.body);

		var token = $('#token input').val();
		var load = 0;
		var num = {{ $count }};

		$(window).scroll(function() {
			$('.ajax-loader').show();

			load++;

			if (load * 6 > num) {
				$('.ajax-loader').hide();
			} else {

				$.ajax({
					url: "{{ url() }}/news/more",
					type: "POST",
					data: {
						load: load,
						_token: token
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
