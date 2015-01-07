@extends('_layouts/listing')

@section('stylesheets')
@stop

@section('content')

	<div class="container">
		<h1 class="title">New and updated games</h1>

		<div id="token">{{ Form::token() }}</div>

		<div class="grid">
			<div class="row">
				<div class="clearfix">

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

		<div class="center">
			{{ $games->links() }}
		</div>

	</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}

	<script>
		FastClick.attach(document.body);
	</script>
@stop
