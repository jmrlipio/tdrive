@extends('_layouts/single')

@section('content')

	<div class="container">
		<h3 class="title">All reviews for {{{ $game->main_title }}}</h3>
	</div>

	<div id="token">{{ Form::token() }}</div>

	<div id="scroll" class="container">
	
		@foreach($game->review as $data)
			<div class="entry clearfix">
				{{ HTML::image('images/avatars/placeholder.jpg', 'placeholder') }}

				{{-- dd($data->toArray())  --}}
				<div>
					<p class="name">{{ $data->first_name }}</p>

					<div class="stars">
						@for ($i=1; $i <= 5 ; $i++)
		                    <i class="fa fa-star{{ ($i <= $data->pivot->rating) ? '' : '-empty'}}"></i>
		                 @endfor    
					</div>

					<p class="date">{{  Carbon::parse($data->pivot->created_at)->format('M j') }}</p>

					<p class="message">{{{ $data->pivot->review }}}</p>
				</div>
			</div>

		@endforeach
	
@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}

	<script>
		FastClick.attach(document.body);

		var _token = $('#token input').val();

		$('#polyglotLanguageSwitcher1').polyglotLanguageSwitcher1({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',

			onChange: function(evt){

				$.ajax({
					url: "language",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: _token
					},
					success: function(data) {
					}
				});

				return true;
			}
		});

		$('#polyglotLanguageSwitcher2').polyglotLanguageSwitcher2({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',

			onChange: function(evt){

				$.ajax({
					url: "language",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: _token
					},
					success: function(data) {
					}
				});

				return true;
			}
		});
	</script>
@stop
