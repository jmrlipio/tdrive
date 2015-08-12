@extends('_layouts/listing')

@section('stylesheets')
<style>
	#select-year {
			background: url(../images/dropdown.png) #fff no-repeat right;
			background-size: 20.5% 100%;
			-webkit-appearance: none;
			-moz-appearance: none;
			margin: 18px 0 10px;
			float: right;
			font-size: 14px;
			width: 130px;
			padding: 5px 0;
		}
	.title {float: left !important;}
</style>
@stop

@section('content')

	<div class="container">
		<h1 class="title">{{ trans('global.Latest news') }}</h1>
		
		{{Form::open(array('id'=>'year'))}}
			
			<span id="custom-dd">	
				{{ Form::select('year', array('default' => trans('global.Please select')) + $year, 'default', array('class' => 'select-year', 'id' => 'select-year')) }}
			</span>
			
		{{Form::close()}}

		<div id="token">{{ Form::token() }}</div>

		<div id="scroll">		
			@foreach ($live_news as $item)

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
	<script>
	/*$( document ).ready(function() {
		$('#select-year').change(function() {
			var id = $(this).val();
			if(id == 'default'){
				window.location.reload(true);
			}
			window.location.href = "news/year/"+id;
		});
	});*/
	$(window).load(function() {
		$('#year').change(function() {
			var year = $(this).find('select').val();

			$(this).attr('action', 'news/year/' + year);
			$(this).submit();
		});
	});
	</script>
@stop
