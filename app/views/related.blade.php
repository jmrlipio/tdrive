@extends('_layouts/listing')

@section('stylesheets')
<style>
	
	.discounted { text-decoration: line-through; }

</style>
@stop

@section('content')

	<div class="container">

		<h1 class="title">{{ trans('global.Related games for ') }} {{ $game->main_title; }}</h1>

		<div id="token">{{ Form::token() }}</div>

		<div class="grid">
			<div class="row">
				<div id="scroll" class="clearfix">
					<?php $count = 0; ?>
					@foreach ($related_games as $game)
						@foreach($game->apps as $app)
							<?php $iso_code = ''; ?>
							@foreach($languages as $language)
								@if($language->id == $app->pivot->language_id)
									<?php $iso_code = strtolower($language->iso_code); ?>
								@endif
							@endforeach
							<input type="hidden" class="game-id" value="{{ $game->id }}">
							@if($iso_code == Session::get('locale') && $app->pivot->carrier_id == Session::get('carrier') && $app->pivot->status == Constant::PUBLISH && $game_id != $game->id)									
								<?php $count++; ?>
								<div class="swiper-slide item">
									@include('_partials/game-thumb')
								</div>		
							@endif						
						@endforeach
					@endforeach
					@if($count == 0)
						<div class="swiper-slide item">
							<p>{{ trans('global.No related games.') }}</p>
						</div>	
					@endif
				</div>
			</div>
		</div>

		<div class="ajax-loader center"><i class="fa fa-cog fa-spin"></i> loading&hellip;</div>

	</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}
	
	@include('_partials/scripts')

	<script>
		FastClick.attach(document.body);

		var num = {{ $count }};
		var game_id = {{ $game_id }};
		var ids = [];
		var token = $('input[name="_token"]').val();

		var finished=1;
		$(window).scroll(function() {
		// $(document).on("scrollstart",function(){	
			$('.ajax-loader').show();
			
			var load = $('.item').length;

			$('.game-id').each(function() {
				ids.push($(this).val());
			});

			// alert(load);

			// if (load / 6 > num) {
			// 	$('.ajax-loader').hide();
			// } else {
			if ($(window).scrollTop() >= parseInt($(document).height() - $(window).height() - 150)) {   
				 if (finished == 1) {
              		finished = 0;   

					$.ajax({
						// url: "{{ url() }}/games/related/more",
						url: "{{ URL::route('games.related.more', array('id' => $game_id)) }}",
						type: "POST",
						data: {
							load: load,
							ids: ids,
							_token: token
						},
						success: function(data) {
							$('#scroll').append(data);
							$('.ajax-loader').hide();
							finished = 1;
						}
					}); // End of ajax call
				} // End of inner condition
			 } // End of first condition
		});
	</script>
@stop
