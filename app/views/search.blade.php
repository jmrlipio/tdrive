@extends('_layouts/listing')

@section('stylesheets')
@stop

@section('content')

	<div class="container">
		<h1 class="title">Search results</h1>

		<div id="token">{{ Form::token() }}</div>

		<div class="grid">
			<div class="row">
				<div id="scroll" class="clearfix">

					@foreach ($games as $game)

						<div class="item">
							<div class="thumb"><img src="images/games/thumb-{{ $game->slug }}.jpg" alt="{{ $game->main_title }}"></div>

							<div class="meta">
								<p>{{ $game->main_title }}</p>
								<p>P{{ $game->default_price }}.00</p>
							</div>

							<div class="button"><a href="#">Buy</a></div>
						</div>

					@endforeach

				</div>
			</div>
		</div>

		<div class="ajax-loader center"><i class="fa fa-cog fa-spin"></i> loading&hellip;</div>

	</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}

	<script>
		FastClick.attach(document.body);

		var load = 0;
		var _token = $('#token input').val();
		var num = {{ $count }};
		var search = "{{ Input::get('search') }}";

		$(window).scroll(function() {
			$('.ajax-loader').show();

			load++;

			if (load * 3 > num) {
				$('.ajax-loader').hide();
			} else {

				$.ajax({
					url: "search/more",
					type: "POST",
					data: {
						load: load,
						_token: _token,
						search: search
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
