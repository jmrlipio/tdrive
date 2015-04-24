@extends('_layouts/listing')

@section('stylesheets')
@stop

@section('content')
	<div class="container">
		<h1 class="title">{{ trans('global.All Categories') }}</h1>
		<div class="clear"></div>	
		<div id="token">{{ Form::token() }}</div>
		<div class="grid">
			<div class="row">
				<div id="scroll" class="clearfix">

					@foreach ($games as $game)												
						@foreach($game->apps as $app)
							<?php $iso_code = ''; ?>
							@foreach($languages as $language)
								@if($language->id == $app->pivot->language_id)
									<?php $iso_code = strtolower($language->iso_code); ?>
								@endif
							@endforeach
							
							@if($app->pivot->status != Constant::PUBLISH)
								<?php continue; ?>
							@endif	

							@if($iso_code == Session::get('locale') && $app->pivot->carrier_id == Session::get('carrier'))
								<div class="item">
									@include('_partials/game-thumb')
								</div>
							@endif
						@endforeach
					@endforeach

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

		var load = 0;
		var num = {{ $count }};
		var page = {{ $page }};
		var token = $('input[name="_token"]').val();

		$(window).scroll(function() {
			var bottom = 50;
				if ($(window).scrollTop() + $(window).height() > $(document).height() - bottom) 
				{
					$.ajax({
						url: "{{ url() }}/games/all/more",
						type: "POST",
						data: {
							page: page,
							_token: token
						},
						success: function(data) {
							console.log(data);
							page++;
							$('#scroll').append(data);
							$('.ajax-loader').hide();
						}
					});
				}
			});
	</script>
@stop
