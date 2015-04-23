@extends('_layouts/single')
@section('stylesheets')
	<style>
		.name h1 {padding: 0 0 10px 0 !important;}
		#profile .details > div {
		  margin-bottom: 3px !important;
		}
	</style>
@stop
@section('content')

	<div class="container">
		<div class="relative">
			<div class="thumb">
				<img src="{{ Request::root() }}/images/avatars/{{ Auth::user()->prof_pic }}.jpg">
			</div>

			<div class="details">
				<div class="name"><h1 class="title">{{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}}</h1></div>
				<div class="email">{{{ Auth::user()->email }}}</div>
				<div class="change_password"><a href="{{ route('password.change') }}">{{ trans('global.Change Password') }}</a></div>
			</div>
		</div>
	</div>

	<div id="downloads">
		<div class="container">
			<h1 class="title">{{ trans('global.Downloaded games') }}</h1>

			<div id="token">{{ Form::token() }}</div>

			<div class="grid">
				<div class="row">
					<div class="clearfix">

						@foreach ($games as $game)
							<div class="item">
								<div class="image"><img src="{{ Request::root() . '/images/games/thumb-' . $game->slug . '.jpg' }}" alt="{{ $game->main_title }}"></div>

								<div class="meta">
									<p>{{ $game->main_title }}</p>
									<!-- <p>P{{-- $game->default_price --}}.00</p> -->
								</div>

								<!-- <div class="button"><a href="#">{{-- trans('global.Buy') --}}</a></div> -->
							</div>

						@endforeach

					</div>
				</div>
			</div>

			<div id="loadmore" class="button center"><a href="#">{{ trans('global.More') }} +</a></div>
		</div>
	</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}
	
	@include('_partials/scripts')

	<script>
		FastClick.attach(document.body);

	</script>
@stop
