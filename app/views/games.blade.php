@extends('_layouts/listing')

@section('stylesheets')
@stop

@section('content')

	<div class="container">
		<h1 class="title">New and updated games</h1>

		<div id="token">{{ Form::token() }}</div>

		<div class="grid">
			<div class="row">
				<div id="scroll" class="clearfix">

					@foreach ($games as $game)

						<div class="item">
							<div class="thumb relative">
								@if ($game->default_price == 0)
									{{ HTML::image('images/ribbon.png', 'Free', array('class' => 'free auto')) }}
								@endif

								<img src="images/games/thumb-{{ $game->slug }}.jpg" alt="{{ $game->main_title }}">
							</div>

							<div class="meta">
								<p>{{ $game->main_title }}</p>

								@unless ($game->default_price == 0)
									<p class="price">P{{{ $game->default_price }}}.00</p>
								@endunless
							</div>

							@if ($game->default_price == 0)
								<div class="button center"><a href="#">Get</a></div>
							@else
								<div class="button center"><a href="#">Buy</a></div>
							@endif
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

		$(window).scroll(function() {
			$('.ajax-loader').show();

			load++;

			if (load * 3 > num) {
				$('.ajax-loader').hide();
			} else {

				$.ajax({
					url: "games/all/more",
					type: "POST",
					data: {
						load: load,
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
