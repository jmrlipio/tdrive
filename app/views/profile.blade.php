@extends('_layouts/single')
@section('stylesheets')

	<style>
		.name h1 {padding: 0 0 10px 0 !important;}
		#profile .details > div {
		 	margin-bottom: 3px !important;
		}
		input[type="submit"] {
		  background: #e9548e;
		  color: #fff;
		  padding: 4px 6px;
		  text-transform: lowercase;
		}

	</style>
@stop
@section('content')

	<div class="container">
		<div class="relative">
			<div class="thumb">
				@if(Auth::user()->prof_pic != '')
					<img src="{{ Request::root() }}/images/avatars/{{ Auth::user()->prof_pic }}" id="profile_img">
				@else
					<img src="{{ Request::root() }}/images/avatars/placeholder.jpg" id="profile_img">
				@endif
			</div>

			<div class="details">
				<div class="name"><h1 class="title">{{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}}</h1></div>
				<div class="email">{{{ Auth::user()->email }}}</div>
				<div class="change_password"><a href="{{ route('password.change') }}">{{ trans('global.Change Password') }}</a>
				{{ Form::open(array('route' => array('user.profile.change', Auth::user()->id), 'method' => 'post', 'files' => true, 'id' => 'update-media')) }}
				
					<!-- <input type="image" id="img_url" name="profile_pic"> -->
					 {{ Form::file('image', array('onchange' => 'readURL(this);', 'required')) }}
				
					{{ Form::submit("Save", array("id" => "save-image")) }}
				{{ Form::close()}}
				</div>
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

	function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#profile_img').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}


	</script>

	<script>

	/*$(document).ready(function() {

		$('#img_url').change(function() {
			$('#img_url').after(' <br><br>{{ Form::submit("Save", array("id" => "save-image")) }}');
	     
	    });
			
	});*/

	</script>
@stop
