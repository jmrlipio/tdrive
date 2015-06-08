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
	#side-menu, #nav-toggle { display: none !important; }
	div#btn-submit { text-align: center; }
	#day{ width: 15% !important; background-color: #fff !important;}
	#month{ width: 35% !important; background-color: #fff !important; }
	#year {	width: 20% !important; background-color: #fff !important; }
	label#birthday { display: block; }
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
			<?php $str = explode("-", $birthday); ?>
			<?php $current_year = date("Y"); ?>
			<!-- 
				=== LEGEND ===
				str[0] = year
				str[1] = month
				str[2] = days 
			-->
			{{ Form::label('birthdate', null , array('id'=>'birthday'), trans('global.birthdate')) }}
			{{ Form::selectMonth('month', $str[1], ['class' => 'field','id'=>'month']) }}
			{{ Form::select('day', range(1,31), $str[2], array('id'=>'day')) }}
			{{ Form::selectYear('year', 1940, $current_year, $str[0], ['class' => 'field','id'=>'year']) }}			
			{{ $errors->first('birthday', '<p class="error">:message</p>') }}

		</div>	

		<div class="control">
			{{ Form::label('mobile_no', trans('global.mobile_no')) }}
			{{ Form::text('mobile_no', null, array('class' => 'mobile_no','maxlength'=>"12", 'placeholder' => $mobile)) }}
			{{ $errors->first('mobile_no', '<p class="error">:message</p>') }}
		</div>
		<div id="btn-submit">
			{{ Form::submit(trans('global.Update Account'), array('class' => 'no-radius')) }}
		</div>
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



	
