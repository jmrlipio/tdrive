@extends('_layouts/listing')

@section('content')

	<div class="container">

		<h1 class="title">{{{ $title }}}</h1>

		<div id="scroll" class="clearfix">

			<div id="token">{{ Form::token() }}</div>

			@foreach ($news as $item)

				@foreach($item->languages as $content)
					<?php $iso_code = ''; ?>
					@foreach($languages as $language)
						@if($language->id == $content->pivot->language_id)
							<?php $iso_code = strtolower($language->iso_code); ?>
						@endif
					@endforeach

					@if($iso_code == Session::get('locale'))

					<div class="item">
						<a class="news_link" href="{{ '/news/'. $item->id }}">
							<div class="date">
								<div class="vhparent">
									<?php 
										$date = Carbon::parse($item->created_at)->format('M');						
										?>
									<p class="vhcenter">{{  trans('global.'.str_limit($date, $limit = 3, $end = '...')).' '.Carbon::parse($item->created_at)->format('j')}}</p>
								</div>	
							</div>	

							<div class="details">
								<div class="vparent">
									<div class="vcenter">
										<h3>{{ $content->pivot->title }}</h3>
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
					@endif

				@endforeach
			@endforeach

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

		var token = $('#token input').val();
		var load = 0;
		var num = {{ $count }};
		var year = "{{ $title }}";

		$(window).scroll(function() {
			$('.ajax-loader').show();

			load++;

			if (load * 6 > num) {
				$('.ajax-loader').hide();
			} else {

				$.ajax({
					url: "{{ url() }}/year/more",
					type: "POST",
					data: {
						load: load,
						year: year,
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
