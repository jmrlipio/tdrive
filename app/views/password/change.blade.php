@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style("css/form.css"); }}
	<style>
		#btn_container{text-align: center;}

		#nav-toggle, #side-menu {
			display: none !important;
		}

		#back {
			display: block !important;
			margin-top: 12px !important;
		}

	</style>
@stop

@section('content')

	@if (Session::has('fail'))

	  <p class="flash-fail">{{ trans(Session::get('fail')) }}</p>

	@endif

	@if(Session::has('success'))

	  <h3 class="center flash-success">{{ Session::get('success') }}</h3>

	@endif

	<h3 class="center">{{ trans('global.Change password') }}</h3>
	 
	{{ Form::open(array('route' => 'password.request.change', 'class' => 'change-password', 'id' => 'register')) }} 
		<input type="hidden" name="id" value="{{Auth::User()->id}}">
		
		<div class="control"> 
			{{ Form::label('old_password', trans('global.old password')) }}      
			
			<input type="password" required name="old_password" class="form-control" minlength="8">
		</div> 

		<div class="control">   
			{{ Form::label('new password', trans('global.new password')) }} 			
			<input type="password" required name="new_password" class="form-control" id="new_password" minlength="8">
		</div>

		<div class="control">  
			{{ Form::label('confirm password', trans('global.confirm password')) }}     
			<input type="password" required name="confirm_password" class="form-control" id="confirm_password" minlength="8">
		</div>

		<div class="control-item" id="btn_container">
			 {{ Form::submit( trans('global.Change Password') ) }}
		</div>
	 
	{{ Form::close() }}

@stop

@section('javascripts')

	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}

	<script>

	var new_password = document.getElementById("new_password");
  	var confirm_password = document.getElementById("confirm_password");

  	var n_password = $('#new_password').value;
  	var c_password = $('#confirm_password').value;

	function validatePassword(){
		
		if(new_password.value != confirm_password.value) {

			confirm_password.setCustomValidity("Passwords Don't Match");

		} else {			
			confirm_password.setCustomValidity('');
		}
	}

	new_password.onchange = validatePassword;
	confirm_password.onkeyup = validatePassword;

	</script>

@stop