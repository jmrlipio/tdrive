@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style("css/form.css"); }}
	<style>
		#btn_container {text-align: center !important;}
	</style>
@stop

@section('content')

	{{ Form::token() }}

	@if (Session::has('fail'))

	  <p class="flash-fail">{{ Session::get('fail') }}</p>

	@endif

	@if(Session::has('success'))

	  <h3 class="center flash-success">{{ Session::get('success') }}</h3>

	@endif

	<h3 class="center pad_10">{{ trans('global.reset password') }}</h3>
	 
	{{ Form::open(array('route' => 'password.request', 'class' => 'forgot-password', 'id' => 'forgot-password-form')) }}  

		<div class="control">       
			<?php $email = trans('global.email'); ?>
			{{ Form::text('email', null, array('placeholder'=>$email,'required')) }}
		</div>

		<div class="control-item pad_10" id="btn_container">
			 {{ Form::submit('Submit') }}
		</div>
	 
	{{ Form::close() }}

@stop

@section('javascripts')
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}

	@include('_partials/scripts')

	<script>
		var token = $('input[name="_token"]').val();
	</script>
@stop