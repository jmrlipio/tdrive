@extends('_layouts/single')

@section('content')

	<div class="container">
		<h3 class="title">All reviews for {{{ $game->main_title }}}</h3>
	</div>

	<div id="token">{{ Form::token() }}</div>

	<div id="scroll" class="container">
		<div class="entry clearfix">
			{{ HTML::image('images/avatars/jaypee-onza.jpg', 'Jaypee Onza') }}
			
			<div>
				<p class="name">Jaypee Onza</p>

				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<p class="date">August 8, 2014</p>

				<p class="message">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
			</div>
		</div>

		<div class="entry clearfix">
			{{ HTML::image('images/avatars/julius-caluminga.jpg', 'Julius Caluminga') }}
			
			<div>
				<p class="name">Julius Caluminga</p>

				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<p class="date">August 8, 2014</p>

				<p class="message">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>

		<div class="entry clearfix">
			{{ HTML::image('images/avatars/michelle-yang.jpg', 'Michelle Yang') }}
			
			<div>
				<p class="name">Michelle Yang</p>

				<div class="stars">
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
					<a href="#"><i class="fa fa-star"></i></a>
				</div>

				<p class="date">August 8, 2014</p>

				<p class="message">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>
	</div>

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
