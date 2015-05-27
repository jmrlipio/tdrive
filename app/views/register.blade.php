@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style('css/jquery-ui.css') }}
	{{ HTML::style('css/jquery-ui.theme.css') }}
	{{ HTML::style("css/form.css"); }}
	<style>
		#day{ width: 15% !important; }
		#month{ width: 35% !important; }
		#year {	width: 20% !important; }

	</style>
@stop

@section('content')

	{{ Form::token() }}

	<h1 class="title">{{ trans('global.Create new account') }}</h1>

	{{ Form::open(array('route'=>'users.register', 'id' => 'register')) }}

		<div id="token">{{ Form::token() }}</div>

		<div class="control">
			{{ Form::label('email', trans('global.email')) }}
			{{ Form::text('email', null, array('class'=> 'form-control', 'required')) }}
			{{ $errors->first('email', '<p class="error">:message</p>') }}
		</div>

		<div class="control">
			{{ Form::label('username', trans('global.username')) }}
			{{ Form::text('username', null, array('class'=> 'form-control', 'required')) }}
			{{ $errors->first('username', '<p class="error">:message</p>') }}
		</div>

		<div class="control">
			{{ Form::label('first_name', trans('global.first_name')) }}
			{{ Form::text('first_name', null, array('class'=> 'form-control', 'required')) }}
			{{ $errors->first('first_name', '<p class="error">:message</p>') }}
		</div>
		
		<div class="control">
			{{ Form::label('last_name', trans('global.last_name')) }}
			{{ Form::text('last_name', null, array('class'=> 'form-control', 'required' )) }}
			{{ $errors->first('last_name', '<p class="error">:message</p>') }}
		</div>

		<div class="control">
			{{ Form::label('gender', trans('global.gender')) }}
			{{ Form::select('gender', array('M' => 'Male', 'F' => 'Female'), 'M', array('class'=>'select_gender')) }}
			{{ $errors->first('gender', '<p class="error">:message</p>') }}
		</div>

		<div class="control">
			<?php $current_year = date("Y"); ?>
			{{ Form::label('birthday', trans('global.birthday')) }}
			{{ Form::selectMonth('month', 1, ['class' => 'field','id'=>'month']) }}			
			{{ Form::select('day', range(1,31), 0, array('id'=>'day')) }}
			{{ Form::selectYear('year', 1940, $current_year, $current_year, ['class' => 'field','id'=>'year']) }}
			{{ $errors->first('birthday', '<p class="error">:message</p>') }}
			<!-- {{ Form::text('birthday', null, array('id' => 'birthday', 'class' => 'datepicker','placeholder' => 'YYYY-MM-DD')) }}
			{{ $errors->first('birthday', '<p class="error">:message</p>') }} -->
		</div>

		<div class="control">
			{{ Form::label('mobile_no', trans('global.mobile_no')) }}
			{{ Form::text('mobile_no', null, array('class' => 'mobile_no','maxlength'=>"12")) }}
			{{ $errors->first('mobile_no', '<p class="error">:message</p>') }}
		</div>
		
		<div class="control">
			{{ Form::label('password', trans('global.password')) }}
			{{ Form::password('password', array('required')) }}
		</div>
		
		<!--<input class="button button-pink" type="button" value="Generate password" onClick="randomString();"><br/>-->
		
		{{ $errors->first('password', '<p class="error">:message</p>') }}

		<div class="control">
			{{ Form::label('confirm password', trans('global.confirm password')) }}
			{{ Form::password('password_confirmation') }}
		</div>
		
		{{--
		<div class="control">
			{{ Form::label('prof_pic', 'Profile Image:') }}
			{{ Form::file('prof_pic') }}
			{{ $errors->first('homepage_image', '<p class="error">:message</p>') }}
		</div>
		--}}
		
		{{ Form::submit(trans('global.Create new account'), array('class' => 'no-radius')) }}

	{{ Form::close() }}

@stop

@section('javascripts')
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}
	{{ HTML::script('js/jquery-ui.js') }}
	{{ HTML::script('js/form-functions.js') }}
	{{ HTML::script('js/chosen.jquery.js') }}

	@include('_partials/scripts')

	<script>
		var token = $('input[name="_token"]').val();

		$( document ).ready(function() {
			$('.mobile_no').keyup(function () {     
			  if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
			       this.value = this.value.replace(/[^0-9\.]/g, '');
			    }
			});

			/*$(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' }).bind("change",function(){
	            var minValue = $(this).val();
	            minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
	            minValue.setDate(minValue.getDate()+1);
	            $("#to").datepicker( "option", "minDate", minValue );
	    	});*/
		});

	</script>
@stop



	
