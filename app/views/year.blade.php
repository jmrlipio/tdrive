@extends('_layouts/listing')

@section('stylesheets')
@stop

@section('content')

	<div class="container">

		<h1 class="title">{{{ $title }}}</h1>

		<div id="scroll" class="clearfix">

			<div id="token">{{ Form::token() }}</div>

			<div id="scroll">

				@foreach ($news as $item)
					@foreach ($item->contents as $content)

						<div class="item">
							<div class="date">
								<div class="vhparent">
									<p class="vhcenter">{{ Carbon::parse($item->release_date)->format('M j') }}</p>
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
								<div>
									<a href="{{ 'news/'. $item->id }}" class="vhcenter"><i class="fa fa-angle-right"></i></a>
								</div>
							</div>
						</div>

					@endforeach
				@endforeach

			</div>

		</div>

		<div class="ajax-loader center"><i class="fa fa-cog fa-spin"></i> loading&hellip;</div>
		<div id="loadmore" class="button center"><a href="#">More +</a></div>
		<div id="end" class="center"></div>
	</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}

	<script>
		FastClick.attach(document.body);

		var load = 0;
		var _token = $('#token input').val();
		var num = {{ $count }};

		$('#loadmore').click(function(e) {
			e.preventDefault();
			$('.ajax-loader').show();

			load++;

			if (load * 3 > num) {
				$('#end').html('<p>End of Result</p>');
				$('.ajax-loader').hide();
				$('#loadmore').hide();
			} else {
				$.post("/news/more/" + {{ $title }}, { load: load, _token: _token }, function(data) {
					$('#scroll').append(data);
					$('.ajax-loader').hide();
				});
			}
		});
	</script>
@stop
