@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style('css/jquery-ui.css') }}
	{{ HTML::style('css/jquery-ui.theme.css') }}
	{{ HTML::style("css/form.css"); }}

<style>
	div#btn-link a {
			color: #fff;
			display: block;
		}
		#back {
		  display: block !important;
		  margin-top: 10px;
		}
		#side-menu, #nav-toggle {display: none !important;}
</style>
@stop
<?php 


	(Auth::user()->gender != null) ? $gender = Auth::user()->gender : $gender = 'M';
	(Auth::user()->mobile_no != null) ? $mobile = Auth::user()->mobile_no : $mobile = '1234567890';
	(Auth::user()->birthday != '0000:00:00') ? $birthday = Auth::user()->birthday : $birthday = (new \DateTime())->format('Y-m-d');
 ?>
@section('content')

	{{ Form::token() }}
	@if(Session::has('message'))
	    <div class="flash-success">
	        <p>{{ Session::get('message') }}</p>
	    </div>
	@endif

	<h1 class="title">{{ trans('global.Update Account Details') }}</h1>
	{{ Form::open(array('route'=> array('users.update.account.post', Auth::user()->id), 'id' => 'update')) }}

		<div id="token">{{ Form::token() }}</div>	

		<div class="control">
			{{ Form::label('first_name', trans('global.first_name')) }}
			{{ Form::text('first_name', null, array('class'=> 'form-control', 'required', 'placeholder' => Auth::user()->first_name)) }}
			{{ $errors->first('first_name', '<p class="error">:message</p>') }}
		</div>
		
		<div class="control">
			{{ Form::label('last_name', trans('global.last_name')) }}
			{{ Form::text('last_name', null, array('class'=> 'form-control', 'required', 'placeholder' => Auth::user()->last_name )) }}
			{{ $errors->first('last_name', '<p class="error">:message</p>') }}
		</div>

		<div class="control">
			{{ Form::label('gender', trans('global.gender')) }}
			{{ Form::select('gender', array('M' => 'Male', 'F' => 'Female'), $gender, array('class'=>'select_gender')) }}
			{{ $errors->first('gender', '<p class="error">:message</p>') }}
		</div>

		<div class="control">
			{{ Form::label('birthday', trans('global.birthday')) }}
			{{ Form::text('birthday', null, array('id' => 'birthday', 'class' => 'datepicker','placeholder' => $birthday)) }}
			{{ $errors->first('birthday', '<p class="error">:message</p>') }}
		</div>	

		<div class="control">
			{{ Form::label('mobile_no', trans('global.mobile_no')) }}
			{{ Form::text('mobile_no', null, array('class' => 'mobile_no','maxlength'=>"12", 'placeholder' => $mobile)) }}
			{{ $errors->first('mobile_no', '<p class="error">:message</p>') }}
		</div>
		
		{{ Form::submit(trans('global.Update Account'), array('class' => 'no-radius')) }}

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

			$(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' }).bind("change",function(){
	            var minValue = $(this).val();
	            minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
	            minValue.setDate(minValue.getDate()+1);
	            $("#to").datepicker( "option", "minDate", minValue );
	    	});
		});

	</script>
@stop



	
