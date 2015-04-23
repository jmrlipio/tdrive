@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style("css/form.css"); }}
@stop

@section('content')

	@if (Session::has('success') ) 
            
        <h3 class="center flash-success">{{ Session::get('success') }}</h3> 

    @elseif(Session::has('fail') )   

    	<h3 class="center flash-fail">{{ Session::get('fail') }}</h3>    

    @endif
                         
	<h3 class="title center">{{ trans('global.Sign In') }}</h3>

	{{ Form::open(array('route' => 'login.post', 'class' => 'login', 'id' => 'login-form')) }}

		<div id="token">{{ Form::token() }}</div>

		<div class="control">
			{{ Form::text('username', null, array('placeholder'=>trans('global.username'))) }}                   
		</div>

		<div class="control">
			{{ Form::password('password', array('placeholder'=>trans('global.password'))) }}                    
		</div>
		<input type="hidden" value="{{ Input::get('url') }}" name="url" />
		<div class="control-group clearfix">
			<!-- <div class="control-item fl">
				{{-- Form::checkbox('remember', 1 , null, ['id'=>'remember']); --}}
				 <label for="remember">Remember me</label>
			</div> -->

			<div class="control-item fr">
				 {{ Form::submit(trans('global.login')) }}
			</div>
		</div>

		{{ Form::close() }}

	<div class="button">
		<a href="{{ route('password.remind') }}">{{ trans('global.Forgot your password?') }}</a>
	</div>

	<br>

	<div class="center">
		<h3>{{ trans('global.Not yet a member?') }} <a href="{{ route('users.register') }}" class="link">{{ trans('global.Register') }}</a></h3>
	</div>

@stop

@section('javascripts')

	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}

	<script>
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
