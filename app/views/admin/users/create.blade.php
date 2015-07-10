@extends('admin._layouts.admin')

@section('content')


	{{ Form::open(array('route'=>'admin.register.user', 'id' => 'register', 'class' => 'small-form')) }}

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
			{{ Form::label('birthdate', trans('global.birthdate')) }}
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