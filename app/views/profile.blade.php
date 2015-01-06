@extends('_layouts/single')

@section('content')

	<div class="container">
		<div class="relative">
			<div class="thumb">
				<img src="/images/avatars/placeholder.jpg">
			</div>

			<div class="details">
				<div class="name">{{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}}</div>
				<div class="email">{{{ Auth::user()->email }}}</div>
				<div class="change_password"><a href="#">Change Password</a></div>
			</div>
		</div>
	</div>

	<div id="downloads">
		<div class="container">
			<h1 class="title">Downloaded games</h1>

			<div class="grid">
				<div class="row">
					<div class="clearfix">

						@foreach ($games as $game)

							<div class="item">
								<div class="image"><img src="/images/games/thumb-{{ $game->slug }}.jpg" alt="{{ $game->main_title }}"></div>

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

			<div id="loadmore" class="button center"><a href="#">More +</a></div>
		</div>
	</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}

	<script>
		FastClick.attach(document.body);
	</script>
@stop
