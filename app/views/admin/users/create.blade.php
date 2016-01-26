@extends('admin._layouts.admin')

@section('content')


	{{ Form::open(array('route'=>'admin.register.user', 'id' => 'register-user', 'class' => 'small-form')) }}
		<h2>Create User</h2>
		<div id="token">{{ Form::token() }}</div>

		<div class="control">
			{{ Form::label('email', 'Email') }}
			{{ Form::text('email', null, array('required')) }}
			{{ $errors->first('email', '<p class="error">:message</p>') }}
		</div>

		<div class="control">
			{{ Form::label('username', 'Username') }}
			{{ Form::text('username', null, array('required')) }}
			{{ $errors->first('username', '<p class="error">:message</p>') }}
		</div>

		<div class="control">
			{{ Form::label('first_name', 'First name') }}
			{{ Form::text('first_name', null, array('required')) }}
			{{ $errors->first('first_name', '<p class="error">:message</p>') }}
		</div>
		
		<div class="control">
			{{ Form::label('last_name', 'Last name') }}
			{{ Form::text('last_name', null, array('required' )) }}
			{{ $errors->first('last_name', '<p class="error">:message</p>') }}
		</div>

		<div class="control">
			{{ Form::label('gender', 'Gender') }}
			{{ Form::select('gender', array('M' => 'Male', 'F' => 'Female'), 'M', array('class'=>'select_gender')) }}
			{{ $errors->first('gender', '<p class="error">:message</p>') }}
		</div>

		<div class="control">
			{{ Form::label('role', 'Role') }}
			{{ Form::select('role', array('member' => 'Member', 'editor' => 'Editor', 'admin' => 'Admin', 'superadmin' => 'Super Admin'), 'member', array('class'=>'select_gender')) }}
			{{ $errors->first('gender', '<p class="error">:message</p>') }}
		</div>

		<div class="control">
			{{ Form::label('birthday', 'Birthdate') }}
			{{ Form::text('birthday', null, array('id' => 'birthday', 'class' => 'datepicker')) }}
			{{ $errors->first('birthday', '<p class="error">:message</p>') }}

		</div>

		<div class="control">
			{{ Form::label('mobile_no', 'Mobile no.') }}
			{{ Form::text('mobile_no', null, array('class' => 'mobile_no','maxlength'=>"12")) }}
			{{ $errors->first('mobile_no', '<p class="error">:message</p>') }}
		</div>
		
		<div class="control">
			{{ Form::label('password', 'Password') }}
			{{ Form::password('password', array('required')) }}
		</div>
		
		{{ $errors->first('password', '<p class="error">:message</p>') }}

		<div class="control">
			{{ Form::label('confirm password', 'Confirm password') }}
			{{ Form::password('password_confirmation') }}
		</div>
		
		<a class="custom-back" href="{{ URL::route('admin.users.index') }}">Back</a>
		{{ Form::submit('Save', array('class' => 'no-radius auto-width')) }}

	{{ Form::close() }}

	

@stop

@section('scripts')

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